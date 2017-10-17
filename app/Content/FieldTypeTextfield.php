<?php

namespace App\Content; 

use App\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FieldTypeTextfield {

    use FieldTypeTrait;

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
     * @param int $space_id
     * @param String $field_key
     * @param Array $field_properties
     * @param Array $all_fields 
     *
     * @return Array
     */
    public function prepare($space_id, $field_key, $field_properties, $all_fields) {

        $field = [];

        /* optional */
        if (!isset($field_properties['#maxlength'])) {
            $field_properties['#maxlength'] = FieldTypeTextfield::DEFAULT_MAXLENGTH;
        }

        $field = $field_properties;
        $field['#template'] = $this->template_add;

        return $field;
    }


    /**
     * Load content.
     *
     * @param int $space_id
     * @param int $content_id
     * @param String $field_key
     * @param Array $properties
     * @param Array $all_fields
     *
     * @return Array
     */
    public function load($space_id, $content_id, $field_key, $properties, $all_fields) {

        $field_arr = [];

        $field_arr = $this->prepare($space_id, $field_key, $properties, $all_fields);
        $field_arr['#template'] = $this->template_edit;

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        $field_arr['#content'] = array('#value' => $field->data);

        return $field_arr;
    }


    /**
     * Get validation rules and messages.
     *
     * @param Request $request
     * @param Array $validation_rules_messages
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function get_validation_rules_messages($request, $validation_rules_messages, $field_key, $properties) {

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

            /* array_dot flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'], 
                $field_key . '.max', 
                trans('fieldtype_textfield.validation_max', ['label' => $properties['#label'], 'max' => $properties['#maxlength']])
            ));

        } else {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'max:' . $properties['#maxlength']); 

            /* array_dot flattens the array because $field_key . '.required' creates new array */
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
     * @param int $space_id
     * @param int $content_id
     * @param String $field_key
     * @param String $type
     * @param Array $request_all
     *
     * @return True
     */
    public function save($space_id, $content_id, $field_key, $type, $request_all) {

        try {
            /* there is only one field key per content (id) */
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
            $field->data = $request_all[$field_key];
            $field->save();

        } catch (ModelNotFoundException $e) {

            $field = new Field;
            $field->content_id = $content_id;
            $field->key = $field_key;
            $field->type = $type;
            $field->data = $request_all[$field_key];
            $field->save(); 
        }

        return true;
    }


    /**
     * Delete content.
     *
     * @param integer $content_id
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function delete($content_id, $field_key, $properties) {

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return;
        }
        $field->delete();
    }


    /**
     * Validate theme config field.
     *
     * @param Array $field
     *
     * @return True if valid, false otherwise.
     */
    public function validateThemeFieldType($field) {

        $mandatoryKeys = [
            '#label' => 'string',
            '#description' => 'string',
            '#help' => 'string',
            '#required' => 'boolean',
            '#maxlength' => 'number',
            '#contentformat' => 'string'];

        return $this->validateFieldType($mandatoryKeys, $field);
    }


    /**
     * Load content for theme.
     *
     * @param Field $field
     *
     * @return Array
     */
    public function loadContent($field) {

        $content_arr = [];

        $content_arr['#id'] = $field->id;
        $content_arr['#content-id'] = $field->content_id;
        $content_arr['#type'] = $field->type;
        $content_arr['#value'] = $field->data;

        return $content_arr;
    }


}
