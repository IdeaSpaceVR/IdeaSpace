<?php

Event::listen('ideaspace-compass-blog.general-settings.blog-icon', function($image) {

    /* remember power of two rule for image sizes */
    return [
        'blog-icon-resized' => [
            'fit' => ['width' => 256, 'height' => 256],
        ]
    ];
});


