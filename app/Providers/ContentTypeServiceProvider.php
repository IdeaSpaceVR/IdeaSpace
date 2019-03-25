<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ContentTypeServiceProvider extends ServiceProvider {


    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {
    
        $this->app->bind('\App\Content\ContentType', function ($app) {
            return new \App\Content\ContentType();
        });    
    }


}
