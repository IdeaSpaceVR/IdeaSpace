<?php

return [

  '#theme-name' => 'IdeaSpace 360',
  '#theme-key' => 'ideaspace-360-photo-sphere-viewer',
  '#theme-version' => '1.1',
  '#ideaspace-version' => '>=1.0.1',
  '#theme-description' => 'Photo sphere viewer with navigation menu in VR. Attach text annotations to your photo spheres.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'photo sphere, gaze input navigation, mobile, 360, photography',
  '#theme-compatibility' => 'Google Cardboard, Daydream, Oculus, Samsung Gear VR, no headset',
  '#theme-view' => 'scene',

  '#content-types' => [

    'text-notes' => [
      '#label' => 'Text Notes',
      '#description' => 'Manage your text notes which are attached to your photo spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'note' => [
          '#label' => 'Text Note',
          '#description' => 'Enter some text.',
          '#help' => 'The text note can be attached to a photo sphere.',
          '#type' => 'textfield',
          '#maxlength' => 140, 
          '#contentformat' => 'text', 
          '#required' => true,
        ],

      ], /* fields */
    ], /* notes */

    'photo-spheres' => [
      '#label' => 'Photo Spheres',
      '#description' => 'Manage your photo spheres.',
      '#max-values' => 'infinite',
      '#fields' => [

        'title' => [
          '#label' => 'Photo Sphere Title',
          '#description' => 'Enter a title.',
          '#help' => 'Enter a title for this photo sphere (optional). The title is shown after the photo sphere has been loaded.',
          '#type' => 'textfield',
          '#maxlength' => 140, 
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

        'attach-text-notes' => [
          '#label' => 'Info Notes',
          '#description' => 'Add some text notes to the photo sphere.',
          '#help' => 'Add some contextual information by attaching text notes to your photo sphere.',
          '#type' => 'position',
          '#maxnumber' => 10, 
          '#required' => false,
          '#content-type-reference' => 'text-notes',
          '#field-reference' => 'photo-sphere',
        ],

      ], /* fields */

    ], /* photo-spheres */

  ], /* content types */

];


