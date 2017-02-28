<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $origin_trial_token = '';
        try {
            $setting_origin_trial_token = Setting::where('key', \App\Http\Controllers\Admin\Settings\GeneralSettingsController::ORIGIN_TRIAL_TOKEN)->firstOrFail();
            $origin_trial_token = $setting_origin_trial_token->value;
        } catch (ModelNotFoundException $e) {
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
