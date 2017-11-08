<?php

namespace App\Content; 

use App\Field;
use App\Space;
use App\Theme;
use App\Content;
use App\Content\ContentType;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FieldTypeRotation {

    use FieldTypeTrait;

    CONST NONE = 'none';

    public $subjectTypeTemplates;

    private $template_add = 'admin.space.content.field_rotation_add';
    private $template_edit = 'admin.space.content.field_rotation_edit';
    private $template_modal = 'admin.space.content.field_rotation.rotation_target';
    private $template_add_edit_script = 'public/assets/admin/space/content/js/field_rotation_add_edit.js';


    /**
     * Create a new field instance.
     *
     * @return void
     */
    public function __construct() {

        $this->subjectTypeTemplates[FieldTypePosition::NONE] = 'admin.space.content.field_rotation.rotation_blank_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_VIDEO] = 'admin.space.content.field_rotation.rotation_video_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_VIDEOSPHERE] = 'admin.space.content.field_rotation.rotation_videosphere_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_PHOTOSPHERE] = 'admin.space.content.field_rotation.rotation_photosphere_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_IMAGE] = 'admin.space.content.field_rotation.rotation_image_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_MODEL3D . '__obj_mtl'] = 'admin.space.content.field_rotation.rotation_model3d_obj_mtl_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_MODEL3D . '__dae'] = 'admin.space.content.field_rotation.rotation_model3d_dae_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_MODEL3D . '__ply'] = 'admin.space.content.field_rotation.rotation_model3d_ply_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_MODEL3D . '__gltf'] = 'admin.space.content.field_rotation.rotation_model3d_gltf_partial';
        $this->subjectTypeTemplates[ContentType::FIELD_TYPE_MODEL3D . '__glb'] = 'admin.space.content.field_rotation.rotation_model3d_glb_partial';
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

        if (array_key_exists('#field-reference', $field) && array_key_exists($field['#field-reference'], $all_fields)) {

            $subject = $all_fields[$field['#field-reference']];

            $field['#field-type'] = $subject['#type'];
            $field['#field-label'] = $subject['#label'];
            $field['#field-name'] = $field['#field-reference'];

        } else {

            /* blank room */
            $field['#field-type'] = '';
            $field['#field-name'] = '';
        }

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

        //if ($request->input($field_key) != '' ) {

            /* needed if we want to retrieve the old input in case of validation error */
            //$request->request->add([$field_key . '__video_id' => $field_value]);
        //}

        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'required');

            /* array_dot flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_key . '.required',
                trans('fieldtype_rotation.validation_required', ['label' => $properties['#label']])
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

        } else {

            try {
                $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
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
            //'#rotation-axis' => 'string',
            '#field-reference' => 'string'];

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
        $content_arr['#rotation'] = [];

        $data_arr = json_decode($field->data, true);

        if (!is_null($data_arr) && sizeof($data_arr) > 0) {
        
            $content_arr['#rotation'] = ['#x' => $data_arr['x'], '#y' => $data_arr['y'], '#z' => $data_arr['z']];
        }

        return $content_arr;
    }


}
