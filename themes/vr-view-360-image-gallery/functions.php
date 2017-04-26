<?php

/**
 * Generate a preview image from photo spheres.
 */
Event::listen('vr-view-360-image-gallery.photo-spheres.photo-sphere', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'preview-photosphere' => [
            'resize' => ['width' => 512, 'height' => null],
        ]
    ];
});

/**
 * Generate a preview image from photo spheres.
 */
Event::listen('vr-view-360-image-gallery.photo-spheres.photo-sphere', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'photosphere-thumbnail' => [
            'fit' => ['width' => 125, 'height' => 80],
        ]
    ];
});


/**
 * Generate a preview image.
 */
Event::listen('vr-view-360-image-gallery.photo-spheres.photo-sphere-preview', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'image-thumbnail' => [
            'fit' => ['width' => 125, 'height' => 80],
        ]
    ];
});
 

