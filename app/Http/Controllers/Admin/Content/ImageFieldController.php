<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Event;
use App\GenericFile;
use Auth;
use File;
use Image;
use Validator;
use Log;

class ImageFieldController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
        $this->middleware('register.theme.eventlistener');
    }


    /**
     * Delete an image via jQuery.
     *
     * @return Response
     */
    public function space_media_images_delete(Request $request)
    {
        if ($request->has('image_id') && $request->has('ref_id')) {

            $image_id = $request->input('image_id');
            $image_id = substr(strrchr($image_id, '-'), 1);

            $ref_id = $request->input('ref_id');
            $ref_id = substr(strrchr($ref_id, '-'), 1);

            $user = Auth::user();

            try {
                $genericFile = GenericFile::where('id', $ref_id)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return redirect()->route('space_add');
            } 

            try {
                $field_data_image = FieldDataImage::where('file_id', $ref_id)->firstOrFail();
                $field_data_image->delete();
                $field_control = FieldControl::where('id', $field_data_image->field_control_id)->firstOrFail();
                if ($field_control->type == Theme::TYPE_IMAGES) {
                    /* of type images but no images in field data images table anymore, field control entry can be deleted as well */
                    try {
                        FieldDataImage::where('space_id', $field_data_image->space_id)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        $field_control->delete();
                    } 
                }
            } catch (ModelNotFoundException $e) {

            } 

            if (File::exists($genericFile->uri)) {

                File::delete($genericFile->uri);

                /* delete preview images */
                //$thumbnail_uri = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . '_preview' . substr($genericFile->uri, strrpos($genericFile->uri, '.'));
                $image_preview_uri = $this->get_file_uri($genericFile->uri, '_preview');
                if (File::exists($image_preview_uri)) {
                    File::delete($image_preview_uri);
                }

                /* delete thumbnails */
                //$thumbnail_uri = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . '_thumb' . substr($genericFile->uri, strrpos($genericFile->uri, '.'));
                $thumbnail_uri = $this->get_file_uri($genericFile->uri, '_thumb');
                if (File::exists($thumbnail_uri)) {
                    File::delete($thumbnail_uri);
                }

                $genericFile->delete();

                return response()->json(['status' => 'success', 'message' => 'Image file deleted.', 'image_id' => $image_id]);

            } else {
                return response()->json(['status' => 'error', 'message' => 'There was an error when deleting the image.', 'image_id' => $image_id]);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'There was an error when deleting the image.', 'image_id' => $image_id]);
        }
    }


    /**
     * Images upload via jQuery.
     *
     * @return Response
     */
    public function space_media_images_add(Request $request)
    {
        if ($request->hasFile('file') && $request->has('type')) {
            
            $file = $request->file('file');
            $type = $request->input('type');

            /* verify control type and file mime type */
            if ($this->validControlType($file, $type)) {

                do {
                    $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
                    $existingName = GenericFile::where('filename', $newName)->first();
                } while ($existingName !== null);

                $uri = $this->image_path . $newName;

                $filename_orig = $file->getClientOriginalName();

                $success = $file->move($this->image_path, $newName);
 
                if (!$success) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong while moving the file. Please check your directory configuration.']);
                }  

                /* image width and height must be power of two; resize image */
                $this->create_image_nearest_power_of_two($uri, $uri);

                /* fire event */
                $image_settings = Event::fire('media.image.manipulation', $uri);

                /* create image from settings */
                if (!empty($image_settings)) {
                    $this->create_image($uri, $uri, $image_settings[0]);
                }

                /* fire event */
                Event::fire('media.image.save_pre', $uri);

                $user = Auth::user();

                $newFile = GenericFile::create([
                    'user_id' => $user->id,
                    'filename' => $newName,
                    'uri' => $uri,
                    'filemime' => $file->getClientMimeType(),
                    'filesize' => $file->getClientSize(),
                    'filename_orig' => $filename_orig,
                    'status' => GenericFile::STATUS_PUBLISHED
                ]);

                /* fire event */
                Event::fire('media.image.save', $uri);

                /* create preview image */
                //$newName = substr($newName, 0, strrpos($newName, '.')) . '_preview' . substr($newName, strrpos($newName, '.'));
                $newNamePreview = $this->get_file_uri($newName, '_preview');
                $preview_image_uri = $this->image_path . $newNamePreview;

                /* thumbnail images are shown in the web interface, no need to convert size according to power of two principle */
                $this->create_image($uri, $preview_image_uri, array('width' => '400'));


                /* fire event */
                $thumbnail_settings = Event::fire('media.image.thumbnail.manipulation', $uri);

                if (!empty($thumbnail_settings)) {

                    //$newName = substr($newName, 0, strrpos($newName, '.')) . '_thumb' . substr($newName, strrpos($newName, '.'));
                    $newName = $this->get_file_uri($newName, '_thumb');
                    $thumbnail_uri = $this->image_path . $newName;

                    /* create image from settings */
                    $this->create_image($uri, $thumbnail_uri, $thumbnail_settings[0]);

                    /* we don't save thumbnail images into the DB */
                }

                return response()->json(['status' => 'success', 'message' => 'Upload successful.', 'uri' => asset($preview_image_uri), 'delete_text' => 'Delete', 'ref_id' => $newFile->id]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Wrong file type. Image file type is required. Please try again.']);
            } /* end: is valid control type */

        }

    }


    /**
     * Mime type and control type validation.
     *
     * @param File $file The file.
     * @param string $type The control type.
     *
     * @return True if valid, false otherwise. 
     */
    private function validControlType($file, $type) {
        //Log::debug($file->getMimeType());
        $mime_types = $this->control_types[$type];
        foreach ($mime_types as $mime_type) {
            if ($mime_type === $file->getMimeType()) {
                return true;
            }
        }
        return false;
    }


    /**
     * Helper function for displaying php file upload size settings. 
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpFileUploadSizeSettings() {

        if (ini_get('upload_max_filesize') !== false && ini_get('upload_max_filesize') != '') {
            return '<br>(Max. Upload File Size: ' . str_replace('M', 'MB', ini_get('upload_max_filesize')) . ') <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" rel="tooltip" title="You can configure this setting in your php configuraton file (php.ini). Ask your web administrator for help."></span>';
        } 
        return '';
    }

    
    /**
     * Helper function for displaying php post max size settings.
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpPostMaxSizeSettings() {
       
        if (ini_get('post_max_size') !== false && ini_get('post_max_size') != '') {
            return '<br>(Max. Post Size: ' . str_replace('M', 'MB', ini_get('post_max_size')) . ') <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" rel="tooltip" title="You can configure this setting in your php configuration file (php.ini). Ask your web administrator for help."></span>';
        } 
        return '';
    }


    /**
     * Helper function for getting maximum file upload size in bytes.
     *
     * @return Bytes string if setting exists.
     */ 
    private function phpFileUploadSizeInBytes() {

      if (ini_get('upload_max_filesize') !== false) {

        $filesize = ini_get('upload_max_filesize');

        if (substr($filesize, -1) == 'M') {

          return substr($filesize, 0, -1) * 1024 * 1024;

        } else if (substr($filesize, -1) == 'G') {

          return substr($filesize, 0, -1) * 1024 * 1024 * 1024;
        }
      }
      return 0;
    }
 
    /**
     * Apply image settings.
     *
     * @param String $file_uri_orig
     * @param String $file_uri_new
     * @param Array $image_settings
     * @return void 
     */
    private function create_image($file_uri_orig, $file_uri_new, $image_settings) {

        /* image quality */
        $quality = 90;
        if (array_has($image_settings, 'quality')) {
            $quality = $image_settings['quality'];
        } 

        if (array_has($image_settings, 'width') && array_has($image_settings, 'height')) {

            $file = Image::make($file_uri_orig)->resize($image_settings['width'], $image_settings['height']);
            $file->save($file_uri_new, $quality);
            $file->destroy();

        } else if (array_has($image_settings, 'width')) {

            $file = Image::make($file_uri_orig)->resize($image_settings['width'], null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save($file_uri_new, $quality);
            $file->destroy();

        } else if (array_has($image_settings, 'height')) {

            $file = Image::make($file_uri_orig)->resize(null, $image_settings['height'], function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save($file_uri_new, $quality);
            $file->destroy();

        } else if (array_has($image_settings, 'quality')) {

            $file = Image::make($file_uri_orig);
            $file->save($file_uri_new, $quality);
            $file->destroy();
        }
    }


    /**
     * Resize image with size according to nearest power of two.
     *
     * @param String $file_uri_orig
     * @param String $file_uri_new
     * @return void 
     */
    private function create_image_nearest_power_of_two($file_uri_orig, $file_uri_new) {

        $image = Image::make($file_uri_orig);

        if (is_power_of_two($image->width())) {
            $width = $image->width();
        } else {
            $width = nearest_power_of_two($image->width());
        }

        $setting = Setting::where('key', 'MAX_IMAGE_WIDTH')->first();
        $width = (($width<=$setting->value)?$width:$setting->value);

        $image_settings = [
            'width' => $width
        ];

        $this->create_image($file_uri_orig, $file_uri_new, $image_settings);
    }


    /**
     * Get file URI with suffix. Preserves the file extension.
     * 
     * @param String $uri The file URI.
     * @param String $suffix The suffix to append to file URI.
     *
     * @return New file URI with suffix and file extension.
     */
    private function get_file_uri($uri, $suffix) {
        return substr($uri, 0, strrpos($uri, '.')) . $suffix . substr($uri, strrpos($uri, '.'));        
    }




}
