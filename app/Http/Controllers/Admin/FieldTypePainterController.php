<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Space;
use App\Theme;
use App\Content;
use App\Content\ContentType;
use App\Content\FieldTypePainter;
use App\Setting;
use Log;

class FieldTypePainterController extends Controller {

		private $contentType;
    private $fieldTypePainter;


    /**
     * Create a new controller instance.
     *
     * @param FieldTypePainter $ftr
     *
     * @return void
     */
    public function __construct(ContentType $ct, FieldTypePainter $ftp) {

        $this->middleware('auth');
				$this->contentType = $ct;
        $this->fieldTypePainter = $ftp;
    }


    /**
     * The add/edit painter page.
     *
     * @param int $space_id 
     * @param String $contenttype 
     * @param String $scene_template 
     *
     * @return Response
     */
    public function init_painter($space_id, $contenttype, $scene_template, $content_id) {

				try {
            $space = Space::where('id', $space_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

				try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
            $config = json_decode($theme->config, true);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        $origin_trial_token = '';
        $origin_trial_token_data_feature = '';
        $origin_trial_token_data_expires = '';
        try {
            $setting_origin_trial_token = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
            $origin_trial_token = $setting_origin_trial_token->value;
        } catch (ModelNotFoundException $e) {
        }
        try {
            $setting_origin_trial_token_data_feature = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE)->firstOrFail();
            $origin_trial_token_data_feature = $setting_origin_trial_token_data_feature->value;
        } catch (ModelNotFoundException $e) {
        }
        try {
            $setting_origin_trial_token_data_expires = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES)->firstOrFail();
            $origin_trial_token_data_expires = $setting_origin_trial_token_data_expires->value;
        } catch (ModelNotFoundException $e) {
        }


        $vars = [
            'space_url' => url($space->uri),
            'space_title' => $space->title,
            'origin_trial_token' => $origin_trial_token,
            'origin_trial_token_data_feature' => $origin_trial_token_data_feature,
            'origin_trial_token_data_expires' => $origin_trial_token_data_expires,
            'theme_dir' => $theme->root_dir,
            'theme_view' => $config['#theme-view'],
            'content' => []
        ];

				$vars['content'][$contenttype][] = $this->contentType->loadContent($content_id);

        view()->addNamespace('theme', base_path($theme->root_dir . '/' . Theme::VIEWS_DIR));

Log::debug($vars);


				return view('theme::' . $scene_template, $vars);       
    }


}


