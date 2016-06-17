<?php

return [

  '#theme-name' => 'Hello World',

  '#theme-description' => 'An example theme using a textinput control.',

  '#theme-version' => '1.0',

  '#theme-author-name' => 'IdeaSpace',

  '#theme-author-email' => 'info@ideaspacevr.org',

  '#theme-homepage' => 'https://www.ideaspacevr.org/themes',

  '#theme-keywords' => 'example, hello world',

  '#theme-compatibility' => 'Oculus Rift DK2, Oculus Rift CV1, HTC Vive, Google Cardboard v2, Google Daydream',

  'configuration' => [
    'panels' => [
      'my-panel-0' => [
        'label' => 'Your Content',
        'priority' => 5
      ],
    ],
    'controls' => [
      'my_text' => [
        'type' => 'textinput',
        'required' => true,
        'label' => 'Insert your text',
        'description' => 'Insert text to be shown in this WebVR space.',
        'panel' => 'my-panel-0'
      ],
    ],
  ],
 
];


