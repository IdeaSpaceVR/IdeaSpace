<?php

return [

  '#theme-name' => 'Timeline',

  '#theme-version' => '1.0',

  '#theme-description' => 'Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline. Theme for visualizing chronological information on a timeline.',

  '#theme-author-name' => 'IdeaSpace',

  '#theme-author-email' => 'info@ideaspacevr.org',

  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',

  '#theme-keywords' => 'timeline, info-viz',

  '#theme-compatibility' => 'Oculus Rift DK2, Oculus Rift CV1, HTC Vive, Google Cardboard v2, Google Daydream',


  '#content-types' => [ 
    'step' => [ 
      '#label' => 'Timeline Step', 
      '#description' => 'This information represents one step in your timeline.', /* optional */
      '#number-of-values' => 'unlimited', /* 1, 3, unlimited */
      '#fields' => [

        'title' => [
          '#label' => 'Title',
          '#description' => 'Enter a title for this step.', /* optional */
          '#help' => 'Give this step a meaningful title.',
          '#type' => 'textfield', /* field types are defined by IdeaSpace */
          '#maxlength' => 140, /* optional */
          '#contentformat' => 'html/text', /* text */
          '#required' => true, 
        ], 

        'description' => [
          '#label' => 'Description',
          '#description' => 'Enter a description text.',
          '#help' => 'Give as much information as you want. Use text formatting!',
          '#type' => 'textarea', 
          '#rows' => 5, /* optional */
          '#maxlength' => 300, /* optional */
          '#contentformat' => 'html/text', /* text */
          '#required' => true,
        ],

        'image-0' => [
          '#label' => 'Image 1 of 3',
          '#description' => 'Upload your image.',
          '#help' => 'This image will be shown as part of your timeline step.',
          '#type' => 'image', /* type image comes with optional caption and description text fields */ 
          '#required' => true, /* all 5 images are required; if set to false, 0, 1, 2, 3, 4 or 5 are possible */
          '#dimension-normal' => ['width' => 4096], /* optional, dimension-normal, dimension-small */
          '#dimension-small' => ['width' => 512], /* optional, can be width and height and quality */
          '#fileformat' => ['image/jpg', 'image/png']
        ],

        'image-1' => [
          '#label' => 'Image 2 of 3',
          '#description' => 'Upload your image.',
          '#help' => 'This image will be shown as part of your timeline step.',
          '#type' => 'image', /* type image comes with optional title and description text fields */ 
          '#required' => false, /* all 5 images are required; if set to false, 0, 1, 2, 3, 4 or 5 are possible */
          '#fileformat' => ['image/jpg', 'image/png']
        ],

        'image-2' => [
          '#label' => 'Images 3 of 3',
          '#description' => 'Upload your image.',
          '#help' => 'This image will be shown as part of your timeline step.',
          '#type' => 'image', /* type image comes with optional title and description text fields */ 
          '#required' => false, /* all 5 images are required; if set to false, 0, 1, 2, 3, 4 or 5 are possible */
          '#fileformat' => ['image/jpg', 'image/png']
        ],

        'date' => [
          '#label' => 'Date',
          '#description' => 'Set a date for this step.',
          '#help' => 'Enter a date.',
          '#type' => 'date',
          '#required' => true, 
        ],

        'sound' => [
          '#label' => 'Sound',
          '#description' => 'Upload a sound file for this step.',
          '#help' => 'Upload an audio file to associate with this timeline step.',
          '#type' => 'audio',
          '#required' => false, 
          '#fileformat' => ['audio/mp3']
        ],
    
        'color-code' => [
          '#label' => 'Color code',
          '#description' => 'Choose a color code for the environment of this step.',
          '#help' => 'Choose a background color for this timeline step.',
          '#type' => 'color',
          '#required' => false,
        ],

      ], /* fields */
    ], /* step */

    'another' => [
      '#label' => 'Another piece of content', 
      '#description' => 'Another piece of content description.', /* optional */
      '#number-of-values' => 'unlimited', /* 1, 3, unlimited */
      '#fields' => [
        'title' => [
          '#label' => 'Title',
          '#description' => 'Enter a title for this content.', /* optional */
          '#type' => 'textfield', /* field types are defined by IdeaSpace */
          '#required' => true, 
        ], /* title */
      ], /* fields */
    ], /* another */

  ], /* content types */

];




