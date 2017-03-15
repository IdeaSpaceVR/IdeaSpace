<?php

/**
 * Generate a preview image from photo spheres used for the navigation menu in VR.
 */
Event::listen('ideaspace-360-photo-sphere-viewer.photo-spheres.photo-sphere', function($image) {

    /* remember power of two rule for image sizes */    
    return [
        'photo-sphere-navigation-preview-image' => [
            'resize' => ['width' => 512, 'height' => null],
        ]
    ];
});


 

