<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Schema;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $origin_trial_token = '';

        $db_config = config('database.connections.'.config('database.default'));

        if ($db_config['host'] != '' &&
            $db_config['database'] != '' &&
            $db_config['username'] != '' &&
            $db_config['password'] != '') {

            $db_connection = true;

            try {
                DB::connection(config('database.default'))->table(DB::raw('DUAL'))->first([DB::raw(1)]);
            } catch (\Exception $e) {
                $db_connection = false;
            }

            if ($db_connection == true && Schema::hasTable('settings')) {
                try {
                    $setting_origin_trial_token = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
                    $origin_trial_token = $setting_origin_trial_token->value;
                } catch (ModelNotFoundException $e) {
                }
            }
        }

        view()->composer('layouts.app', function($view) use ($origin_trial_token) {
            $view->with('origin_trial_token', $origin_trial_token);
        }); 

        view()->composer('layouts.frontpage_app', function($view) use ($origin_trial_token) {
            $view->with('origin_trial_token', $origin_trial_token);
        }); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
