<?php

namespace App;

use App\GenericFile;
use App\Theme;
use App\FieldControl;
use App\FieldDataImage;
use App\FieldDataText;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use File;

trait SpaceTrait 
{

    /**
     * Prepate space variables for template.
     *
     * @param Space $space The space.
     * @param bool $preview True if preview.
     *
     * @return String $vars
     */
    private function prepare_space_vars($space, $preview = false) {

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [
            'space_url' => url($space->uri) . (($preview==false)?'':'/preview'),
            'space_title' => $space->title,
            'theme_dir' => $theme->root_dir,
            'content' => []
        ];

        $field_controls = FieldControl::where('space_id', $space->id)->get();
        foreach ($field_controls as $field_control) {
            switch($field_control->type) {
                case Theme::TYPE_IMAGES:
                    $field_data_images = FieldDataImage::where('field_control_id', $field_control->id)->orderBy('weight', 'desc')->get();
                    foreach ($field_data_images as $field_data_image) {
                        $generic_file = GenericFile::where('id', $field_data_image->file_id)->first();
                        $arr = ['image' => asset($generic_file->uri)];
                        $image_thumb = $this->get_file_uri($generic_file->uri, '_thumb');
                        if (File::exists($image_thumb)) {
                            $arr['image-thumbnail'] = asset($image_thumb);
                        }
                        $vars['content'][$field_control->key]['type'] = Theme::TYPE_IMAGES;
                        $vars['content'][$field_control->key]['data'][] = $arr;
                    }
                    break;
                case Theme::TYPE_IMAGE:

                    break;
                case Theme::TYPE_MODEL:

                    break;
                case Theme::TYPE_MODELS:

                    break;
                case Theme::TYPE_TEXTINPUT:
                    $field_data_text = FieldDataText::where('field_control_id', $field_control->id)->first();
                    $vars['content'][$field_control->key]['type'] = Theme::TYPE_TEXTINPUT;
                    $vars['content'][$field_control->key]['data'][] = $field_data_text->text;
                    break;
                case Theme::TYPE_TEXTAREA:
                    $field_data_text = FieldDataText::where('field_control_id', $field_control->id)->first();
                    $vars['content'][$field_control->key]['type'] = Theme::TYPE_TEXTAREA;
                    $vars['content'][$field_control->key]['data'][] = $field_data_text->text;
                    break;
                case Theme::TYPE_AUDIO:

                    break;
                case Theme::TYPE_VIDEO:

                    break;
            } /* end: switch */
        }

        view()->addNamespace('theme', base_path($theme->root_dir . '/' . Theme::TEMPLATES_DIR));

        return $vars;
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

