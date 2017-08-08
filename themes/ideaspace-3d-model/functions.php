<?php

/**
 * Resize images shown in hotspot annotations.
 */
Event::listen('ideaspace-model.annotations.image', function($image) {

    /* remember power of two rule for image sizes */    
    return [
        'resized-annotation-image' => [
            'resize' => ['width' => 512, 'height' => null],
        ]
    ];
});


 

