<?php

return [

  '#theme-name' => 'VR View 360 Image Gallery',
  '#theme-key' => 'vr-view-360-image-gallery',
  '#theme-version' => '1.1',
  '#ideaspace-version' => '>=1.1.0',
  '#theme-description' => 'Photo sphere gallery page. Based on the "VR View for the Web" by Google.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, gaze input navigation, mobile, 360, photography, gallery',
  '#theme-view' => 'scene',

  '#content-types' => [

    'photo-spheres' => [
      '#label' => 'Photo Spheres',
      '#description' => 'Manage your photo spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'photo-sphere-title' => [
          '#label' => 'Photo Sphere Title',
          '#description' => 'The photo sphere title is shown with the preview image.',
          '#help' => 'The photo sphere title is shown with the preview image.',
          '#type' => 'textfield',
          '#required' => true,
          '#maxlength' => 150,
          '#contentformat' => 'text',
        ],

        'photo-sphere-preview' => [
          '#label' => 'Photo Sphere Preview Image',
          '#description' => 'Upload a preview image for your photo sphere image.',
          '#help' => 'Upload a preview image for your photo sphere image. If you do not have an image at hand, it is generated from your photo sphere.',
          '#type' => 'image',
          '#required' => false,
          '#file-extension' => ['jpg', 'png'],
        ],

        'mono-stereo-select' => [
          '#label' => '360 Mono / Stereo',
          '#description' => 'Photo sphere is 360 mono or stereo.',
          '#help' => 'Select if the photo sphere is 360 mono or stereo.',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => ['mono' => '360 Mono', 'stereo' => '360 Stereo'],
        ],

        'photo-sphere' => [
          '#label' => 'Photo Sphere',
          '#description' => 'Upload a photo sphere image.',
          '#help' => 'Photo sphere image in equirectangular projection format.',
          '#type' => 'photosphere',
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


