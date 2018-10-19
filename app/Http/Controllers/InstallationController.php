<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use File;
use Schema;
use Validator;
use Artisan;
use Hash;
use App\User;
use DB;
use Exception;

class InstallationController extends Controller {

    const REQUIRED_PHP_VERSION = '5.5.9';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }


    /**
     * Show the server requirements page.
     *
     * @return Response
     */
    public function server_requirements() {

        $db_config = config('database.connections.'.config('database.default'));

        if ($db_config['host'] != '' &&
            $db_config['database'] != '' &&
            $db_config['username'] != '' &&
            $db_config['password'] != '') {
    
            return redirect('login');
        }

        $errors = [];

        if (version_compare(phpversion(), InstallationController::REQUIRED_PHP_VERSION, '<=')) {
            $errors[] = 'phpversion';
        }

        if (!extension_loaded('openssl')) {
            $errors[] = 'openssl';
        }

        if (!extension_loaded('pdo')) {
            $errors[] = 'pdo';
        }

        if (!extension_loaded('fileinfo')) {
            $errors[] = 'fileinfo';
        }

        if (!extension_loaded('mbstring')) {
            $errors[] = 'mbstring';
        }

        if (!extension_loaded('tokenizer')) {
            $errors[] = 'tokenizer';
        }

        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $errors[] = 'gd_imagick';
        }

        if (!File::isWritable('storage')) {
            $errors[] = 'storage_directory';
        }

        if (!File::isWritable('bootstrap/cache')) {
            $errors[] = 'bootstrap_cache_directory';
        }

        if (!File::isWritable('public/assets/user')) {
            $errors[] = 'user_assets_directory';
        }

        if (!File::isWritable('config/database.php')) {
            $errors[] = 'config_database_file';
        }

        if (!File::isWritable('config/app.php')) {
            $errors[] = 'config_app_file';
        }

        if (!File::isWritable('config/image.php')) {
            $errors[] = 'config_image_file';
        }

				/* default value */
        $gd_imagick_code = 'gd';

        if (extension_loaded('gd')) {

          $gd_imagick = 'GD Library';
          $gd_imagick_code = 'gd';

        } else if (extension_loaded('imagick')) {

          $gd_imagick = 'ImageMagick';
          $gd_imagick_code = 'imagick';
        }

        //\Log::debug(PHP_VERSION_ID);
        $phpversion_arr = explode('.', phpversion());
        $phpversion = $phpversion_arr[0] . '.' . $phpversion_arr[1] . '.' . substr($phpversion_arr[2], 0, strpos($phpversion_arr[2], '-')); 

        $vars = [
            'css' => array(asset('public/assets/install/css/server_requirements.css')),
            'phpversion' => $phpversion,
            'gd_imagick' => $gd_imagick,
            'gd_imagick_code' => $gd_imagick_code,
            'errors' => $errors
        ];

        return view('install.server_requirements', $vars);
    }


    /**
     * Server Requirements submit.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function server_requirements_submit(Request $request) {

				/* if not (which must not happen), the default value from config/image.php is used implicitly */
				if ($request->has('gd_imagick_code')) {
        		app('config')->write('image.driver', $request->input('gd_imagick_code'));
				}

        return redirect('install-db');
    }


    /**
     * Show the installation page.
     *
     * @return Response
     */
    public function install_db() {

        if ($this->installation_done()) {
            return redirect('login');
        }

        $vars = [
            'css' => array(asset('public/assets/install/css/db_config.css'))
        ];

        return view('install.db_config', $vars);
    }


    /**
     * Installation submit.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function install_db_submit(Request $request) {

        $validation_rules = [
            'db_name' => 'required',
            'db_user_name' => 'required',
            'db_user_password' => 'required',
            'db_host' => 'required',
            'db_table_prefix' => 'required'
        ];

        $validation_messages = [
            'db_name.required' => 'The database name field is required.',
            'db_user_name.required' => 'The user name field is required.',
            'db_user_password.required' => 'The password field is required.',
            'db_host.required' => 'The database host field is required.',
            'db_table_prefix.required' => 'The table prefix field is required.'
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return redirect('install-db')->withErrors($validator)->withInput();
        }

        app('config')->write('database.connections.' . config('database.default') . '.host', trim($request->input('db_host')));
        app('config')->write('database.connections.' . config('database.default') . '.database', trim($request->input('db_name')));
        app('config')->write('database.connections.' . config('database.default') . '.username', trim($request->input('db_user_name')));
        app('config')->write('database.connections.' . config('database.default') . '.password', trim($request->input('db_user_password')));
        app('config')->write('database.connections.' . config('database.default') . '.prefix', trim($request->input('db_table_prefix')));

        try {
            //DB::connection(config('database.default'))->table(DB::raw('DUAL'))->first([DB::raw(1)]);
            DB::connection(config('database.default'))->getPdo();
        } catch (Exception $e) {
            return redirect('install-db')->withInput()->with('alert-error', 'Cannot connect to the database. Please verify your database settings and try again.');
        }

        /* generate app key and write it to the config file */ 
        /* src/Illuminate/Foundation/Console/KeyGenerateCommand.php */
        app('config')->write('app.key', 'base64:'.base64_encode(random_bytes(config('app.cipher') == 'AES-128-CBC' ? 16 : 32)));
    
        return redirect('install-user-config');
    }


    /**
     * Show the installation page.
     *
     * @return Response
     */
    public function install_user_config() {

        if ($this->installation_done()) {
            return redirect('login');
        }

        $vars = [
            'js' => array(asset('public/assets/install/js/user_config.js'),
                asset('public/jquery-pwstrength/pwstrength.js')),
            'css' => array(asset('public/assets/install/css/user_config.css'))
        ];

        return view('install.user_config', $vars);
    }


    /**
     * Installation submit.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function install_user_config_submit(Request $request) {

        if ($this->installation_done()) {
            abort(404);
        }

        $validation_rules = [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required'
        ];

        $validation_messages = [
            'username.required' => 'The username field is required.',
            'password.required' => 'The password field is required.',
            'email.required' => 'The e-mail field is required.'
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return redirect('install-db')->withErrors($validator)->withInput();
        }

        /* create database tables */
        Artisan::call('migrate');
     
        /* seeding database tables */
        Artisan::call('db:seed');
 
        User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);        
     
        return redirect('login')->with('alert-success', 'IdeaSpaceVR has been successfully installed!');   
    }


    /**
     * Is installation done?
     */
    private function installation_done() {

        try {
            DB::connection(config('database.default'))->table(DB::raw('DUAL'))->first([DB::raw(1)]);
        } catch (Exception $e) {
            return false;
        }

        if (Schema::hasTable('settings')) {
            return true;
        }

        return false;
    }


}
