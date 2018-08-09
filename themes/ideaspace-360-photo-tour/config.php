<?php

return [

  '#theme-name' => 'IdeaSpace 360 Photo Tour',
  '#theme-key' => 'ideaspace-360-photo-tour',
  '#theme-version' => '1.5',
  '#ideaspace-version' => '>=1.1.0',
  '#theme-description' => 'Create and publish a 360 photo sphere tour with info hotspots. Attach text annotations to hotspots.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, 360, photography, tour, virtual tour',
  '#theme-view' => 'scene',

  '#content-types' => [

    'annotations' => [
      '#label' => 'Information Hotspot',
      '#description' => 'Manage your information hotspots.',
      '#max-values' => 'infinite',
      '#fields' => [

        'text' => [
          '#label' => 'Text',
          '#description' => 'Enter some text.',
          '#help' => 'Enter some text.',
          '#type' => 'textarea',
          '#maxlength' => 150, 
          '#rows' => 5, 
          '#contentformat' => 'text', 
          '#required' => true,
        ],

        'text-color' => [
          '#label' => 'Text Color for Annotation Text Boxes',
          '#description' => 'Select a text color.',
          '#help' => 'Select a text color.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
        ],

        'background-color' => [
          '#label' => 'Background Color for Annotation Text Boxes',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#000000',
        ],

        'hotspot-color' => [
          '#label' => 'Hotspot Color',
          '#description' => 'Select a hotspot color.',
          '#help' => 'Select a hotspot color.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
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
          '#help' => 'Enter a title for this photo sphere (optional). The title will be shown at navigation hotspots.',
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
					'#content-preview-image' => true,
          '#required' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

        'text-color' => [
          '#label' => 'Photo Sphere Title Text Color',
          '#description' => 'Select a text color for the photo sphere title. Titles are shown at navigation hotspots.',
          '#help' => 'Select a text color for the photo sphere title. Titles are shown at navigation hotspots.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#FFFFFF',
        ],

        'background-color' => [
          '#label' => 'Photo Sphere Title Background Color',
          '#description' => 'Select a background color for the photo sphere title. Titles are shown at navigation hotspots.',
          '#help' => 'Select a background color for the photo sphere title. Titles are shown at navigation hotspots.',
          '#type' => 'color',
          '#required' => false,
        ],

        'hotspot-annotations' => [
          '#label' => 'Photo Sphere Information Hotspots',
          '#description' => 'Attach hotspots with text annotations to your photo sphere.',
          '#help' => 'Attach hotspots with text annotations to your photo sphere.',
          '#type' => 'position',
          '#maxnumber' => 20, 
          '#required' => false,
          '#content-type-reference' => 'annotations',
          '#field-reference' => 'photo-sphere',
        ],

        'photosphere-references' => [
          '#label' => 'Photo Sphere to Photo Sphere Navigation Hotspots',
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

        'navigation-hotspot-arrow-color' => [
          '#label' => 'Navigation Hotspot Arrow Color',
          '#description' => 'Select a color for the arrow of a navigation hotspot.',
          '#help' => 'Select a color for the arrow of a navigation hotspot.',
          '#type' => 'color',
          '#required' => false,
          '#default_value' => '#000000',
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


