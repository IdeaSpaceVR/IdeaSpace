<?php

return [

  '#theme-name' => 'IdeaSpace Compass Blog',
  '#theme-key' => 'ideaspace-compass-blog',
  '#theme-version' => '1.0',
  '#ideaspace-version' => '>=1.2.0',
  '#theme-description' => 'Immerse yourself in blog posts.',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'timeline, blog',
  '#theme-view' => 'scene',

  '#content-types' => [

    'general-settings' => [
      '#label' => 'General Settings',
      '#description' => 'Configure your theme.',
      '#max-values' => 1,
      '#fields' => [

        'blog-icon' => [
          '#label' => 'Blog Icon',
          '#description' => 'Add an icon which represents your blog.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
        ],

        'blog-about' => [
          '#label' => 'About Your Blog',
          '#description' => 'What is your blog about?',
          '#help' => 'Enter a text.',
          '#type' => 'textarea',
					'#rows' => 10,
					'#contentformat' => 'html/text',
					'#maxlength' => 10000,
          '#required' => false,
        ],

        'about-blog-background-color' => [
          '#label' => 'About Your Blog Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => false,
        ],

        'blog-audio' => [
          '#label' => 'Sound',
          '#description' => 'Add background sound to your blog.',
          '#help' => 'Add background sound to your post. Piano by <a href="https://freesound.org/people/ShadyDave/sounds/262259/" target="_blank">ShadyDave</a>. License: <a href="https://creativecommons.org/licenses/by-nc/3.0/" target="_blank">Creative Commons</a>',
          '#type' => 'options-select',
          '#options' => ['birds-0' => 'Birds', 'piano-0' => 'Piano'],
          '#required' => false,
        ],

				'sky' => [
          '#label' => 'Sky Type',
          '#description' => 'Set the type of the sky.',
          '#help' => 'Set the type of the sky.',
          '#type' => 'options-select',
          '#options' => ['black' => 'Black Sky', 'stars' => 'Black Sky With Stars'],
          '#required' => true,
          '#default_value' => 'black',
        ],

        'sky-stars-color' => [
          '#label' => 'Sky Stars Color',
          '#description' => 'Set the color of the stars.',
          '#help' => 'Set the color of the stars.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => false,
        ],

				'antialiasing' => [
          '#label' => 'Antialiasing',
          '#description' => 'Set antialiasing.',
          '#help' => 'Mobile VR headsets may need to have antialiasing set to off (for performance reasons).',
          '#type' => 'options-select',
          '#options' => ['off' => 'Off', 'on' => 'On'],
          '#required' => true,
          '#default_value' => 'on',
        ],

      ],

    ],


    'blog-posts' => [
      '#label' => 'Blog Posts',
      '#description' => 'Manage your blog posts.',
      '#max-values' => 'infinite',
      '#field-groups' => [
					'north-east' => [
							'title' => 'North East', 
							'help' => 'Create content for the direction North East.'
					], 
					'east' => [
							'title' => 'East',
							'help' => 'Create content for the direction East.',
					], 
					'south-east' => [
							'title' => 'South East',
							'help' => 'Create content for the direction South East.'
					], 
					'south' => [
							'title' => 'South',
							'help' => 'Create content for the direction South.',
					], 
					'south-west' => [
							'title' => 'South West',
							'help' => 'Create content for the direction South West.',
					], 
					'west' => [
							'title' => 'West',
							'help' => 'Create content for the direction West.',
					], 
					'north-west' => [
							'title' => 'North West',
							'help' => 'Create content for the direction North West.'
					]
			],
//      '#content-type-view' => 'blog-post', // TEST
      '#fields' => [

				'post-title-north' => [
          '#label' => 'Title',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#maxlength' => 1000,
          '#rows' => 10,
          '#contentformat' => 'html/text',
          '#required' => true,
        ],

        'post-display-north-east' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'north-east',
        ],

				'post-text-north-east' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#maxlength' => 20000,
          '#rows' => 10,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'north-east',
        ],

        'post-image-north-east' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'north-east',
        ],

				'post-link-north-east' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'north-east',
        ],

				'post-link-text-north-east' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'north-east',
        ],

        'post-text-image-background-color-north-east' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'north-east',
        ],


        'post-display-east' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'east',
        ],

				'post-text-east' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'east',
        ],

        'post-image-east' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'east',
        ],

				'post-link-east' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'east',
        ],

				'post-link-text-east' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'east',
        ],

        'post-text-image-background-color-east' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'east',
        ],


        'post-display-south-east' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south-east',
        ],

				'post-text-south-east' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south-east',
        ],

        'post-image-south-east' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south-east',
        ],

				'post-link-south-east' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south-east',
        ],

				'post-link-text-south-east' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south-east',
        ],

        'post-text-image-background-color-south-east' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south-east',
        ],


        'post-display-south' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south',
        ],

				'post-text-south' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south',
        ],

        'post-image-south' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south',
        ],

				'post-link-south' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south',
        ],

				'post-link-text-south' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south',
        ],

        'post-text-image-background-color-south' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south',
        ],


        'post-display-south-west' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south-west',
        ],

				'post-text-south-west' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south-west',
        ],

        'post-image-south-west' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south-west',
        ],

				'post-link-south-west' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south-west',
        ],

				'post-link-text-south-west' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south-west',
        ],

        'post-text-image-background-color-south-west' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south-west',
        ],


        'post-display-west' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'west',
        ],

				'post-text-west' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'west',
        ],

        'post-image-west' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'west',
        ],

				'post-link-west' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'west',
        ],

				'post-link-text-west' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'west',
        ],

        'post-text-image-background-color-west' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'west',
        ],


        'post-display-north-west' => [
          '#label' => 'Display',
          '#description' => 'Select media type.',
          '#help' => 'Select media type.',
          '#type' => 'options-select',
          '#required' => false,
          '#options' => [
							'none' => 'None',
							'text' => 'Text',
							'image' => 'Image',
							'link' => 'Link',
					],
          '#default_value' => 'none',
          '#field-group' => 'north-west',
        ],

				'post-text-north-west' => [
          '#label' => 'Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'north-west',
        ],

        'post-image-north-west' => [
          '#label' => 'Image',
          '#description' => 'Add an image.',
          '#help' => 'Add an image.',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'north-west',
        ],

				'post-link-north-west' => [
          '#label' => 'Link URL',
          '#description' => 'Enter an URL',
          '#help' => 'Enter an URL.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'north-west',
        ],

				'post-link-text-north-west' => [
          '#label' => 'Link Description Text',
          '#description' => 'Write some text.',
          '#help' => 'Write some text.',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'north-west',
        ],

        'post-text-image-background-color-north-west' => [
          '#label' => 'Background Color',
          '#description' => 'Select a background color.',
          '#help' => 'Select a background color.',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'north-west',
        ],

      ], /* fields */

    ], /* blog-posts */

  ], /* content types */

];


