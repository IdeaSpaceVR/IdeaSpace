<?php

namespace App\Http\Controllers\Admin;

use App\Theme;

trait AssetLibraryControllerTrait {


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


}
