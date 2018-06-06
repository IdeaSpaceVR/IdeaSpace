<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Schema;
use App\Setting;
use App\Space;
use App\Theme;
use App\Content\ContentType;
use Auth;

class FrontpageController extends Controller {

    use SpaceTrait;

    private $contentType;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentType $ct) {

        /* CORS = Cross Origin Resource Sharing */
        $this->middleware('cors');
        $this->contentType = $ct;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {

        $db_config = config('database.connections.'.config('database.default'));

        if ($db_config['host'] == '' || 
            $db_config['database'] == '' || 
            $db_config['username'] == '' || 
            $db_config['password'] == '' || 
            Schema::hasTable('spaces') === false || 
            Schema::hasTable('themes') === false) {

            return redirect('install');

        } else {

            $setting = Setting::where('key', 'front-page-display')->first();
            $title_setting = Setting::where('key', 'site-title')->first();

            /* if there are suddenly no published spaces anymore, change setting and show default front page */
            $spaces = Space::where('status', Space::STATUS_PUBLISHED)->orderBy('updated_at', 'desc')->simplePaginate(1);

            if (count($spaces) === 0) {
                if ($setting->value != Setting::FRONTPAGE_DISPLAY_BLANK_PAGE) {
                    $setting->value = Setting::FRONTPAGE_DISPLAY_BLANK_PAGE;
                    $setting->save();
                }
                return view('frontpage.welcome_frontpage', ['title' => $title_setting->value]);
            }


            if ($setting->value != Setting::FRONTPAGE_DISPLAY_BLANK_PAGE) {

                /* show one space on front page */

                $space = Space::where('id', $setting->value)->first();

                /* show space in iframe because of the top navbar */
                if (Auth::check()) {

                    $content = space_embed_code('/' . $space->uri, '100%', '100%'); 

                    return view('frontpage.onespace_frontpage', [
                        'css' => array(asset('public/assets/frontpage/css/frontpage.css')), 
                        'content' => $content,
                        'title' => $title_setting->value
                    ]);
                }
            
                /* show space on full page */ 
                $vars = $this->prepare_space_content($space, $this->contentType, false);

                /* cut off .blade.php */
                return view('theme::' . $vars['theme_view'], $vars);

            } else {

								return view('frontpage.welcome_frontpage', ['title' => $title_setting->value]);
						}
        }
    }
}

