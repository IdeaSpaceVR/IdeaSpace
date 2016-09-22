<?php

namespace App\Http\Controllers\Admin;

use App\Theme;
use App\GenericFile;
use App\GenericImage;
use App\Photosphere;
use Image;
use Log;

trait AssetLibraryControllerTrait {


    private $mime_types = [
        'image' => ['image/gif', 'image/jpeg', 'image/png'],
        'video' => ['video/mp4'],
        'audio' => ['audio/mpeg'],
        'model' => ['application/octet-stream'],
        ];


    /**
     * Helper function for displaying php file upload size settings.
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpFileUploadSizeSettings() {

        if (ini_get('upload_max_filesize') !== false && ini_get('upload_max_filesize') != '') {

            $upload_max_filesize = ini_get('upload_max_filesize');
            $upload_max_filesize = str_replace('M', 'MB', $upload_max_filesize);
            $upload_max_filesize = str_replace('G', 'GB', $upload_max_filesize);

            return trans('asset_library_controller.upload_max_filesize', ['upload_max_filesize' => $upload_max_filesize]);
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

            $post_max_size = ini_get('post_max_size');
            $post_max_size = str_replace('M', 'MB', $post_max_size);
            $post_max_size = str_replace('G', 'GB', $post_max_size);

            return trans('asset_library_controller.post_max_size', ['post_max_size' => $post_max_size]);
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
          } else {
              return 0;
          }
        }
        return 0;
    }


    /**
     * Mime type validation.
     *    
     * @param File $file The file.
     * @param string $type The file type.
     *
     * @return True if valid, false otherwise.
     */
    private function validateMimeType($file, $type) {

        $mime_types = $this->mime_types[$type];
        foreach ($mime_types as $mime_type) {
            if ($mime_type === $file->getMimeType()) {
                return true;
            }
        }
        return false;
    }


    /** 
     * Create an image from a given image.
     *
     * @param string $image_uri The original image uri.
     * @param string $new_image_uri The preview image uri.
     * @param int $image_quality
     * @param int $width Optional. The width value of the preview image. It will be scaled to keep the aspect ratio.
     *
     * @return Array Width and height
     */
    private function create_image($image_uri, $new_image_uri, $image_quality = null, $width = null) {

        $image = Image::make($image_uri);

        if ($width == null) {
            $width = $image->width();
        }

        $height = $image->height();


        if ($this->is_power_of_two($width) && $this->is_power_of_two($height)) {

            $image->destroy();
            return ['width' => $width, 'height' => $height];
        }


        if ($width > $height) {

            $width = $this->nearest_power_of_two($width);
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $height = $this->nearest_power_of_two($image->height());
            /* crop and resize */
            $image->fit($width, $height);

        } else if ($width == $height) {

            $width = $this->nearest_power_of_two($width);
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $height = $image->height();

        } else if ($width < $height) {

            $height = $this->nearest_power_of_two($height);
            $image->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $width = $this->nearest_power_of_two($image->width());
            /* crop and resize */
            $image->fit($width, $height);
        }

        //Log::debug($width . ' ' . $height);

        if ($image_quality == null) {
            $image->save($new_image_uri);
        } else {
            $image->save($new_image_uri, $image_quality);
        }

        $image->destroy();

        return ['width' => $width, 'height' => $height];
    }


    /** 
     * Create a square thumbnail image, cropped and resized.
     *
     * @param string $image_uri The original image uri.
     * @param string $thumbnail_image_uri The thumbnail image uri.
     * @param int $width The width value of the thumbnail image.
     *
     * @return void
     */
    private function create_thumbnail_image($image_uri, $thumbnail_image_uri, $width) {

        $image = Image::make($image_uri);

        $image->fit($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($thumbnail_image_uri);
        $image->destroy();
    }


    /**
     * Resize image with size according to nearest power of two.
     *
     * @param String $file_uri
     * @param int $image_quality
     *
     * @return Array Width and height
     */
    /*private function resize_image_nearest_power_of_two($file_uri, $image_quality) {

        $image = Image::make($file_uri);

        if ($this->is_power_of_two($image->width())) {
            $width = $image->width();
        } else {
            $width = $this->nearest_power_of_two($image->width());
        }

        $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($file_uri, $image_quality);
        $height = $image->height();
        $image->destroy();
      
        return ['width' => $width, 'height' => $height];
    }*/


    /**
     * Get nearest power of two value.
     *
     * @param int $value
     *
     * @return int
     */ 
    function nearest_power_of_two($value) {

        return pow(2, floor(log($value) / log(2)));
    }


    /**
     * Is value power of two?.
     *
     * @param int $value
     *
     * @return int
     */ 
    function is_power_of_two($value) {
        return ($value & ($value - 1)) === 0 && $value !== 0;
    }
  

    /**
     * Get file name with suffix. Preserves the file extension.
     *
     * @param String $string The file name or URI.
     * @param String $suffix The suffix to append to file URI.
     *
     * @return New file name with suffix and file extension.
     */
    private function get_file_name($string, $suffix) {
        return substr($string, 0, strrpos($string, '.')) . $suffix . substr($string, strrpos($string, '.'));
    }


    /**
     * Get all images.
     *
     * @return Array
     */
    private function get_all_images() {

        $images = GenericImage::orderBy('updated_at', 'desc')->get();
        $images_result = [];
        foreach ($images as $image) {
            $genericFile = GenericFile::where('id', $image->file_id)->first();
            $img_result['id'] = $image->id;
            $img_result['uri'] = asset($this->get_file_name($genericFile->uri, GenericFile::THUMBNAIL_FILE_SUFFIX));
            $images_result[] = $img_result;
        }
        //Log::debug($images_result);
        return $images_result;
    }


    /**
     * Get all photo spheres.
     *
     * @return Array
     */
    private function get_all_photospheres() {

        $photospheres = Photosphere::orderBy('updated_at', 'desc')->get();
        $photospheres_result = [];
        foreach ($photospheres as $photosphere) {
            $genericFile = GenericFile::where('id', $photosphere->file_id)->first();
            $psphere_result['id'] = $photosphere->id;
            $psphere_result['uri'] = asset($this->get_file_name($genericFile->uri, GenericFile::THUMBNAIL_FILE_SUFFIX));
            $photospheres_result[] = $psphere_result;
        }
        //Log::debug($images_result);
        return $photospheres_result;
    }


    /**
     * Apply image settings.
     *
     * @param String $file_uri_orig
     * @param String $file_uri_new
     * @param Array $image_settings
     * @return void
     */
    /*private function create_image($file_uri_orig, $file_uri_new, $image_settings) {

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
    }*/


}
