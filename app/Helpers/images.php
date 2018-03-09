<?php

/**
 * Generates and saves images based on settings.
 *
 * @param String $uri
 * @param Array $image_settings
 * @param int $field_id
 */
function generate_images($uri, $image_settings, $field_id) {

    $images_info = [];

    foreach ($image_settings as $image_settings_key => $image_settings_value) {

        foreach ($image_settings_value as $image_setting_name => $value) {    

            $image = Image::make($uri);
            //Log::debug($image_setting_name);

            foreach ($value as $image_operation_key => $image_operation_settings) {

                //Log::debug($image_operation_key);
                //Log::debug($image_operation_settings);
                switch (strtolower($image_operation_key)) {

                    case 'resize':
                        if (is_null($image_operation_settings['width']) || is_null($image_operation_settings['height'])) {
                            $image->resize($image_operation_settings['width'], $image_operation_settings['height'], function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } else {
                            $image->resize($image_operation_settings['width'], $image_operation_settings['height']);
                        }
                        break;

                    case 'greyscale':
                        $image->greyscale();
                        break;

                    case 'crop':
                        if (isset($image_operation_settings['x']) && isset($image_operation_settings['y'])) {
                            $image->crop($image_operation_settings['width'], $image_operation_settings['height'], $image_operation_settings['x'], $image_operation_settings['y']);
                        } else {
                            $image->crop($image_operation_settings['width'], $image_operation_settings['height']);
                        }
                        break;

                    case 'fit':
                        $image->fit($image_operation_settings['width'], $image_operation_settings['height']);
                        break;
                }
            }

            $path_parts = pathinfo($uri);

            $new_uri = $path_parts['dirname'] . '/' . $path_parts['filename'] . '_' . $field_id . '_' . strtolower($image_setting_name) . '.' . $path_parts['extension'];
        
            $image->save($new_uri);

            $image->destroy();

            $images_info[\App\Theme::THEME_GENERATED_IMAGES][$image_setting_name] = $path_parts['filename'] . '_' . $field_id . '_' . strtolower($image_setting_name) . '.' . $path_parts['extension'];
        }
    }

    if (empty($images_info)) {
        $images_info = null;
    }
    return $images_info;
}
