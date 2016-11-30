<?php

namespace App\Http\Controllers\Admin;

use App\Theme;

trait SpaceControllerTrait {


    /**
     * Process theme.
     *
     * @param Theme $theme The theme which is currently in use.
     *
     * @return $vars The vars array for the view.
     */
    private function process_theme($theme) {

        $theme_mod = array();

        /* convert to an array */
        $config = json_decode($theme->config, true);
        $theme_mod = array();
        $theme_mod['id'] = $theme->id;
        $theme_mod['theme-name'] = $config['#theme-name'];
        $theme_mod['theme-version'] = $config['#theme-version'];
        $theme_mod['theme-author-name'] = $config['#theme-author-name'];
        $theme_mod['theme-screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        foreach ($config['#content-types'] as $key => $value) {

            $theme_mod['contenttypes'][$key] = [
                'label' => $value['#label'],
                'description' => $value['#description'],
                'max_values' => intval($value['#max-values'])
                ];
        }

        /* store types in session in order to validate type on json media upload submission */
        //session(['types' => $types]);

        $vars = [
            'space_theme_id' => $theme->id,
            'theme' => $theme_mod,
            'js' => [asset('public/assets/admin/space/js/space.js')],
            'css' => [asset('public/assets/admin/space/css/space.css')]
        ];

        return $vars;
    }


}
