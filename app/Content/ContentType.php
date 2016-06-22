<?php

namespace App\Content; 

use App\Content\FieldTypeColor;
use App\Content\FieldTypeDate;
use App\Content\FieldTypeTextfield;
use App\Content\FieldTypeTextarea;
use App\Content\FieldTypeAudio;
use App\Content\FieldTypeVideo;
use App\Content\FieldTypeImage;
use Log;

class ContentType {

    const FIELD_TYPE_COLOR = 'color';
    const FIELD_TYPE_DATE = 'date';
    const FIELD_TYPE_TEXTFIELD = 'textfield';
    const FIELD_TYPE_TEXTAREA = 'textarea';
    const FIELD_TYPE_AUDIO = 'audio';
    const FIELD_TYPE_VIDEO = 'video';
    const FIELD_TYPE_IMAGE = 'image';

    private $fieldTypes;

    /**
     * Create a new content type instance.
     * Register field types.
     *
     * @return void
     */
    public function __construct() {

        $this->fieldTypes[ContentType::FIELD_TYPE_VIDEO] = new FieldTypeVideo('public/assets/user/video/');
        $this->fieldTypes[ContentType::FIELD_TYPE_AUDIO] = new FieldTypeAudio('public/assets/user/audio/');
        $this->fieldTypes[ContentType::FIELD_TYPE_IMAGE] = new FieldTypeImage('public/assets/user/image/');
        $this->fieldTypes[ContentType::FIELD_TYPE_COLOR] = new FieldTypeColor();
        $this->fieldTypes[ContentType::FIELD_TYPE_DATE] = new FieldTypeDate();
        $this->fieldTypes[ContentType::FIELD_TYPE_TEXTFIELD] = new FieldTypeTextfield();
        $this->fieldTypes[ContentType::FIELD_TYPE_TEXTAREA] = new FieldTypeTextarea();
    }


    /**
     * Process a theme.
     * 
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function process($contenttype) {

        foreach ($contenttype['#fields'] as $field_id => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $contenttype['#fields'][$field_id] = $this->fieldTypes[$properties['#type']]->process($field_id, $properties);

            } else {

                abort(404);
            }
        }

        return $contenttype;
    }


    /**
     * Get validation rules and messages for fields.
     * 
     * @param Request $request
     * @param Array $contenttype
     *
     * @return $validation_rules_messages
     */
    public function get_validation_rules_messages($request, $contenttype) {

        $validation_rules_messages = [
            'rules' => [], 
            'messages' => []
        ];

        foreach ($contenttype['#fields'] as $field_id => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $validation_rules_messages = $this->fieldTypes[$properties['#type']]->get_validation_rules_messages($validation_rules_messages, $field_id, $properties);

            } else {

                abort(404);
            }
        }

        return $validation_rules_messages;
    }


}
