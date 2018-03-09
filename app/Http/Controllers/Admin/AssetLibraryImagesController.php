<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use App\GenericFile;
use App\GenericImage;
use App\Setting;
use Auth;
use Image;
use File;
use Log;

class AssetLibraryImagesController extends Controller {


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
            'images' => $this->get_all_images()
        ];

        return view('admin.asset_library.images', $vars);
    }


    /**
     * Images upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_images(Request $request) {

        if (!$request->hasFile('file')) {
            abort(404);
        }

        $file = $request->file('file');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'image')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_images_controller.wrong_file_type')]);
        }


				$is_gif_image = false;
				if ($file->getMimeType() == 'image/gif') {
						$is_gif_image = true;
				}


        do {
            $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
            $existingName = GenericFile::where('filename', $newName)->first();
        } while ($existingName !== null);

        $uri = GenericImage::IMAGE_STORAGE_PATH . $newName;
        $filename_orig = $file->getClientOriginalName();

        $success = $file->move(GenericImage::IMAGE_STORAGE_PATH, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_images_controller.file_moving_error')]);
        }


				/* ignore gif images because most of the time they are animated and resizing the image destroys the animation */
				if ($is_gif_image) {
						$image = Image::make($uri);
						$width_height_arr = ['width' => $image->width(), 'height' => $image->height()];
				} else {
        		/* image width and height must be power of two; resize image if needed; keep aspect ratio */
        		$width_height_arr = $this->create_image($uri, $uri);
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

        $genericImage = GenericImage::create([
            'user_id' => $user->id,
            'file_id' => $newFile->id,
            'caption' => '',
            'description' => '',
            'width' => $width_height_arr['width'],
            'height' => $width_height_arr['height']
            //'data' => ''
        ]);

        /* will be generated during space content save, if theme defines a preview image rule */
        /* preview images are shown in a theme; they are not stored in DB */
        /*$setting = Setting::where('key', 'PREVIEW_IMAGE_WIDTH')->first();
        $newNamePreview = $this->get_file_name($newName, GenericFile::PREVIEW_FILE_SUFFIX);
        $preview_image_uri = GenericImage::IMAGE_STORAGE_PATH . $newNamePreview;
        $this->create_image($uri, $preview_image_uri, $setting->value);
        */


        /* thumbnail images are shown in the asset library and space content edit pages; they are not stored in DB */ 
        $newNameThumbnail = $this->get_file_name($newName, GenericFile::THUMBNAIL_FILE_SUFFIX);
        $thumbnail_image_uri = GenericImage::IMAGE_STORAGE_PATH . $newNameThumbnail;
        $this->create_thumbnail_image($uri, $thumbnail_image_uri, 300);


        return response()->json([
            'status' => 'success', 
            'uri' => asset($thumbnail_image_uri), 
            'image_id' => $genericImage->id
        ]);
    }


    /**
     * Get localization strings for image uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_images_controller.file_type_error'),
            'file_size_error' => trans('asset_library_images_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_images_controller.file_ext_error'),
            'vr_view' => trans('template_asset_library_images.vr_view'),
            'edit' => trans('template_asset_library_images.edit'),
            'insert' => trans('template_asset_library_images.insert'),
            'save' => trans('template_asset_library_images.save'),
            'saved' => trans('template_asset_library_images.saved'),
        ]);
    }


    /**
     * Image edit page.
     *
     * @param int $image_id
     *
     * @return Response
     */
    public function image_edit($image_id) {

        if ($image_id == null) {
            abort(404);
        }

        try {
            $genericImage = GenericImage::where('id', $image_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $genericImage->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [];
        $vars['id'] = $genericImage->id;        
        $vars['caption'] = $genericImage->caption;        
        $vars['description'] = $genericImage->description;        
        $vars['dimensions'] = $genericImage->width . ' x ' . $genericImage->height;        
        $vars['uploaded_on'] = $genericImage->created_at->format('F d, Y'); 
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';        
        $vars['file_type'] = $genericFile->filemime;        
        $vars['image_id'] = $image_id;        
        $vars['uri'] = asset($genericFile->uri);        

        return view('admin.asset_library.image_edit', $vars);
    }


    /**
     * Image edit save.
     *
     * @param Request $request
     * @param int $image_id
     *
     * @return Response
     */
    public function image_edit_save(Request $request, $image_id) {

        if ($image_id == null) { 
            abort(404);
        }

        try {
            $genericImage = GenericImage::where('id', $image_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        
        $genericImage->caption = $request->input('caption');
        $genericImage->description = $request->input('description');
        $genericImage->save(); 

        return response()->json(['status' => 'success']);
    }


    /**
     * Image edit delete.
     *
     * @param Request $request
     * @param int $image_id
     *
     * @return Response
     */
    public function image_edit_delete(Request $request, $image_id) {

        if ($image_id == null) {
            abort(404);
        }

        try {
            $genericImage = GenericImage::where('id', $image_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $genericImage->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $uri = $genericFile->uri;
        $thumbnail_uri = $this->get_file_name($uri, GenericFile::THUMBNAIL_FILE_SUFFIX);

        File::delete($uri);
        File::delete($thumbnail_uri);

        $genericImage->delete(); 
        $genericFile->delete(); 

        return response()->json(['status' => 'success', 'image_id' => $image_id]);
    }


    /**
     * Image vr view page.
     *
     * @param int $image_id
     *
     * @return Response
     */
    public function image_vr_view($image_id) {

        if ($image_id == null) {
            abort(404);
        }

        try {
            $genericImage = GenericImage::where('id', $image_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $genericImage->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        /* calculate aspect ratio for a-frame */
        $width = $genericImage->width;
        $height = $genericImage->height;
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
        $vars['id'] = $genericImage->id;        
        //$vars['caption'] = $genericImage->caption;        
        //$vars['description'] = $genericImage->description;        
        $vars['dimensions'] = $genericImage->width . ' x ' . $genericImage->height;        
        $vars['width'] = $width;        
        $vars['height'] = $height;        
        $vars['width_meter'] = $width_meter;        
        $vars['height_meter'] = $height_meter;   
        $vars['uploaded_on'] = $genericImage->created_at->format('F d, Y'); 
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';        
        $vars['file_type'] = $genericFile->filemime;        
        $vars['image_id'] = $image_id;        
        $vars['uri'] = asset($genericFile->uri);        

        return view('admin.asset_library.image_vr_view', $vars);
    }


}


