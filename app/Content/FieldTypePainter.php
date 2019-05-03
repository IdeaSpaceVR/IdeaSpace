<?php

namespace App\Content; 

use App\Field;
use App\Space;
use App\Theme;
use App\Content;
use App\Content\ContentType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use File;
use Log;

class FieldTypePainter {

    use FieldTypeTrait;

		CONST PAINTING_STORAGE_PATH = 'public/assets/user/paintings/'; 

    private $template_add = 'admin.space.content.field_painter_add';
    private $template_edit = 'admin.space.content.field_painter_edit';
    private $template_modal = 'admin.space.content.field_painter.painter_target';
    private $template_add_edit_script = 'public/assets/admin/space/content/js/field_painter_add_edit.js';


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
        $field = $field_properties;

        $field['#template'] = $this->template_add;
        $field['#template_script'] = $this->template_add_edit_script;
        $field['#template_modal'] = $this->template_modal;

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
        $field_arr['#template_script'] = $this->template_add_edit_script;

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $field_arr['#content'] = array('#value' => '');
            return $field_arr;
        }

				/* field->data is path to apa file */
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

        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'required');

            /* array_dot flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_key . '.required',
                trans('fieldtype_painter.validation_required', ['label' => $properties['#label']])
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

        if ($request_all[$field_key] != '') {

            try {
                /* there is only one field key per content (id) */
                $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();

								/* field->data is base64 encoded blob painting */
								$filename = $field->data;

								File::put($filename, base64_decode($request_all[$field_key]));

            } catch (ModelNotFoundException $e) {

                $field = new Field;
                $field->content_id = $content_id;
                $field->key = $field_key;
                $field->type = $type;

								$filename = FieldTypePainter::PAINTING_STORAGE_PATH . str_random(60) . '.apa';

								File::put($filename, base64_decode($request_all[$field_key]));

								$files = json_decode($field->data, true);

								$files[] = $filename;

                $field->data = json_encode($files);

                $field->save();
            }

        } else {

            try {
                $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();

								File::delete($field->data);

                $field->delete();

            } catch (ModelNotFoundException $e) {
            }
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

				File::delete($field->data);

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
            '#help' => 'string',
            '#required' => 'boolean',
            '#scene-template' => 'string'];

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
			
				/* field->data is path to apa file */
				$files = json_decode($field->data, true);
				$content_arr['#value'] = $files;

        return $content_arr;
    }


}
