<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Schema;
use App\Setting;
use App\Space;
use App\SpaceTrait;
use App\Theme;
use Auth;

class FrontpageController extends Controller
{

    use SpaceTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if (env('DB_HOST', '') == '' || 
            env('DB_DATABASE', '') == '' || 
            env('DB_USERNAME', '') == '' || 
            env('DB_PASSWORD', '') == '' || 
            Schema::hasTable('spaces') === false || 
            Schema::hasTable('themes') === false) {

            return redirect('install');

        } else {

            $frontpage_content = null;

            $setting = Setting::where('key', 'front-page-display')->first();

            /* if there are suddenly no published spaces anymore, change setting and show default front page */
            $spaces = Space::where('status', Space::STATUS_PUBLISHED)->get();

            if (count($spaces) === 0) {
                if ($setting->value != 'latest-spaces') {
                    $setting->value = 'latest-spaces';
                    $setting->save();
                }
                return view('frontpage.frontpage', ['frontpage_content' => $frontpage_content]);
            }


            if ($setting->value != 'latest-spaces') {

                /* show one space on front page */

                $space = Space::where('id', $setting->value)->first();

                /* show space in iframe because of the top navbar */
                if (Auth::check()) {

                    $frontpage_content = '<iframe width="100%" height="100%" allowfullscreen frameborder="0" src="/' . $space->uri . '"></iframe>'; 
                    return view('frontpage.frontpage', ['css' => array(asset('public/assets/frontpage/css/frontpage.css')), 'frontpage_content' => $frontpage_content]);
                }
            
                /* show space on full page */ 
                $vars = $this->prepare_space_vars($space, false);

                /* cut off .blade.php */
                return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);

            } else {

                /* show latest spaces on front page */

                //$spaces = Space::where('status', Space::STATUS_PUBLISHED)->get();

                //if ($spaces == null) {

                //} else {


                //}
                return view('frontpage.frontpage', ['frontpage_content' => $frontpage_content]);
            }
        }
    }
}

