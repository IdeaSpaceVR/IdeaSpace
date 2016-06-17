<?php

namespace App\Content; 

class FieldTypeTextfield {

    const DEFAULT_MAXLENGTH = 524288;

    private $template = 'admin.space.content.field_textfield';


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

        /* optional */
        if (!isset($properties['#maxlength'])) {
            $properties['#maxlength'] = FieldTypeTextarea::DEFAULT_MAXLENGTH;
        }

        $field = $properties;
        $field['#template'] = $this->template;

        return $field;
    }

}
