<?php

return [

  '#theme-name' => 'IdeaSpaceVR Photo Sphere Viewer',
  '#theme-key' => 'ideaspace-photo-sphere-viewer',
  '#theme-version' => '1.0',
  '#theme-description' => '360-degree photo sphere viewer with navigation menu.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, 360-degrees',
  '#theme-compatibility' => 'Oculus Rift DK2, Oculus Rift CV1, HTC Vive v1, Google Cardboard v2, Google Daydream v1',

  '#content-types' => [
    'photo-sphere' => [
      '#label' => 'Photo Sphere',
      '#description' => 'Upload a photo sphere in equirectangular image format.',
      '#max-values' => 'infinite',
      '#fields' => [

        'photo-sphere' => [
          '#label' => 'Photo Sphere',
          '#description' => 'Upload a photo sphere image.',
          '#help' => 'Upload a photo sphere image in equirectangular format.',
          '#type' => 'photosphere',
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

        'title' => [
          '#label' => 'Title',
          '#description' => 'Enter a title for this photo sphere.',
          '#help' => '',
          '#type' => 'textfield',
          '#maxlength' => 140, 
          '#contentformat' => 'html/text', 
          '#required' => true,
        ],

        'description' => [
          '#label' => 'Description',
          '#description' => 'Enter a description for this photo sphere.',
          '#help' => '',
          '#type' => 'textarea',
          '#rows' => 5, 
          '#maxlength' => 300, 
          '#contentformat' => 'html/text', 
          '#required' => true,
        ],

      ],
    ],
  ],
];


