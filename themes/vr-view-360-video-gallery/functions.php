<?php

/**
 * Generate a preview image.
 */
Event::listen('vr-view-360-video-gallery.video-spheres.video-sphere-preview', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'image-thumbnail' => [
            'fit' => ['width' => 125, 'height' => 80],
        ]
    ];
});
 

