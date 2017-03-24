<?php

namespace App\Providers;

use App\Config\FileWriter;
use App\Config\Repository;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        // Bind it only once so we can reuse in IoC
        $this->app->singleton('App\Config\Repository', function($app, $items) {

            $writer = new FileWriter($app['files'], $app['path.config']);
            return new Repository($items, $writer);
        });

        // Capture the loaded configuration items
        $config_items = app('config')->all();
        $this->app['config'] = $this->app->share(function($app) use ($config_items) {

            return $app->make('App\Config\Repository', $config_items);
        });
    }
}
