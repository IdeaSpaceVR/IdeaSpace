<?php

namespace App\Content; 

use App\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FieldTypeTextfield {

    const DEFAULT_MAXLENGTH = 524288;
    const CONTENTFORMAT_HTML_TEXT = 'html/text';
    const CONTENTFORMAT_TEXT = 'text';


    private $template_add = 'admin.space.content.field_textfield_add';
    private $template_edit = 'admin.space.content.field_textfield_edit';


    /**
     * Create a new field instance.
     *
     * @return void
     */
    public function __construct() {
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

        /* optional */
        if (!isset($properties['#maxlength'])) {
            $properties['#maxlength'] = FieldTypeTextfield::DEFAULT_MAXLENGTH;
        }

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
            abort(404);
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

        /* optional */
        if (!isset($properties['#maxlength'])) {
            $properties['#maxlength'] = FieldTypeTextfield::DEFAULT_MAXLENGTH;
        }
      
        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'required|max:' . $properties['#maxlength']); 

            /* array_dot is flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_key . '.required', 
                trans('fieldtype_textfield.validation_required', ['label' => $properties['#label']])
            ));

            /* array_dot is flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_key . '.max', 
                trans('fieldtype_textfield.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));

        } else {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'max:' . $properties['#maxlength']); 

            /* array_dot is flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_key . '.max', 
                trans('fieldtype_textfield.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));
        }

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
