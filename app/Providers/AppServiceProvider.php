<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Schema;
use DB;
use Exception;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $origin_trial_token = '';
        $origin_trial_token_data_feature = '';
        $origin_trial_token_data_expires = '';

        $db_config = config('database.connections.'.config('database.default'));

        if ($db_config['host'] != '' &&
            $db_config['database'] != '' &&
            $db_config['username'] != '' &&
            $db_config['password'] != '') {

            $db_connection = true;

            try {
                DB::connection(config('database.default'))->table(DB::raw('DUAL'))->first([DB::raw(1)]);
            } catch (Exception $e) {
                $db_connection = false;
            }

            if ($db_connection == true && Schema::hasTable('settings')) {
                try {
                    $setting_origin_trial_token = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
                    $origin_trial_token = $setting_origin_trial_token->value;
                } catch (ModelNotFoundException $e) {
                }
                try {
                    $setting_origin_trial_token_data_feature = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_FEATURE)->firstOrFail();
                    $origin_trial_token_data_feature = $setting_origin_trial_token_data_feature->value;
                } catch (ModelNotFoundException $e) {
                }
                try {
                    $setting_origin_trial_token_data_expires = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN_DATA_EXPIRES)->firstOrFail();
                    $origin_trial_token_data_expires = $setting_origin_trial_token_data_expires->value;
                } catch (ModelNotFoundException $e) {
                }
            }
        }

        view()->composer('layouts.app', function($view) use ($origin_trial_token, $origin_trial_token_data_feature, $origin_trial_token_data_expires) {
            $view->with('origin_trial_token', $origin_trial_token);
            $view->with('origin_trial_token_data_feature', $origin_trial_token_data_feature);
            $view->with('origin_trial_token_data_expires', $origin_trial_token_data_expires);
        }); 

        view()->composer('layouts.frontpage_app', function($view) use ($origin_trial_token, $origin_trial_token_data_feature, $origin_trial_token_data_expires) {
            $view->with('origin_trial_token', $origin_trial_token);
            $view->with('origin_trial_token_data_feature', $origin_trial_token_data_feature);
            $view->with('origin_trial_token_data_expires', $origin_trial_token_data_expires);
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
