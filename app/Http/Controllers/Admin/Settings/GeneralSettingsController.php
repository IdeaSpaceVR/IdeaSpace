<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Space;
use App\Setting;
use App;

class GeneralSettingsController extends Controller {

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

        $setting = Setting::where('key', 'site-title')->first();

        /* gets FALLBACK_LOCALE in .env if necessary */
        $site_localization = App::getLocale();

        $localization_options = [
            'en' => trans('template_general_settings.english'),
            'zh-cn' => trans('template_general_settings.chinese_china'),
            'de' => trans('template_general_settings.german'),
            'fr' => trans('template_general_settings.french'),
        ];

        $vars = [
            'site_title' => $setting->value,
            'site_localization_options' => $localization_options,
            'site_localization' => $site_localization,
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

        $site_title = $request->input('site-title');

        $setting = Setting::where('key', 'site-title')->first();

        $setting->value = $site_title;
        $setting->save();             

        $site_localization = $request->input('site-localization');
        App::setLocale($site_localization);

        return redirect('admin/settings/general')->withInput()->with('alert-success', 'Settings saved.');
    }

}
