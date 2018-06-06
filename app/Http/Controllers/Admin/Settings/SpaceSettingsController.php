<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Space;
use App\Setting;
use Log;

class SpaceSettingsController extends Controller 
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

        $spaces = Space::where('status', Space::STATUS_PUBLISHED)->orderBy('updated_at', 'desc')->get();
        $setting = Setting::where('key', 'front-page-display')->first();
  
        $arr = array();
        $space_id_selected = null;
        $one_space_checked = false;
        $blank_page_checked = false;

        /* if there are no published spaces, set it to blank page */
        if (count($spaces) === 0) {
            $setting->value = Setting::FRONTPAGE_DISPLAY_BLANK_PAGE;
            $setting->save();
        }


        if ($setting->value != Setting::FRONTPAGE_DISPLAY_BLANK_PAGE) {
            $space_id_selected = $setting->value;
            $one_space_checked = true;
        } else if ($setting->value == Setting::FRONTPAGE_DISPLAY_BLANK_PAGE) {
        		$blank_page_checked = true;
        }

        foreach ($spaces as $space) {
            $arr[$space->id] = $space->title;
        }

        $vars = [
            'space_id_selected' => $space_id_selected,
            'one_space_checked' => $one_space_checked,
            'blank_page_checked' => $blank_page_checked,
            'spaces' => $arr,
            'js' => array(asset('public/assets/admin/settings/js/space_settings.js')),
            'css' => array(asset('public/assets/admin/settings/css/space_settings.css'))
        ];

        return view('admin.settings.space_settings', $vars);
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
        $front_page_display_val = $request->input('front-page-display');

        $setting = Setting::where('key', 'front-page-display')->first();

        if ($front_page_display_val == Setting::FRONTPAGE_DISPLAY_ONE_SPACE && $request->has('space')) {

            $space_id = $request->input('space');
            $setting->value = $space_id;
            $setting->save();             

            return redirect('admin/settings/space')->withInput()->with('alert-success', trans('template_space_settings.settings_saved'));
        } 

        $setting->value = $front_page_display_val;
        $setting->save();

        return redirect('admin/settings/space')->withInput()->with('alert-success', trans('template_space_settings.settings_saved'));
    }

}
