<?php

return [

  '#theme-name' => 'IdeaSpace Welcome!',
  '#theme-key' => 'ideaspace-welcome',
  '#theme-version' => '1.0',
  '#ideaspace-version' => '>=1.1.1',
  '#theme-description' => 'A configurable navigation menu environment theme in order to link to other virtual reality websites.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'entrance, overview',
  '#theme-view' => 'scene',

  '#content-types' => [

    'general-settings' => [
      '#label' => 'General Settings',
      '#description' => 'Configure your theme.',
      '#max-values' => 1,
      '#fields' => [

        'space-title' => [
          '#label' => 'Space Title',
          '#description' => 'Enter a title.',
          '#help' => 'Enter a title.',
          '#type' => 'textfield',
					'#contentformat' => 'html/text',
					'#maxlength' => 1000,
          '#required' => false,
        ],

				'logo' => [
          '#label' => 'Logo',
          '#description' => 'Upload an image.',
          '#help' => 'Upload an image.',
          '#type' => 'image',
          '#required' => false,
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png'],
        ],

				'logo-aspect-ratio' => [
          '#label' => 'Logo Aspect Ratio',
          '#description' => 'If your image appears distorted, try changing the aspect ratio.',
          '#help' => 'If your image appears distorted, try changing the aspect ratio.',
          '#type' => 'options-select',
          '#options' => ['4-3' => '4 : 3', '3-4' => '3 : 4', '16-9' => '16 : 9', '9-16' => '9 : 16', '1-1' => '1 : 1'],
          '#required' => true,
        ],

        'navigation-active-color' => [
          '#label' => 'Active Navigation Color',
          '#description' => 'Select a color.',
          '#help' => 'Select a color.',
          '#type' => 'color',
					'#default_value' => '#0080E5',
          '#required' => false,
        ],

        'navigation-inactive-color' => [
          '#label' => 'Inactive Navigation Color',
          '#description' => 'Select a color.',
          '#help' => 'Select a color.',
          '#type' => 'color',
					'#default_value' => '#999999',
          '#required' => false,
        ],

				'environment' => [
          '#label' => 'Environment',
          '#description' => 'Select an environment.',
          '#help' => 'Select an environment.',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'None', 
							'environment-hills' => 'Environment with hills', 
							'environment-mountains' => 'Environment with mountains',
							'environment-trees' => 'Environment with trees',
							'environment-arches' => 'Environment with arches',
							'environment-tron' => 'Tron',
							'background-color' => 'Background Color',
					],
          '#default_value' => 'none',
        ],

        'environment-ground-color' => [
          '#label' => 'Environment Ground Color',
          '#description' => 'Select a ground color.',
          '#help' => 'Select a ground color.',
          '#type' => 'color',
					'#default_value' => '#CCCCCC',
          '#required' => false,
        ],

        'environment-ground-texture' => [
          '#label' => 'Environment Ground Texture',
          '#description' => 'Select a ground texture.',
          '#help' => 'Select a ground texture.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'walkernoise' => 'Walkernoise',
							'checkerboard' => 'Checkerboard',
							'squares' => 'Squares',
							'none' => 'None', 
					],
          '#default_value' => 'walkernoise',
        ],

        'background-color' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#000000',
          '#required' => false,
        ],

        'a-painter-painting-url' => [
          '#label' => 'A-Painter Painting URL',
          '#description' => 'Enter the URL of your painting.',
          '#help' => 'Make a painting in A-Painter (<a href="https://aframe.io/a-painter/" target="_blank" style="color:#e42b5a;text-decoration:underline">https://aframe.io/a-painter/</a>) and enter the URL of your saved painting. Example: https://ucarecdn.com/1349e661-2fc2-4e35-baba-95daf48c4283/',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1024,
          '#required' => false,
        ],

				'antialiasing' => [
          '#label' => 'Antialiasing',
          '#description' => 'Set antialiasing.',
          '#help' => 'Mobile VR headsets may need to have antialiasing set to off (for performance reasons).',
          '#type' => 'options-select',
          '#options' => ['off' => 'Off', 'on' => 'On'],
          '#required' => true,
          '#default_value' => 'off',
        ],

      ],

    ],


    'space-links' => [
      '#label' => 'Space Links',
      '#description' => 'Manage your space links.',
      '#max-values' => 36,
      '#fields' => [

        'space-link-title' => [
          '#label' => 'Space Link Title',
          '#description' => 'Enter a short space link title',
          '#help' => 'The title is shown in front of the space link image.',
          '#type' => 'textfield',
					'#contentformat' => 'html/text',
					'#maxlength' => 1000,
          '#required' => true,
        ],

        'space-link-image' => [
          '#label' => 'Space Link Image',
          '#description' => 'Uploaded images are resized to 512 x 256 pixel.',
          '#help' => 'Uploaded images are resized to 512 x 256 pixel.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
        ],

        'space-link-reference' => [
          '#label' => 'Space Link',
          '#description' => 'Select a space to link to.',
          '#help' => 'Select a space to link to.',
          '#type' => 'space-reference',
          '#required' => false,
          '#published' => true,
        ],

        'space-link-external' => [
          '#label' => 'External URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
					'#contentformat' => 'text',
					'#maxlength' => 1000,
          '#required' => false,
        ],

        'space-link-background-color' => [
          '#label' => 'Space Link Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => false,
        ],

      ], /* fields */

    ], /*  */

  ], /* content types */

];


