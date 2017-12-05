<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\Content\ContentType;
use File;
use Log;

class ThemesController extends Controller {

    private $contentType;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentType $ct) {

        $this->middleware('auth');
        $this->contentType = $ct;
    }

    /**
     * Search theme directory for available and valid themes and 
     * indicate status (active or inactive).
     *
     * @return Response
     */
    public function index() {

        $user = Auth::user();

        try {
            $directories = File::directories(Theme::THEMES_DIR);
        } catch (InvalidArgumentException $e) {
        }  
      
        foreach ($directories as $directory) {

            /* if system is windows */
            $directory = str_replace('\\', '/', $directory);

            /* if theme is invalid, there is no creation nor update of theme, but it will be removed from DB */
            if ($this->theme_validation($directory) == true) {

                /* if theme does not exist in DB yet, create it */ 
                try {

                    $theme = Theme::where('root_dir', $directory)->firstOrFail(); 

                } catch (ModelNotFoundException $e) {

                    $contents = (require($directory . '/' . Theme::CONFIG_FILE));

                    $theme = Theme::create([
                        'root_dir' => $directory,
                        'status' => Theme::STATUS_INACTIVE,
                        'user_id' => $user->id,
                        'config' => json_encode($contents)
                    ]);

                }
            
                try {

                    /* add config contents after previous deactivation of theme (which empties config field) */
                    $theme = Theme::where('root_dir', $directory)->firstOrFail(); 
                    $contents = (require($directory . '/' . Theme::CONFIG_FILE));
                    $theme->config = json_encode($contents);

                    $theme_ideaspacevr_version = substr($contents['#ideaspace-version'], 2); 
                    if (version_compare($theme_ideaspacevr_version, config('app.version'), '>') === true) {
                        $theme->status = Theme::STATUS_INCOMPATIBLE;
                    } else if ($theme->status == Theme::STATUS_INCOMPATIBLE) {
                        $theme->status = Theme::STATUS_INACTIVE;
                    } 

                    /* theme passed validation but has error status */
                    if ($theme->status == Theme::STATUS_ERROR) {
                        $theme->status = Theme::STATUS_INACTIVE;
                    }
                    $theme->save();    

                } catch (ModelNotFoundException $e) {
                }

            } else {

                try {
                    $theme = Theme::where('root_dir', $directory)->firstOrFail();
                    $theme->status = Theme::STATUS_ERROR;
                    $theme->save();
                } catch (ModelNotFoundException $e) {
                }

            } /* if */

        } /* foreach */


        $themes = Theme::orderBy('updated_at', 'desc')->get();
        $themes_mod = array();

        foreach ($themes as $theme) {      
            $config = json_decode($theme->config, true);

            if ($theme->status==Theme::STATUS_ACTIVE) {
                $status_text = trans('template_themes_config.uninstall');
            } else if ($theme->status==Theme::STATUS_INACTIVE) {
                $status_text = trans('template_themes_config.install_theme');
            } else if ($theme->status==Theme::STATUS_INCOMPATIBLE) {
                $status_text = trans('template_themes_config.incompatible_theme');
            } else {
                $status_text = trans('template_themes_config.invalid_theme');
            }

            $theme_mod = array();
            $theme_mod['id'] = $theme->id;          
            $theme_mod['theme-name'] = $config['#theme-name'];          
            $theme_mod['theme-description'] = $config['#theme-description'];          
            $theme_mod['theme-version'] = $config['#theme-version'];          
            $theme_mod['theme-author-name'] = $config['#theme-author-name'];          
            $theme_mod['theme-author-email'] = $config['#theme-author-email'];          
            $theme_mod['theme-homepage'] = $config['#theme-homepage'];          
            $theme_mod['theme-keywords'] = $config['#theme-keywords'];          
            //$theme_mod['theme-compatibility'] = explode(',', $config['#theme-compatibility']);          
            $theme_mod['theme-view'] = $config['#theme-view'];          

            $theme_mod['status'] = $theme->status;          
            $theme_mod['status_class'] = (($theme->status==Theme::STATUS_ACTIVE)?Theme::STATUS_ACTIVE:'');          
            $theme_mod['status_aria_pressed'] = (($theme->status==Theme::STATUS_ACTIVE)?'true':'false');          
            $theme_mod['status_text'] = $status_text;          
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
    public function submit(Request $request) {

        $all = $request->all();
        //Log::debug($all); 

        if (array_has($all, 'id') && array_has($all, 'theme_status')) {   

            $theme = Theme::where('id', $all['id'])->first();

            $theme->status = (($all['theme_status']==Theme::STATUS_ACTIVE)?Theme::STATUS_INACTIVE:Theme::STATUS_ACTIVE);

            if ($theme->status == Theme::STATUS_INACTIVE) { 
                /* delete config */
                $theme->config = '';
            } else {
                $contents = (require($theme->root_dir . '/' . Theme::CONFIG_FILE));
                $theme->config = json_encode($contents);
            }
            $theme->save();

            $response_status_text = (($all['theme_status']==Theme::STATUS_INACTIVE)?trans('template_themes_config.uninstall'):trans('template_themes_config.install_theme')); 
            //Log::debug($response_status_text);
            return response()->json(['status_text' => $response_status_text, 'status' => $theme->status]);

        } else {
            abort(404);
        }
    }


    /**
     * Theme validation.
     *
     * @param String $directory The theme directory. 
     *
     * @return True if valid, false otherwise.
     */
    private function theme_validation($directory) {

        if (File::exists($directory . '/' . Theme::CONFIG_FILE) &&
            File::exists($directory . '/' . Theme::FUNCTIONS_FILE) &&
            File::exists($directory . '/' . Theme::SCREENSHOT_FILE)) {

                $config = (require($directory . '/' . Theme::CONFIG_FILE));

                if (array_has($config, '#theme-name') && strlen($config['#theme-name']) > 0 && 
                    array_has($config, '#theme-key') && strlen($config['#theme-key']) > 0 &&
                    array_has($config, '#theme-version') && strlen($config['#theme-version']) > 0 &&
                    array_has($config, '#theme-view') && strlen($config['#theme-view']) > 0 &&

                    File::exists($directory . '/' . Theme::VIEWS_DIR . '/' . $config['#theme-view'] . '.blade.php') &&

                    array_has($config, '#ideaspace-version') && strlen($config['#ideaspace-version']) > 0 &&
                    strpos($config['#ideaspace-version'], '>=') !== false &&  

                    array_has($config, '#theme-description') && strlen($config['#theme-description']) > 0 &&
                    array_has($config, '#theme-author-name') && strlen($config['#theme-author-name']) > 0 &&
                    array_has($config, '#theme-author-email') && strlen($config['#theme-author-email']) > 0 &&
                    array_has($config, '#theme-homepage') && strlen($config['#theme-homepage']) > 0 &&
                    array_has($config, '#theme-keywords') && strlen($config['#theme-keywords']) > 0 &&
                    /*array_has($config, '#theme-compatibility') && strlen($config['#theme-compatibility']) > 0 &&*/
                    array_has($config, '#theme-view') && strlen($config['#theme-view']) > 0 &&
                    array_has($config, '#content-types')) {


                    $all_content_types = array_only($config, ['#content-types']);
                    foreach ($all_content_types as $content_types) {

                        foreach ($content_types as $content_type) {

                            if (array_has($content_type, '#label') && strlen($content_type['#label']) > 0 &&
                                array_has($content_type, '#description') && strlen($content_type['#description']) > 0 && 
                                array_has($content_type, '#max-values') && strlen($content_type['#max-values']) > 0 && 
                                array_has($content_type, '#fields')) {

                                $all_fields = array_only($content_type, ['#fields']);

                                foreach ($all_fields as $fields) {

                                    foreach ($fields as $field) {

                                        if (array_has($this->contentType->fieldTypes, $field['#type'])) {

                                            $return_value = $this->contentType->fieldTypes[$field['#type']]->validateThemeFieldType($field);      
                                            if ($return_value == false) {
                                                Log::debug('THEME: wrong or missing field parameter for type ' . $field['#type'] . ' (field:' . key($fields) . ') in config.php file in directory ' . $directory);
                                                return false;
                                            }

                                        } else {
                                            Log::debug('THEME: wrong or unknown field type in config.php file in directory ' . $directory);
                                            return false;
                                        }

                                    } /* foreach */

                                } /* foreach */

                            } else {
                                Log::debug('THEME: wrong or missing config parameter for content type in config.php file in directory ' . $directory);
                                return false;
                            } 

                        } /* foreach */

                    } /* foreach */

                } else { 

                    Log::debug('THEME: wrong or missing config parameter in config.php file in directory ' . $directory);
                    return false;
                }

        } else {

            Log::debug('THEME: mandatory theme file missing in ' . $directory);
            return false;
        }
    
        return true;
    }

  
    /**
     * Get list of themes.
     */
    public function themes_all_json() {

        $theme_keys = '';
        $themes = Theme::get();
        foreach ($themes as $theme) {
            $config = json_decode($theme->config, true);
            $temp = explode('-', $config['#theme-key']);
            $key = '';
            foreach ($temp as $t) {
                $key .= substr($t, 0, 1); 
            }
            $theme_keys = $theme_keys . $key . $config['#theme-version'] . '-';
        }

        if ($theme_keys != '') {
            return response()->json(['themes' => substr($theme_keys, 0, -1)]);
        } else {
            return response()->json(['themes' => '']);
        }
    }

}


