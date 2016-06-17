<?php

namespace App\Content; 

class FieldTypeColor {


    private $template = 'admin.space.content.field_color';


    /**
     * Create a new field instance.
     *
     * @return void
     */
    public function __construct() {
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

}
