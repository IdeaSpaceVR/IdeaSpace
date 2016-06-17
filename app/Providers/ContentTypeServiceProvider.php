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
              //$this->app->make('\App\Content\FieldTypeImage'),  
              //$this->app->make('\App\Content\FieldTypeText'));
        });    

        /*$this->app->bind('\App\Content\FieldTypeImage', function ($app) {
            return new \App\Content\FieldTypeImage();
        });

        $this->app->bind('\App\Content\FieldTypeText', function ($app) {
            return new \App\Content\FieldTypeText();
        });*/

    }


}
