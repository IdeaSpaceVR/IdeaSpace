<?php

namespace App\Content; 

class FieldTypeTextarea {

    const DEFAULT_ROWS = 5;
    const DEFAULT_MAXLENGTH = 550000;

    private $template = 'admin.space.content.field_textarea';


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
        if (!isset($properties['#rows'])) {
            $properties['#rows'] = FieldTypeTextarea::DEFAULT_ROWS;
        }

        /* optional */
        if (!isset($properties['#maxlength'])) {
            $properties['#maxlength'] = FieldTypeTextarea::DEFAULT_MAXLENGTH;
        }

        $field = $properties;
        $field['#template'] = $this->template;

        return $field;
    }

}
