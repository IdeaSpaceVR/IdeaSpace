<?php

namespace App\Content; 

class FieldTypeImage {


    private $template = 'admin.space.content.field_image';
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
     * Process.
     *
     * @param String $field_id
     * @param Array $properties
     *
     * @return Array
     */
    public function process($field_id, $properties) {

        $field = [];
        $field = $properties;
        $field['#template'] = $this->template;

        return $field;
    }


    /**
     * Get validation rules and messages.
     *
     * @param Array $validation_rules_messages
     * @param String $field_id
     * @param Array $properties
     *
     * @return Array
     */
    public function get_validation_rules_messages($validation_rules_messages, $field_id, $properties) {

        return $validation_rules_messages;
    }


}
