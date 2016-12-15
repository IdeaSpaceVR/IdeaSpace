<?php

namespace App\Http\Controllers;

use App\GenericFile;
use App\Theme;
use App\FieldControl;
use App\FieldDataImage;
use App\FieldDataText;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use File;
use App\Content;
use Log;

trait SpaceTrait {

    /**
     * Prepare space variables for template.
     *
     * @param Space $space The space.
     * @param ContentType $contentType 
     * @param bool $preview True if preview.
     *
     * @return String $vars
     */
    private function prepare_space_vars($space, $contentType, $preview = false) {

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


        $content_all = Content::where('space_id', $space->id)->get();

        foreach ($content_all as $content) {

            $vars['content'][$content->key][] = $contentType->loadContent($content->id);
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

