<?php

return [

  '#theme-name' => 'IdeaSpace 360',
  '#theme-key' => 'ideaspace-360-photo-sphere-viewer',
  '#theme-version' => '1.2',
  '#ideaspace-version' => '>=1.1.0',
  '#theme-description' => 'Photo sphere viewer with info hotspots and navigation menu in VR. Attach text and image annotations to hotspots. Add sound to your photo spheres.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, gaze input navigation, mobile, 360, photography',
  '#theme-compatibility' => 'Google Cardboard, Daydream, Oculus, Samsung Gear VR, no headset',
  '#theme-view' => 'scene',

  '#content-types' => [

    'annotations' => [
      '#label' => 'Hotspot Annotation',
      '#description' => 'Manage your hotspot annotations.',
      '#max-values' => 'infinite',
      '#fields' => [

        'text' => [
          '#label' => 'Text',
          '#description' => 'Enter some text.',
          '#help' => '',
          '#type' => 'textarea',
          '#maxlength' => 150, 
          '#rows' => 5, 
          '#contentformat' => 'text', 
          '#required' => true,
        ],

        'text-color' => [
          '#label' => 'Text Color',
          '#description' => 'Select a text color.',
          '#help' => 'Select a text color.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
        ],

        'background-color' => [
          '#label' => 'Annotation Background and Hotspot Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
          '#required' => false,
        ],

      ], /* fields */

    ], /* annotations */

    'photo-spheres' => [
      '#label' => 'Photo Sphere',
      '#description' => 'Manage your photo spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'photo-sphere' => [
          '#label' => 'Photo Sphere',
          '#description' => 'Upload a photo sphere image.',
          '#help' => 'Photo sphere image in equirectangular projection format.',
          '#type' => 'photosphere',
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

        'title' => [
          '#label' => 'Photo Sphere Title',
          '#description' => 'Enter a title.',
          '#help' => 'Enter a title for this photo sphere (optional). The title is shown after the photo sphere has been loaded.',
          '#type' => 'textarea',
          '#maxlength' => 150, 
          '#rows' => 5, 
          '#contentformat' => 'text', 
          '#required' => false,
        ],

        'text-styling' => [
          '#label' => 'Text Styling',
          '#description' => 'Select a style',
          '#help' => 'Select a display style for photo sphere titles and hotspot text annotations.',
          '#type' => 'options-select',
          '#options' => ['text-boxes' => 'Text boxes', 'floating-text' => 'Floating text'],
          '#required' => true,
        ],

        'text-color' => [
          '#label' => 'Title Text Color',
          '#description' => 'Select a text color.',
          '#help' => 'Select a text color.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
        ],

        'background-color' => [
          '#label' => 'Title Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
          '#required' => false,
        ],

        'attach-annotations' => [
          '#label' => 'Text Annotations',
          '#description' => 'Attach hotspots with text annotations to your photo sphere.',
          '#help' => 'Attach hotspots with text annotations to your photo sphere.',
          '#type' => 'position',
          '#maxnumber' => 20, 
          '#required' => false,
          '#content-type-reference' => 'annotations',
          '#field-reference' => 'photo-sphere',
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


