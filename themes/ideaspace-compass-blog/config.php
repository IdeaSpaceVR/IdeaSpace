<?php

return [

  '#theme-name' => 'IdeaSpace Compass Blog',
  '#theme-key' => 'ideaspace-compass-blog',
  '#theme-version' => '1.1',
  '#ideaspace-version' => '>=1.2.0',
  '#theme-description' => 'theme.theme_description',
  '#theme-author-name' => 'IdeaSpaceVR',
  '#theme-author-email' => 'info@ideaspacevr.org',
  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',
  '#theme-keywords' => 'timeline, blog',
  '#theme-view' => 'scene',

  '#content-types' => [

    'general-settings' => [
      '#label' => 'label.general_settings',
      '#description' => 'description.configure_your_space',
      '#max-values' => 1,
      '#fields' => [

        'blog-icon' => [
          '#label' => 'label.blog_icon',
          '#description' => 'description.add_icon_which_represents_your_blog',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
        ],

        'blog-about' => [
          '#label' => 'label.about_your_blog',
          '#description' => 'description.what_blog_about',
          '#help' => 'help.enter_text',
          '#type' => 'textarea',
					'#rows' => 10,
					'#contentformat' => 'html/text',
					'#maxlength' => 10000,
          '#required' => false,
        ],

        'about-blog-background-color' => [
          '#label' => 'label.about_your_blog_background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => false,
        ],

        'blog-audio' => [
          '#label' => 'label.sound',
          '#description' => 'description.add_background_sound',
          '#help' => 'help.add_background_sound',
          '#type' => 'options-select',
          '#options' => ['birds-0' => 'options.birds', 'piano-0' => 'options.piano'],
          '#required' => false,
        ],

				'sky' => [
          '#label' => 'label.sky_type',
          '#description' => 'description.set_type_of_sky',
          '#help' => 'help.set_type_of_sky',
          '#type' => 'options-select',
          '#options' => ['black' => 'options.black_sky', 'stars' => 'options.black_sky_with_stars'],
          '#required' => true,
          '#default_value' => 'black',
        ],

        'sky-stars-color' => [
          '#label' => 'label.sky_stars_color',
          '#description' => 'description.set_color_of_stars',
          '#help' => 'help.set_color_of_stars',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => false,
        ],

				'antialiasing' => [
          '#label' => 'label.antialiasing',
          '#description' => 'description.set_antialiasing',
          '#help' => 'help.mobile_vr_headsets_note',
          '#type' => 'options-select',
          '#options' => ['off' => 'options.off', 'on' => 'options.on'],
          '#required' => true,
          '#default_value' => 'on',
        ],

      ],

    ],


    'blog-posts' => [
      '#label' => 'label.blog_post',
      '#description' => 'description.manage_your_blog_posts',
      '#max-values' => 'infinite',
      '#field-groups' => [
					'north-east' => [
							'title' => 'title.north_east', 
							'help' => 'help.create_content_direction_north_east'
					], 
					'east' => [
							'title' => 'title.east',
							'help' => 'help.create_content_direction_east',
					], 
					'south-east' => [
							'title' => 'title.south_east',
							'help' => 'help.create_content_direction_south_east'
					], 
					'south' => [
							'title' => 'title.south',
							'help' => 'help.create_content_direction_south',
					], 
					'south-west' => [
							'title' => 'title.south_west',
							'help' => 'help.create_content_direction_south_west',
					], 
					'west' => [
							'title' => 'title.west',
							'help' => 'help.create_content_direction_west',
					], 
					'north-west' => [
							'title' => 'title.north_west',
							'help' => 'help.create_content_direction_north_west'
					]
			],

      '#fields' => [

				'post-title-north' => [
          '#label' => 'label.title',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#maxlength' => 1000,
          '#rows' => 10,
          '#contentformat' => 'html/text',
          '#required' => true,
        ],

        'post-display-north-east' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'north-east',
        ],

				'post-text-north-east' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#maxlength' => 20000,
          '#rows' => 10,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'north-east',
        ],

        'post-image-north-east' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'north-east',
        ],

				'post-link-north-east' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'north-east',
        ],

				'post-link-text-north-east' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'north-east',
        ],

        'post-text-image-background-color-north-east' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'north-east',
        ],


        'post-display-east' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'east',
        ],

				'post-text-east' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'east',
        ],

        'post-image-east' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'east',
        ],

				'post-link-east' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'east',
        ],

				'post-link-text-east' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'east',
        ],

        'post-text-image-background-color-east' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'east',
        ],


        'post-display-south-east' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south-east',
        ],

				'post-text-south-east' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south-east',
        ],

        'post-image-south-east' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south-east',
        ],

				'post-link-south-east' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south-east',
        ],

				'post-link-text-south-east' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south-east',
        ],

        'post-text-image-background-color-south-east' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south-east',
        ],


        'post-display-south' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south',
        ],

				'post-text-south' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south',
        ],

        'post-image-south' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south',
        ],

				'post-link-south' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south',
        ],

				'post-link-text-south' => [
          '#label' => 'label.link_description_text',
          '#description' => 'Write some text.',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south',
        ],

        'post-text-image-background-color-south' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south',
        ],


        'post-display-south-west' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'south-west',
        ],

				'post-text-south-west' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'south-west',
        ],

        'post-image-south-west' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'south-west',
        ],

				'post-link-south-west' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'south-west',
        ],

				'post-link-text-south-west' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'south-west',
        ],

        'post-text-image-background-color-south-west' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'south-west',
        ],


        'post-display-west' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'west',
        ],

				'post-text-west' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'west',
        ],

        'post-image-west' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'west',
        ],

				'post-link-west' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'west',
        ],

				'post-link-text-west' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'west',
        ],

        'post-text-image-background-color-west' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'west',
        ],


        'post-display-north-west' => [
          '#label' => 'label.display',
          '#description' => 'description.select_media_type',
          '#help' => 'help.select_media_type',
          '#type' => 'options-select',
          '#required' => true,
          '#options' => [
							'none' => 'options.none',
							'text' => 'options.text',
							'image' => 'options.image',
							'link' => 'options.link',
					],
          '#default_value' => 'none',
          '#field-group' => 'north-west',
        ],

				'post-text-north-west' => [
          '#label' => 'label.text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textarea',
          '#rows' => 10,
          '#maxlength' => 20000,
          '#contentformat' => 'html/text',
          '#required' => false,
          '#field-group' => 'north-west',
        ],

        'post-image-north-west' => [
          '#label' => 'label.image',
          '#description' => 'description.add_an_image',
          '#help' => 'help.add_an_image',
          '#type' => 'image',
					'#content-preview-image' => true,
          '#file-extension' => ['jpg', 'png', 'gif'],
          '#required' => false,
          '#field-group' => 'north-west',
        ],

				'post-link-north-west' => [
          '#label' => 'label.link_url',
          '#description' => 'description.enter_an_url',
          '#help' => 'help.enter_an_url',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 1000,
          '#required' => false,
          '#field-group' => 'north-west',
        ],

				'post-link-text-north-west' => [
          '#label' => 'label.link_description_text',
          '#description' => 'description.write_some_text',
          '#help' => 'help.write_some_text',
          '#type' => 'textfield',
          '#contentformat' => 'text',
          '#maxlength' => 65,
          '#required' => false,
          '#field-group' => 'north-west',
        ],

        'post-text-image-background-color-north-west' => [
          '#label' => 'label.background_color',
          '#description' => 'description.select_background_color',
          '#help' => 'help.select_background_color',
          '#type' => 'color',
					'#default_value' => '#FFFFFF',
          '#required' => true,
          '#field-group' => 'north-west',
        ],

				'post-painter' => [
          '#label' => 'label.paint_on_post',
          '#description' => 'description.paint_on_post',
          '#help' => 'help.painter_help',
          '#type' => 'painter',
          '#scene-template' => 'scene-painter', /* scene without camera and laser-controls */
          '#required' => false,
        ],

      ], /* fields */

    ], /* blog-posts */

  ], /* content types */

];


