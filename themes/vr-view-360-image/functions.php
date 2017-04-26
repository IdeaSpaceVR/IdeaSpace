<?php

/**
 * Generate a preview image from photo spheres used for the navigation menu in VR.
 */
Event::listen('vr-view-360-image-hotspot.photo-spheres.photo-sphere', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'preview' => [
            'resize' => ['width' => 512, 'height' => null],
        ]
    ];
});


 

