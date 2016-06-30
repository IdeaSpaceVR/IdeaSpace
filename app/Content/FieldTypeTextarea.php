<?php

namespace App\Content; 

use App\Field;

class FieldTypeTextarea {

    const DEFAULT_ROWS = 5;
    const DEFAULT_MAXLENGTH = 550000;
    const CONTENTFORMAT_HTML_TEXT = 'html/text';
    const CONTENTFORMAT_TEXT = 'text';

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

        /* optional */
        if (!isset($properties['#maxlength'])) {
            $properties['#maxlength'] = FieldTypeTextarea::DEFAULT_MAXLENGTH;
        }

        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_id, 'required|max:' . $properties['#maxlength']);

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_id . '.required',
                trans('fieldtype_textarea.validation_required', ['label' => $properties['#label']])
            ));

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_id . '.max',
                trans('fieldtype_textarea.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));

        } else {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_id, 'max:' . $properties['#maxlength']);

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_id . '.max',
                trans('fieldtype_textarea.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));
        }        

        return $validation_rules_messages;
    }

  
    /**
     * Create entry.
     *
     * @param String $content_id
     * @param String $field_id
     * @param String $type
     * @param String $value
     *
     * @return True
     */
    public function create($content_id, $field_id, $type, $value) {

        $field = new Field;
        $field->content_id = $content_id;
        $field->key = $field_id;
        $field->type = $type;
        $field->value = $value;
        $field->save();

        return true;
    }


}
