<?php

namespace App\Content; 

class FieldTypeTextfield {

    const DEFAULT_MAXLENGTH = 524288;
    const CONTENTFORMAT_HTML_TEXT = 'html/text';
    const CONTENTFORMAT_TEXT = 'text';


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
            $properties['#maxlength'] = FieldTypeTextfield::DEFAULT_MAXLENGTH;
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
            $properties['#maxlength'] = FieldTypeTextfield::DEFAULT_MAXLENGTH;
        }
      
        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_id, 'required|max:' . $properties['#maxlength']); 

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_id . '.required', 
                trans('fieldtype_textfield.validation_required', ['label' => $properties['#label']])
            ));

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_id . '.max', 
                trans('fieldtype_textfield.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));

        } else {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_id, 'max:' . $properties['#maxlength']); 

            /* array_dot is flattens the array because $field_id . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_id . '.max', 
                trans('fieldtype_textfield.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));
        }

        return $validation_rules_messages;
    }

}
