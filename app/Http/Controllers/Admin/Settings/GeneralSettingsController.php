<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Space;
use App\Setting;
use App;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

class GeneralSettingsController extends Controller {

    const SITE_TITLE = 'site-title';
    const ORIGIN_TRIAL_TOKEN = 'origin-trial-token';
    const ORIGIN_TRIAL_TOKEN_DATA_FEATURE = 'origin-trial-token-data-feature';
    const ORIGIN_TRIAL_TOKEN_DATA_EXPIRES = 'origin-trial-token-data-expires';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }


    /**
     * Show the settings page.
     *
     * @return Response
     */
    public function index() {

        $setting_site_title = Setting::where('key', GeneralSettingsController::SITE_TITLE)->first();

        /* all master view templates get variable in app/Providers/AppServiceProvider.php */
        $origin_trial_token = '';        
        try {
            $setting_origin_trial_token = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
            $origin_trial_token = $setting_origin_trial_token->value;
        } catch (ModelNotFoundException $e) {
        }

        /* all master view templates get variable in app/Providers/AppServiceProvider.php */
        $origin_trial_token_data_feature = '';        
        try {
            $setting_origin_trial_token = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE)->firstOrFail();
            $origin_trial_token_data_feature = $setting_origin_trial_token->value;
        } catch (ModelNotFoundException $e) {
        }

        /* all master view templates get variable in app/Providers/AppServiceProvider.php */
        $origin_trial_token_data_expires = '';        
        try {
            $setting_origin_trial_token = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES)->firstOrFail();
            $origin_trial_token_data_expires = $setting_origin_trial_token->value;
        } catch (ModelNotFoundException $e) {
        }


				App::setLocale(session('locale'));

				$site_localization = session('locale');

        $localization_options = [
            'en' => trans('template_general_settings.english'),
            'zh-cn' => trans('template_general_settings.chinese_china'),
            'de' => trans('template_general_settings.german'),
            'fr' => trans('template_general_settings.french'),
        ];


        $vars = [
            'site_title' => $setting_site_title->value,
            'site_localization_options' => $localization_options,
            'site_localization' => $site_localization,
            'origin_trial_token' => $origin_trial_token,
            'origin_trial_token_data_feature' => $origin_trial_token_data_feature,
            'origin_trial_token_data_expires' => $origin_trial_token_data_expires,
            'js' => array(asset('public/assets/admin/settings/js/space_settings.js')),
            'css' => array(asset('public/assets/admin/settings/css/space_settings.css'))
        ];

        return view('admin.settings.general_settings', $vars);
    }


    /**
     * Save settings.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function save(Request $request) {

        $setting_site_title = Setting::where('key', GeneralSettingsController::SITE_TITLE)->first();

        $setting_site_title->value = $request->input(GeneralSettingsController::SITE_TITLE);
        $setting_site_title->save();             


        $site_localization = $request->input('site-localization');

				app('config')->write('app.locale', $site_localization);

				session(['locale' => $site_localization]);


        try {
            $setting_origin_trial_token = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
            $setting_origin_trial_token->value = $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN);
            $setting_origin_trial_token->save();
        } catch (ModelNotFoundException $e) {
            $user = Auth::user();
            Setting::create([
                'user_id' => $user->id,
                'namespace' => 'system',
                'key' => GeneralSettingsController::ORIGIN_TRIAL_TOKEN,
                'value' => $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN)
            ]);
        } 

        try {
            $setting_origin_trial_token_data_feature = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE)->firstOrFail();
            $setting_origin_trial_token_data_feature->value = $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE);
            $setting_origin_trial_token_data_feature->save();
        } catch (ModelNotFoundException $e) {
            $user = Auth::user();
            Setting::create([
                'user_id' => $user->id,
                'namespace' => 'system',
                'key' => GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE,
                'value' => $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE)
            ]);
        } 

        try {
            $setting_origin_trial_token_data_expires = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES)->firstOrFail();
            $setting_origin_trial_token_data_expires->value = $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES);
            $setting_origin_trial_token_data_expires->save();
        } catch (ModelNotFoundException $e) {
            $user = Auth::user();
            Setting::create([
                'user_id' => $user->id,
                'namespace' => 'system',
                'key' => GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES,
                'value' => $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES)
            ]);
        } 

        return redirect('admin/settings/general')->withInput()->with('alert-success', trans('template_general_settings.settings_saved'));
    }

}
