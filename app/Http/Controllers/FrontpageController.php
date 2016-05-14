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

            $setting = Setting::where('key', 'front-page-display')->first();

            /* if there are suddenly no published spaces anymore, change setting and show default front page */
            $spaces = Space::where('status', Space::STATUS_PUBLISHED)->orderBy('updated_at', 'desc')->simplePaginate(5);

            if (count($spaces) === 0) {
                if ($setting->value != 'latest-spaces') {
                    $setting->value = 'latest-spaces';
                    $setting->save();
                }
                return view('frontpage.welcome_frontpage');
            }


            if ($setting->value != 'latest-spaces') {

                /* show one space on front page */

                $space = Space::where('id', $setting->value)->first();

                /* show space in iframe because of the top navbar */
                if (Auth::check()) {

                    $content = space_embed_code('/' . $space->uri, '100%', '100%'); 

                    return view('frontpage.onespace_frontpage', 
                        ['css' => array(asset('public/assets/frontpage/css/frontpage.css')), 
                        'content' => $content]);
                }
            
                /* show space on full page */ 
                $vars = $this->prepare_space_vars($space, false);

                /* cut off .blade.php */
                return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);

            } else {

                /* show latest spaces on front page */

                return view('frontpage.latest_spaces_frontpage', 
                    ['css' => array(asset('public/assets/frontpage/css/frontpage.css')), 
                    'spaces' => $spaces]);
            }
        }
    }
}

