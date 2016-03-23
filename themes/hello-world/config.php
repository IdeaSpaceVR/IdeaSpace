<?php

return [

  'title' => 'Hello World',

  'description' => 'An example theme using a textinput control.',

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


