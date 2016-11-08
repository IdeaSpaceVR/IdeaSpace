<?php

namespace App\Content; 

use App\Content\FieldTypeColor;
use App\Content\FieldTypeDate;
use App\Content\FieldTypeTextfield;
use App\Content\FieldTypeTextarea;
use App\Content\FieldTypeAudio;
use App\Content\FieldTypeVideo;
use App\Content\FieldTypeVideosphere;
use App\Content\FieldTypeImage;
use App\Content\FieldTypePhotosphere;
use App\Content\FieldTypeModel3D;
use App\Content;
use Log;

class ContentType {

    const FIELD_TYPE_COLOR = 'color';
    const FIELD_TYPE_DATE = 'date';
    const FIELD_TYPE_TEXTFIELD = 'textfield';
    const FIELD_TYPE_TEXTAREA = 'textarea';
    const FIELD_TYPE_AUDIO = 'audio';
    const FIELD_TYPE_IMAGE = 'image';
    const FIELD_TYPE_PHOTOSPHERE = 'photosphere';
    const FIELD_TYPE_VIDEO = 'video';
    const FIELD_TYPE_VIDEOSPHERE = 'videosphere';
    const FIELD_TYPE_MODEL3D = 'model3d';

    private $fieldTypes;

    /**
     * Create a new content type instance.
     * Register field types.
     *
     * @return void
     */
    public function __construct() {

        $this->fieldTypes[ContentType::FIELD_TYPE_VIDEO] = new FieldTypeVideo('public/assets/user/video/');
        $this->fieldTypes[ContentType::FIELD_TYPE_VIDEOSPHERE] = new FieldTypeVideosphere('public/assets/user/videosphere/');
        $this->fieldTypes[ContentType::FIELD_TYPE_AUDIO] = new FieldTypeAudio('public/assets/user/audio/');
        $this->fieldTypes[ContentType::FIELD_TYPE_IMAGE] = new FieldTypeImage('public/assets/user/image/');
        $this->fieldTypes[ContentType::FIELD_TYPE_PHOTOSPHERE] = new FieldTypePhotosphere('public/assets/user/photosphere/');
        $this->fieldTypes[ContentType::FIELD_TYPE_MODEL3D] = new FieldTypeModel3D('public/assets/user/model3d/');
        $this->fieldTypes[ContentType::FIELD_TYPE_COLOR] = new FieldTypeColor();
        $this->fieldTypes[ContentType::FIELD_TYPE_DATE] = new FieldTypeDate();
        $this->fieldTypes[ContentType::FIELD_TYPE_TEXTFIELD] = new FieldTypeTextfield();
        $this->fieldTypes[ContentType::FIELD_TYPE_TEXTAREA] = new FieldTypeTextarea();
    }


    /**
     * Prepare a template.
     * 
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function prepare($contenttype) {

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $contenttype['#fields'][$field_key] = $this->fieldTypes[$properties['#type']]->prepare($field_key, $properties);

            } else {

                /* ignore unknown field type */
                Log::debug('Unknown field type in found: ' . $properties['#type']);
            }
        }

        return $contenttype;
    }

  
    /**
     * Load content for a template.
     *
     * @param integer $content_id
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function load($content_id, $contenttype) {

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $contenttype['#fields'][$field_key] = $this->fieldTypes[$properties['#type']]->load($content_id, $field_key, $properties);

            } else {

                abort(404);
            }
        }

        /* load default content title */
        $content = Content::where('id', $content_id)->first();
        $contenttype['isvr_content_title'] = $content->title;

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

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $validation_rules_messages = $this->fieldTypes[$properties['#type']]->get_validation_rules_messages($validation_rules_messages, $field_key, $properties);

            } else {

                abort(404);
            }
        }

        return $validation_rules_messages;
    }


    /**
     * Create entry, after validation of field values.
     * 
     * @param int $space_id
     * @param String $contenttype_key
     * @param Array $contenttype
     * @param Array $request_all
     *
     * @return content id 
     */
    public function create($space_id, $contenttype_key, $contenttype, $request_all) {

        $content = new Content;
        $content->space_id = $space_id;
        $content->key = $contenttype_key;        

        /* get lowest number and decrement */
        $c = Content::where('space_id', $space_id)->where('key', $contenttype_key)->orderBy('weight', 'asc')->take(1)->first();
        $content->weight = $c->weight - 1;

        $content->title = $request_all['isvr_content_title'];
        $content->save();

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type']) && array_has($request_all, $field_key)) {

                $this->fieldTypes[$properties['#type']]->save($content->id, $field_key, $properties['#type'], $request_all[$field_key]);
            }
        }

        return $content->id;
    }


    /**
     * Update entry, after validation of field values.
     * 
     * @param int $content_id
     * @param String $contenttype_key
     * @param Array $contenttype
     * @param Array $request_all
     *
     * @return content id 
     */
    public function update($content_id, $contenttype_key, $contenttype, $request_all) {

        $content = Content::where('id', $content_id)->first();
        $content->title = $request_all['isvr_content_title'];
        $content->save();

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type']) && array_has($request_all, $field_key)) {

                $this->fieldTypes[$properties['#type']]->save($content_id, $field_key, $properties['#type'], $request_all[$field_key]);
            }
        }

        return true;
    }


}
