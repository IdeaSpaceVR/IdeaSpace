<?php

return [

  '#theme-name' => 'VR View 360 Image with Hotspot Navigation',
  '#theme-key' => 'vr-view-360-image-hotspot',
  '#theme-version' => '1.1',
  '#ideaspace-version' => '>=1.1.0',
  '#theme-description' => 'Photo sphere viewer with navigation hotspots. Based on the "VR View for the Web" by Google.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, gaze input navigation, mobile, 360, photography',
  '#theme-view' => 'scene',

  '#content-types' => [

    'photo-spheres' => [
      '#label' => 'Photo Spheres',
      '#description' => 'Manage your photo spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'photo-sphere' => [
          '#label' => 'Photo Sphere',
          '#description' => 'Upload a photo sphere image.',
          '#help' => 'Photo sphere image in equirectangular projection format.',
          '#type' => 'photosphere',
          '#required' => false,
          '#file-extension' => ['jpg', 'png'],
        ],

        'navigation-hotspots' => [
          '#label' => 'Photo Sphere Navigation Hotspot',
          '#description' => 'Add navigation hotspots moving from one photo sphere to the next.',
          '#help' => 'Add navigation hotspots moving from one photo sphere to the next.',
          '#type' => 'position',
          '#maxnumber' => 10, 
          '#required' => false,
          '#content-type-reference' => 'photo-spheres',
          '#field-reference' => 'photo-sphere',
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


