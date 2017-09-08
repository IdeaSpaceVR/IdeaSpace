<?php

return [

  '#theme-name' => 'IdeaSpace 360 Photo Tour',
  '#theme-key' => 'ideaspace-360-photo-tour',
  '#theme-version' => '1.0',
  '#ideaspace-version' => '>=1.0.2',
  '#theme-description' => 'Create and publish a 360 photo sphere tour with info hotspots. Attach text annotations to hotspots.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, 360, photography, tour',
  '#theme-compatibility' => 'Daydream, Oculus Rift, Gear VR, HTC Vive, no headset',
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

        'title' => [
          '#label' => 'Photo Sphere Title',
          '#description' => 'Enter a title.',
          '#help' => 'Enter a title for this photo sphere (optional). The title is shown after the photo sphere has been loaded.',
          '#type' => 'textfield',
          '#maxlength' => 44,
          '#contentformat' => 'text',
          '#required' => false,
        ],

        'photo-sphere' => [
          '#label' => 'Photo Sphere',
          '#description' => 'Upload a photo sphere image.',
          '#help' => 'Photo sphere image in equirectangular projection format.',
          '#type' => 'photosphere',
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
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

        'hotspot-annotations' => [
          '#label' => 'Text Annotations',
          '#description' => 'Attach hotspots with text annotations to your photo sphere.',
          '#help' => 'Attach hotspots with text annotations to your photo sphere.',
          '#type' => 'position',
          '#maxnumber' => 20, 
          '#required' => false,
          '#content-type-reference' => 'annotations',
          '#field-reference' => 'photo-sphere',
        ],

        'photosphere-references' => [
          '#label' => 'Photo Sphere to Photo Sphere Navigation',
          '#description' => 'Attach navigation hotspots to your photo sphere.',
          '#help' => 'Attach navigation hotspots to your photo sphere.',
          '#type' => 'position',
          '#maxnumber' => 20, 
          '#required' => false,
          '#content-type-reference' => 'photo-spheres',
          '#field-reference' => 'photo-sphere',
        ],

        'navigation-hotspot-color' => [
          '#label' => 'Navigation Hotspot Color',
          '#description' => 'Select a color for navigation hotspots.',
          '#help' => 'Select a color for navigation hotspots.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


