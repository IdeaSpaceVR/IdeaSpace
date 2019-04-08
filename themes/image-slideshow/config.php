<?php

return [

  '#theme-name' => 'Image Slideshow',
  '#theme-key' => 'image-slideshow',
  '#theme-version' => '1.0',
  '#ideaspace-version' => '>=1.2.0',
  '#theme-description' => 'description.theme_description',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'image, slideshow',
  '#theme-view' => 'scene',

  '#content-types' => [

    'images' => [
      '#label' => 'label.images',
      '#description' => 'description.upload_images',
      '#max-values' => 'infinite',
      '#fields' => [

        'image' => [
          '#label' => 'label.image',
          '#description' => 'description.upload_image',
          '#help' => 'help.upload_image',
          '#type' => 'image',
          '#file-extension' => ['jpg', 'png'],
          '#content-preview-image' => true,
          '#required' => true,
        ],

      ], /* fields */

    ], /* blog-posts */

  ], /* content types */

];


