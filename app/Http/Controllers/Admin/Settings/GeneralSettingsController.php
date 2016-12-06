<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Space;
use App\Setting;
use Log;

class GeneralSettingsController extends Controller 
{

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

        $vars = [
            'site_title' => $setting->value,
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
    public function save(Request $request)
    {
        $site_title = $request->input('site-title');

        $setting = Setting::where('key', 'site-title')->first();

        $setting->value = $site_title;
        $setting->save();             

        return redirect('admin/settings/general')->withInput()->with('alert-success', 'Settings saved.');
    }

}
