<?php

return [

  '#theme-name' => 'VR View 360 Video Gallery',
  '#theme-key' => 'vr-view-360-video-gallery',
  '#theme-version' => '1.1',
  '#ideaspace-version' => '>=1.1.0',
  '#theme-description' => 'Video sphere gallery page. Based on the "VR View for the Web" by Google.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'video sphere, gaze input navigation, mobile, 360, gallery',
  '#theme-view' => 'scene',

  '#content-types' => [

    'video-spheres' => [
      '#label' => 'Video Spheres',
      '#description' => 'Manage your video spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'video-sphere-title' => [
          '#label' => 'Video Sphere Title',
          '#description' => 'The video sphere title is shown with the preview image.',
          '#help' => 'The video sphere title is shown with the preview image.',
          '#type' => 'textfield',
          '#required' => true,
          '#maxlength' => 150,
          '#contentformat' => 'text',
        ],

        'video-sphere-preview' => [
          '#label' => 'Video Sphere Preview Image',
          '#description' => 'Upload a preview image for your video.',
          '#help' => 'Upload a preview image for your video. If you do not have an image at hand, it is generated from your photo sphere.',
          '#type' => 'image',
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

        'mono-stereo-select' => [
          '#label' => '360 Mono / Stereo',
          '#description' => 'Video is 360 mono or stereo.',
          '#help' => 'Select if the video is 360 mono or stereo.',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => ['mono' => '360 Mono', 'stereo' => '360 Stereo'],
        ],

        'video-sphere' => [
          '#label' => 'Video Sphere',
          '#description' => 'Upload a video sphere in equirectangular projection format.',
          '#help' => 'Video sphere in equirectangular projection format.',
          '#type' => 'videosphere',
          '#required' => true,
          '#file-extension' => ['mp4'],
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


