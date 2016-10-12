<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use App\GenericFile;
use App\Videosphere;
use App\Setting;
use Auth;
use File;
use Log;

class AssetLibraryVideospheresController extends Controller {


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
            'videospheres' => $this->get_all_videospheres()
        ];

        return view('admin.asset_library.videospheres', $vars);
    }


    /**
     * Videospheres upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_videospheres(Request $request) {

        if (!$request->hasFile('file')) {
            abort(404);
        }

        $file = $request->file('file');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'video')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_videospheres_controller.wrong_file_type')]);
        }

        do {
            $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
            $existingName = GenericFile::where('filename', $newName)->first();
        } while ($existingName !== null);

        $uri = Videosphere::VIDEOSPHERE_STORAGE_PATH . $newName;
        $filename_orig = $file->getClientOriginalName();

        $success = $file->move(Videosphere::VIDEOSPHERE_STORAGE_PATH, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_videospheres_controller.file_moving_error')]);
        }


        $getID3 = new \getID3;
        $analyze = $getID3->analyze($uri);
        $video_duration = $analyze['playtime_string'];
        $video_width = $analyze['video']['resolution_x'];
        $video_height = $analyze['video']['resolution_y'];
        //$analyze['filesize'];

        $user = Auth::user();

        $newFile = GenericFile::create([
            'user_id' => $user->id,
            'filename' => $newName,
            'uri' => $uri,
            'filemime' => $file->getClientMimeType(),
            'filesize' => $file->getClientSize(),
            'filename_orig' => $filename_orig
        ]);

        $videosphere = Videosphere::create([
            'user_id' => $user->id,
            'file_id' => $newFile->id,
            'caption' => '',
            'description' => '',
            'duration' => $video_duration,
            'width' => $video_width,
            'height' => $video_height
            //'data' => ''
        ]);


        return response()->json([
            'status' => 'success',
            'uri' => asset($uri),
            'videosphere_id' => $videosphere->id
        ]);
    }


    /**
     * Get localization strings for videosphere uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_videospheres_controller.file_type_error'),
            'file_size_error' => trans('asset_library_videospheres_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_videospheres_controller.file_ext_error'),
            'vr_view' => trans('template_asset_library_videospheres.vr_view'),
            'edit' => trans('template_asset_library_videospheres.edit'),
            'insert' => trans('template_asset_library_videospheres.insert'),
            'save' => trans('template_asset_library_videospheres.save'),
            'saved' => trans('template_asset_library_videospheres.saved'),
        ]);
    }


    /**
     * Videosphere edit page.
     *
     * @param int $videosphere_id
     *
     * @return Response
     */
    public function videosphere_edit($videosphere_id) {

        if ($videosphere_id == null) {
            abort(404);
        }

        try {
            $videosphere = Videosphere::where('id', $videosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $videosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [];
        $vars['id'] = $videosphere->id;
        $vars['caption'] = $videosphere->caption;
        $vars['description'] = $videosphere->description;
        $vars['dimensions'] = $videosphere->width . ' x ' . $videosphere->height;
        $vars['duration'] = $videosphere->duration;
        $vars['uploaded_on'] = $videosphere->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['videosphere_id'] = $videosphere_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.videosphere_edit', $vars);
    }


    /**
     * Video sphere edit save.
     *
     * @param Request $request
     * @param int $videosphere_id
     *
     * @return Response
     */
    public function videosphere_edit_save(Request $request, $videosphere_id) {

        if ($videosphere_id == null) {
            abort(404);
        }

        try {
            $videosphere = Videosphere::where('id', $videosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $videosphere->caption = $request->input('caption');
        $videosphere->description = $request->input('description');
        $videosphere->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * Video sphere edit delete.
     *
     * @param Request $request
     * @param int $videosphere_id
     *
     * @return Response
     */
    public function videosphere_edit_delete(Request $request, $videosphere_id) {

        if ($videosphere_id == null) {
            abort(404);
        }

        try {
            $videosphere = Videosphere::where('id', $videosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $videosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $uri = $genericFile->uri;

        File::delete($uri);

        $videosphere->delete();
        $genericFile->delete();

        return response()->json(['status' => 'success', 'videosphere_id' => $videosphere_id]);
   }


    /**
     * Video sphere vr view page.
     *
     * @param int $videosphere_id
     *
     * @return Response
     */
    public function videosphere_vr_view($videosphere_id) {

        if ($videosphere_id == null) {
            abort(404);
        }

        try {
            $videosphere = Videosphere::where('id', $videosphere_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $videosphere->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        /* calculate aspect ratio for a-frame */
        $width = $videosphere->width;
        $height = $videosphere->height;
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
        $vars['id'] = $videosphere->id;
        $vars['dimensions'] = $videosphere->width . ' x ' . $videosphere->height;
        $vars['duration'] = $videosphere->duration;
        $vars['width'] = $width;
        $vars['height'] = $height;
        $vars['width_meter'] = $width_meter;
        $vars['height_meter'] = $height_meter;
        $vars['uploaded_on'] = $videosphere->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['videosphere_id'] = $videosphere_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.videosphere_vr_view', $vars);
    }


}


