<?php

return [

  '#theme-name' => 'IdeaSpace Welcome!',
  '#theme-key' => 'ideaspace-welcome',
  '#theme-version' => '1.0',
  '#ideaspace-version' => '>=1.1.1',
  '#theme-description' => 'A theme to create an entrance environment with links to other spaces.',
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

				 'attach-a-painter-paintings' => [
          '#label' => 'Add A-Painter Paintings',
          '#description' => 'Add A-Painter Paintings.',
          '#help' => 'Add A-Painter Paintings.',
          '#type' => 'position',
          '#maxnumber' => 30,
          '#required' => false,
          '#content-type-reference' => 'a-painter-paintings',
          '#field-reference' => 'none',
        ],

      ],

    ],


    'a-painter-paintings' => [
      '#label' => 'Mozilla\'s A-Painter Paintings',
      '#description' => 'Manage your paintings created with A-Painter: <a href="https://aframe.io/a-painter/" target="_blank" style="color:#e42b5a;text-decoration:underline">https://aframe.io/a-painter/</a>',
      '#max-values' => 30,
      '#fields' => [

        'a-painter-painting-url' => [
          '#label' => 'A-Painter Painting URL',
          '#description' => 'Enter the URL of your painting.',
          '#help' => 'Enter the URL of your painting. Example: https://ucarecdn.com/fc9cdc1a-846c-4214-b42f-c986c9ca4309/',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1024,
          '#required' => false,
        ],

				 'scale' => [
          '#label' => 'Scale Painting',
          '#description' => 'Select a scale value.',
          '#help' => 'Select a scale value.',
          '#type' => 'options-select',
          '#options' => [
              '0.10 0.10 0.10' => '0.10',
              '0.20 0.20 0.20' => '0.20',
              '0.30 0.30 0.30' => '0.30',
              '0.40 0.40 0.40' => '0.40',
              '0.50 0.50 0.50' => '0.50',
              '0.60 0.60 0.60' => '0.60',
              '0.70 0.70 0.70' => '0.70',
              '0.80 0.80 0.80' => '0.80',
              '0.90 0.90 0.90' => '0.90',
              '1.00 1.00 1.00' => '1.00',
              '1.10 1.10 1.10' => '1.10',
              '1.20 1.20 1.20' => '1.20',
              '1.30 1.30 1.30' => '1.30',
              '1.40 1.40 1.40' => '1.40',
              '1.50 1.50 1.50' => '1.50',
              '1.60 1.60 1.60' => '1.60',
              '1.70 1.70 1.70' => '1.70',
              '1.80 1.80 1.80' => '1.80',
              '1.90 1.90 1.90' => '1.90',
              '2.00 2.00 2.00' => '2.00',
              '3.00 3.00 3.00' => '3.00',
              '4.00 4.00 4.00' => '4.00',
              '5.00 5.00 5.00' => '5.00',
              '6.00 6.00 6.00' => '6.00',
              '7.00 7.00 7.00' => '7.00',
              '8.00 8.00 8.00' => '8.00',
              '9.00 9.00 9.00' => '9.00',
              '10.00 10.00 10.00' => '10.00',
          ],
          '#required' => false,
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


