<?php

Event::listen('ideaspace-welcome.space-links.space-link-image', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'space-link-image-resized' => [
            'fit' => ['width' => 512, 'height' => 256],
        ]
    ];
});

Event::listen('ideaspace-welcome.general-settings.logo', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'logo-image-resized' => [
            'resize' => ['width' => 256, 'height' => null],
        ]
    ];
});
