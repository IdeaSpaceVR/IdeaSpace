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

class GeneralSettingsController extends Controller {

    const SITE_TITLE = 'site-title';
    const ORIGIN_TRIAL_TOKEN = 'origin-trial-token';

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

        /* gets FALLBACK_LOCALE in .env if necessary */
        $site_localization = App::getLocale();

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
        App::setLocale($site_localization);


        try {
            $setting_origin_trial_token = Setting::where('key', GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
            $setting_origin_trial_token->value = $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN);
            $setting_origin_trial_token->save();
        } catch (ModelNotFoundException $e) {
            Setting::create([
                'key' => GeneralSettingsController::ORIGIN_TRIAL_TOKEN,
                'value' => $request->input(GeneralSettingsController::ORIGIN_TRIAL_TOKEN)
            ]);
        } 

        return redirect('admin/settings/general')->withInput()->with('alert-success', 'Settings saved.');
    }

}
