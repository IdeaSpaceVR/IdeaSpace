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
use App\Content\FieldTypePosition;
use App\Content\FieldTypeRotation;
use App\Content\FieldTypeSpaceReference;
use App\Content;
use App\Field;
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
    const FIELD_TYPE_POSITION = 'position';
    const FIELD_TYPE_OPTIONS_SELECT = 'options-select';
    const FIELD_TYPE_ROTATION = 'rotation';
    const FIELD_TYPE_SPACE_REFERENCE = 'space-reference';

    public $fieldTypes;


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
        $this->fieldTypes[ContentType::FIELD_TYPE_POSITION] = new FieldTypePosition($this);
        $this->fieldTypes[ContentType::FIELD_TYPE_OPTIONS_SELECT] = new FieldTypeOptionsSelect();
        $this->fieldTypes[ContentType::FIELD_TYPE_ROTATION] = new FieldTypeRotation();
        $this->fieldTypes[ContentType::FIELD_TYPE_SPACE_REFERENCE] = new FieldTypeSpaceReference();
    }


    /**
     * Prepare a template, content add, first time.
     * 
     * @param int $space_id
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function prepare($space_id, $contenttype) {

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $contenttype['#fields'][$field_key] = $this->fieldTypes[$properties['#type']]->prepare($space_id, $field_key, $properties, $contenttype['#fields']);

            } else {

                /* ignore unknown field type */
                Log::debug('Unknown field type found: ' . $properties['#type']);
            }
        }

        /* reduce field type scripts */
        $field_type_scripts = [];
        foreach ($contenttype['#fields'] as $field_key => $properties) {
          if (!array_key_exists($properties['#type'], $field_type_scripts) && array_key_exists('#template_script', $properties)) {
            $field_type_scripts[$properties['#type']] = asset($properties['#template_script']);
          }
        }
        $field_type_scripts = array_values($field_type_scripts);

        $contenttype['field_type_scripts'] = $field_type_scripts;

        return $contenttype;
    }

  
    /**
     * Load content for a template, content edit.
     *
     * @param int $space_id
     * @param int $content_id
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function load($space_id, $content_id, $contenttype) {

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $contenttype['#fields'][$field_key] = $this->fieldTypes[$properties['#type']]->load($space_id, $content_id, $field_key, $properties, $contenttype['#fields']);

            } else {

                abort(404);
            }
        }


        /* reduce field type scripts */
        $field_type_scripts = [];
        foreach ($contenttype['#fields'] as $field_key => $properties) {
          if (!array_key_exists($properties['#type'], $field_type_scripts) && array_key_exists('#template_script', $properties)) {
            $field_type_scripts[$properties['#type']] = asset($properties['#template_script']);
          }
        }
        $field_type_scripts = array_values($field_type_scripts);


        /* load default content title */
        $content = Content::where('id', $content_id)->first();
        $contenttype['isvr_content_title'] = $content->title;
        $contenttype['isvr_content_uri'] = $content->uri;
        $contenttype['field_type_scripts'] = $field_type_scripts;

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

                $validation_rules_messages = $this->fieldTypes[$properties['#type']]->get_validation_rules_messages($request, $validation_rules_messages, $field_key, $properties);

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
        /* need to save content for first entry, otherwise statement to get lowest number fails */
        $content->save();

        /* get lowest number and decrement */
        $c = Content::where('space_id', $space_id)->where('key', $contenttype_key)->orderBy('weight', 'asc')->take(1)->firstOrFail();
        $content->weight = $c->weight - 1;

        $content->title = $request_all['isvr_content_title'];
        if (isset($request_all['isvr_content_uri'])) {
            $content->uri = str_slug($request_all['isvr_content_uri']);
        }
        $content->save();

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type']) && array_has($request_all, $field_key)) {

                $this->fieldTypes[$properties['#type']]->save($space_id, $content->id, $field_key, $properties['#type'], $request_all);
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
        if (isset($request_all['isvr_content_uri'])) {
            $content->uri = str_slug($request_all['isvr_content_uri']);
        }
        $content->save();

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type']) && array_has($request_all, $field_key)) {

                $this->fieldTypes[$properties['#type']]->save($content->space_id, $content_id, $field_key, $properties['#type'], $request_all);
            }
        }

        return true;
    }


    /**
     * Delete content.
     *
     * @param integer $content_id
     * @param Array $contenttype
     *
     * @return $vars
     */
    public function delete($content_id, $contenttype) {

        foreach ($contenttype['#fields'] as $field_key => $properties) {

            if (array_has($this->fieldTypes, $properties['#type'])) {

                $this->fieldTypes[$properties['#type']]->delete($content_id, $field_key, $properties);

            } else {

                abort(404);
            }
        }

        try {
            $content = Content::where('id', $content_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $title = $content->title;
        $content->delete();

        return $title;
    }


    /**
     * Load content for a theme.
     *
     * @param integer $content_id
     *
     * @return $vars
     */
    public function loadContent($content_id) {

        $content_arr = [];

        $fields = Field::where('content_id', $content_id)->get();

        foreach ($fields as $field) {

            $content_arr[$field->key] = $this->fieldTypes[$field->type]->loadContent($field);
        }

        return $content_arr;
    }


    /**
     * Load content for a theme, json format.
     *
     * @param integer $content_id
     *
     * @return $vars
     */
    public function loadContentJson($content_id) {

        $content_arr = [];

        $fields = Field::where('content_id', $content_id)->get();

        foreach ($fields as $field) {

            $content_arr[$field->key] = $this->fieldTypes[$field->type]->loadContent($field);
        }

        return $content_arr;
    }


}
