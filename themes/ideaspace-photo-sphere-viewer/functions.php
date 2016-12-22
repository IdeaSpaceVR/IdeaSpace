<?php

/**
 * Generate preview image from photo spheres used for the navigation menu.
 */
Event::listen('ideaspace-photo-sphere-viewer.photo-sphere.photo-sphere', function($image) {

    /* remember power of two rule for image sizes */    
    return [
        'photo-sphere-navigation-preview-image' => [
            'resize' => ['width' => 256, 'height' => null],
        ]
    ];
});


 

