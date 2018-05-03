<?php

namespace App\Http\Controllers\Admin;

use App\Theme;
use App\GenericFile;
use App\GenericImage;
use App\Photosphere;
use App\Video;
use App\Videosphere;
use App\Audio;
use App\Model3D;
use Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

trait AssetLibraryControllerTrait {


    private $mime_types = [
        'image' => ['image/gif', 'image/jpeg', 'image/png', 'image/tga', 'image/x-tga', 'image/targa', 'image/x-targa'],
        'video' => ['video/mp4'],
        'audio' => ['audio/mpeg', 'audio/mp3', 'audio/x-wav', 'audio/wav'],
        'model' => ['text/plain', 'model/vnd.collada+xml', 'application/octet-stream', 'application/xml', 'image/jpeg', 'image/png', 'image/gif', 'image/tga', 'image/x-tga', 'image/targa', 'image/x-targa', 'model/gltf.binary'],
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
     * @param Boolean $keep_original_dimension Optional. If true, original image dimensions are kept.
     *
     * @return Array Width and height
     */
    private function create_image($image_uri, $new_image_uri, $image_quality = null, $width = null, $keep_original_dimension = false) {

        $image = Image::make($image_uri);

        if ($width == null) {
            $width = $image->width();
        }

        $height = $image->height();


				if ($keep_original_dimension) {

						$image->destroy();
            return ['width' => $width, 'height' => $height];
				}


        if ($this->is_power_of_two($width) && $this->is_power_of_two($height)) {

            $image->destroy();
            return ['width' => $width, 'height' => $height];
        }


        /* set memory limit for resize operations */      
        ini_set('memory_limit', '256M');


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
            $img_result = [];
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
            $psphere_result = [];
            $psphere_result['id'] = $photosphere->id;
            $psphere_result['uri'] = asset($this->get_file_name($genericFile->uri, GenericFile::THUMBNAIL_FILE_SUFFIX));
            $photospheres_result[] = $psphere_result;
        }

        return $photospheres_result;
    }


    /**
     * Get all videos.
     *
     * @return Array
     */
    private function get_all_videos() {

        $videos = Video::orderBy('updated_at', 'desc')->get();
        $videos_result = [];
        foreach ($videos as $video) {
            $genericFile = GenericFile::where('id', $video->file_id)->first();
            $video_result = [];
            $video_result['id'] = $video->id;
            $video_result['uri'] = asset($genericFile->uri);
            //$video_result['width'] = $video->width;
            //$video_result['height'] = $video->height;
            $videos_result[] = $video_result;
        }

        return $videos_result;
    }


    /**
     * Get all video spheres.
     *
     * @return Array
     */
    private function get_all_videospheres() {

        $videospheres = Videosphere::orderBy('updated_at', 'desc')->get();
        $videospheres_result = [];
        foreach ($videospheres as $videosphere) {
            $genericFile = GenericFile::where('id', $videosphere->file_id)->first();
            $videosphere_result = [];
            $videosphere_result['id'] = $videosphere->id;
            $videosphere_result['uri'] = asset($genericFile->uri);
            $videospheres_result[] = $videosphere_result;
        }

        return $videospheres_result;
    }


    /**
     * Get all audio files.
     *
     * @return Array
     */
    private function get_all_audiofiles() {

        $audiofiles = Audio::orderBy('updated_at', 'desc')->get();
        $audiofiles_result = [];
        foreach ($audiofiles as $audiofile) {
            $genericFile = GenericFile::where('id', $audiofile->file_id)->first();
            $audiofile_result = [];
            $audiofile_result['id'] = $audiofile->id;
            $audiofile_result['uri'] = asset($genericFile->uri);
            $audiofile_result['caption'] = str_limit($audiofile->caption, 40);
            $audiofiles_result[] = $audiofile_result;
        }

        return $audiofiles_result;
    }


    /**
     * Get all models (model preview images).
     *
     * @return Array
     */
    private function get_all_models() {

        $models = Model3D::orderBy('updated_at', 'desc')->get();
        $models_result = [];
        foreach ($models as $model) {
            try {
                /* get model preview image, if available */
                $genericFile = GenericFile::where('id', $model->file_id_preview)->firstOrFail();
                $model_result = [];
                $model_result['id'] = $model->id;
                $model_result['uri'] = asset($genericFile->uri);

                $models_result[] = $model_result;

            } catch (ModelNotFoundException $e) {

                $model_result = [];
                $model_result['id'] = $model->id;
                $model_result['uri'] = asset('public/assets/admin/asset-library/images/model-screenshot-broken.png');

                $models_result[] = $model_result;
            }

        }

        return $models_result;
    }

}
