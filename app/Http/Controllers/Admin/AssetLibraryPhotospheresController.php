<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use App\GenericFile;
use App\Photosphere;
use App\Setting;
use Auth;
use File;
use Log;

class AssetLibraryPhotospheresController extends Controller {


    use AssetLibraryControllerTrait;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }


    /**
     * Asset library index page.
     *
     * @return Response
     */
    public function index() {

        $vars = [
            'upload_max_filesize' => $this->phpFileUploadSizeSettings(),
            'upload_max_filesize_tooltip' => trans('asset_library_controller.upload_max_filesize_tooltip'),
            'post_max_size' => $this->phpPostMaxSizeSettings(),
            'max_filesize_bytes' => $this->phpFileUploadSizeInBytes(),
            'photospheres' => $this->get_all_photospheres()
        ];

        return view('admin.asset_library.photospheres', $vars);
    }


    /**
     * Photospheres upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_photospheres(Request $request) {

				//Log::debug($request);

        if (!$request->hasFile('file')) {
            abort(404);
        }

        $file = $request->file('file');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'image')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_photospheres_controller.wrong_file_type')]);
        }

        do {
            $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
            $existingName = GenericFile::where('filename', $newName)->first();
        } while ($existingName !== null);

        $uri = Photosphere::PHOTOSPHERE_STORAGE_PATH . $newName;
        $filename_orig = $file->getClientOriginalName();

        $success = $file->move(Photosphere::PHOTOSPHERE_STORAGE_PATH, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_photospheres_controller.file_moving_error')]);
        }


        /* image width and height must be power of two; resize image if needed; keep aspect ratio */
        if ($request->has('resize_photosphere') && $request->input('resize_photosphere') == 'true') {
						/* resize, do not keep original dimension */
        		$width_height_arr = $this->create_image($uri, $uri, null, null, false);
				} else {
						/* keep original dimension */
        		$width_height_arr = $this->create_image($uri, $uri, null, null, true);
				}


        $user = Auth::user();

        $newFile = GenericFile::create([
            'user_id' => $user->id,
            'filename' => $newName,
            'uri' => $uri,
            'filemime' => $file->getClientMimeType(),
            'filesize' => $file->getClientSize(),
            'filename_orig' => $filename_orig
        ]);

        $photosphere = Photosphere::create([
            'user_id' => $user->id,
            'file_id' => $newFile->id,
            'caption' => '',
            'description' => '',
            'width' => $width_height_arr['width'],
            'height' => $width_height_arr['height']
            //'data' => ''
        ]);


        /* thumbnail images are shown in the asset library and space content edit pages; they are not stored in DB */
        $newNameThumbnail = $this->get_file_name($newName, GenericFile::THUMBNAIL_FILE_SUFFIX);
        $thumbnail_image_uri = Photosphere::PHOTOSPHERE_STORAGE_PATH . $newNameThumbnail;
        $this->create_thumbnail_image($uri, $thumbnail_image_uri, 300);


        return response()->json([
            'status' => 'success',
            'uri' => asset($thumbnail_image_uri),
            'photosphere_id' => $photosphere->id
        ]);
    }


    /**
     * Get localization strings for photo sphere uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_photospheres_controller.file_type_error'),
            'file_size_error' => trans('asset_library_photospheres_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_photospheres_controller.file_ext_error'),
            'vr_view' => trans('template_asset_library_photospheres.vr_view'),
            'edit' => trans('template_asset_library_photospheres.edit'),
            'insert' => trans('template_asset_library_photospheres.insert'),
            'save' => trans('template_asset_library_photospheres.save'),
            'saved' => trans('template_asset_library_photospheres.saved'),
        ]);
    }


    /**
     * Photo sphere edit page.
     *
     * @param int $photosphere_id
     *
     * @return Response
     */
    public function photosphere_edit($photosphere_id) {

        if ($photosphere_id == null) {
            abort(404);
        }

        try {
            $photosphere = Photosphere::where('id', $photosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $photosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [];
        $vars['id'] = $photosphere->id;
        $vars['caption'] = $photosphere->caption;
        $vars['description'] = $photosphere->description;
        $vars['dimensions'] = $photosphere->width . ' x ' . $photosphere->height;
        $vars['uploaded_on'] = $photosphere->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['photosphere_id'] = $photosphere_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.photosphere_edit', $vars);
    }


    /**
     * Photo sphere edit save.
     *
     * @param Request $request
     * @param int $photosphere_id
     *
     * @return Response
     */
    public function photosphere_edit_save(Request $request, $photosphere_id) {

        if ($photosphere_id == null) {
            abort(404);
        }

        try {
            $photosphere = Photosphere::where('id', $photosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $photosphere->caption = $request->input('caption');
        $photosphere->description = $request->input('description');
        $photosphere->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * Photo sphere edit delete.
     *
     * @param Request $request
     * @param int $photosphere_id
     *
     * @return Response
     */
    public function photosphere_edit_delete(Request $request, $photosphere_id) {

        if ($photosphere_id == null) {
            abort(404);
        }

        try {
            $photosphere = Photosphere::where('id', $photosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $photosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $uri = $genericFile->uri;
        $thumbnail_uri = $this->get_file_name($uri, GenericFile::THUMBNAIL_FILE_SUFFIX);

        File::delete($uri);
        File::delete($thumbnail_uri);

        $photosphere->delete();
        $genericFile->delete();

        return response()->json(['status' => 'success', 'photosphere_id' => $photosphere_id]);
    }


    /**
     * Photo sphere vr view page.
     *
     * @param int $photosphere_id
     *
     * @return Response
     */
    public function photosphere_vr_view($photosphere_id) {

        if ($photosphere_id == null) {
            abort(404);
        }

        try {
            $photosphere = Photosphere::where('id', $photosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $photosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        /* calculate aspect ratio for a-frame */
        $width = $photosphere->width;
        $height = $photosphere->height;
        if ($width > $height) {
            $width_meter = $width / $height;
            $height_meter = 1;
        } else if ($width < $height) {
            $height_meter = $height / $width;
            $width_meter = 1;
        } else if ($width == $height) {
            $width_meter = 1;
            $height_meter = 1;
        }


        $vars = [];
        $vars['id'] = $photosphere->id;
        //$vars['caption'] = $photosphere->caption;
        //$vars['description'] = $photosphere->description;
        $vars['dimensions'] = $photosphere->width . ' x ' . $photosphere->height;
        $vars['width'] = $width;
        $vars['height'] = $height;
        $vars['width_meter'] = $width_meter;
        $vars['height_meter'] = $height_meter;
        $vars['uploaded_on'] = $photosphere->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['photosphere_id'] = $photosphere_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.photosphere_vr_view', $vars);
    }


}


