<?php

namespace App\Content; 

use App\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;

class FieldTypeImage {


    private $template_add = 'admin.space.content.field_image_add';
    private $template_edit = 'admin.space.content.field_image_edit';
    private $storage_path;


    /**
     * Create a new field type instance.
     *
     * @param String $storage_path
     *
     * @return void
     */
    public function __construct($storage_path) {

        $this->storagePath = $storage_path;
    }

  
    /**
     * Prepare template.
     *
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function prepare($field_key, $properties) {

        $field = [];
        $field = $properties;
        $field['#template'] = $this->template_add;

        return $field;
    }


    /**
     * Load content.
     *
     * @param integer $content_id
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function load($content_id, $field_key, $properties) {

        $field_arr = [];

        $field_arr = $this->prepare($field_key, $properties);
        $field_arr['#template'] = $this->template_edit;

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        $field_arr['#content'] = array('#value' => $field->value);

        return $field_arr;
    }


    /**
     * Get validation rules and messages.
     *
     * @param Array $validation_rules_messages
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function get_validation_rules_messages($validation_rules_messages, $field_key, $properties) {

        return $validation_rules_messages;
    }


    /**
     * Save entry.
     *
     * @param String $content_id
     * @param String $field_key
     * @param String $type
     * @param String $value
     *
     * @return True
     */
    public function save($content_id, $field_key, $type, $value) {

        try {
            /* there is only one field key per content (id) */
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
            $field->value = $value;
            $field->save();

        } catch (ModelNotFoundException $e) {

            $field = new Field;
            $field->content_id = $content_id;
            $field->key = $field_key;
            $field->type = $type;
            $field->value = $value;
            $field->save();
        }

        return true;
    }


}
