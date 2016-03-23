<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use File;
use Log;

class ThemesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Search theme directory for available themes and show status (active or inactive).
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        try {
            $directories = File::directories(Theme::THEMES_DIR);
        } catch (InvalidArgumentException $e) {

        }  
      
        foreach ($directories as $directory) {

            /* if theme does not exist in DB yet, create it */ 
            try {

                $theme = Theme::where('root_dir', $directory)->firstOrFail(); 

            } catch (ModelNotFoundException $e) {

                /* check files (minimal set of files) */
                /* if theme is incomplete, it won't show up in list of available themes */
                if (File::exists($directory . '/' . Theme::CONFIG_FILE) && 
                    File::exists($directory . '/' . Theme::FUNCTIONS_FILE) &&
                    File::exists($directory . '/' . Theme::TEMPLATES_DIR . '/' . Theme::TEMPLATES_INDEX_FILE) &&
                    File::exists($directory . '/' . Theme::TEMPLATES_DIR . '/' . Theme::TEMPLATES_SCENE_FILE) &&
                    File::exists($directory . '/' . Theme::TEMPLATES_DIR . '/' . Theme::TEMPLATES_ASSETS_FILE) &&
                    File::exists($directory . '/' . Theme::SCREENSHOT_FILE)) {

                    $contents = (require_once($directory . '/' . Theme::CONFIG_FILE));

                    $theme = Theme::create([
                        'root_dir' => $directory,
                        'status' => Theme::STATUS_INACTIVE,
                        'user_id' => $user->id,
                        'config' => json_encode($contents)
                    ]);

                } 
            }
        
            try {
                /* add config contents after previous deactivation of theme (which empties config field) */
                $theme = Theme::where('root_dir', $directory)->where('config', '')->firstOrFail(); 
                if (File::exists($directory . '/' . Theme::CONFIG_FILE)) {
                    $contents = (require_once($directory . '/' . Theme::CONFIG_FILE));
                    $theme->config = json_encode($contents);
                    $theme->save();    
                }

            } catch (ModelNotFoundException $e) {
            }
        }


        $themes = Theme::all();
        $themes_mod = array();

        foreach ($themes as $theme) {      
            $config = json_decode($theme->config);
            $theme_mod = array();
            $theme_mod['id'] = $theme->id;          
            $theme_mod['title'] = $config->title;          
            $theme_mod['description'] = $config->description;          
            //$theme_mod['compatibility'] = $config->headset_compatibility;          
            $theme_mod['status'] = $theme->status;          
            $theme_mod['status_class'] = (($theme->status==Theme::STATUS_ACTIVE)?'active':'');          
            $theme_mod['status_aria_pressed'] = (($theme->status==Theme::STATUS_ACTIVE)?'true':'false');          
            $theme_mod['status_text'] = (($theme->status==Theme::STATUS_ACTIVE)?'Active':'Inactive');          
            $theme_mod['screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);          
            $themes_mod[] = $theme_mod;
        }

        $vars = [  
            'themes' => $themes_mod,
            'js' => array(asset('public/assets/admin/themes_configuration/js/themes_configuration.js'))
        ];

        return view('admin.themes_config', $vars);
    }


    /**
     * Ajax post submitting id of theme in order to set it active or inactive.
     *
     * @return Response
     */
    public function submit(Request $request)
    {
        $all = $request->all();
        //Log::debug($all); 

        if (array_has($all, 'id') && array_has($all, 'status_text')) {   

            $theme = Theme::where('id', $all['id'])->first();
            $theme->status = ((strtolower($all['status_text'])==Theme::STATUS_ACTIVE)?Theme::STATUS_INACTIVE:Theme::STATUS_ACTIVE);
            if ($theme->status == Theme::STATUS_INACTIVE) { 
                /* delete config */
                $theme->config = '';
            } else {
                if (File::exists($theme->root_dir . '/config.php')) {
                    $contents = (require_once($theme->root_dir . '/config.php'));
                    $theme->config = json_encode($contents);
                }
                /*if (File::exists($theme->root_dir . '/functions.php')) {
                    $contents = (require_once($theme->root_dir . '/functions.php'));
                }*/
            }
            $theme->save();

            $response_status_text = ucfirst(((strtolower($all['status_text'])==Theme::STATUS_ACTIVE)?Theme::STATUS_INACTIVE:Theme::STATUS_ACTIVE)); 
            return response()->json(['status_text' => $response_status_text]);

        } else {
            abort(404);
        }
    }

}


