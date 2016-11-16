<?php

namespace App\Content; 

use App\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\GenericFile;
use App\Audio;
use Log;

class FieldTypeAudio {


    private $template_add = 'admin.space.content.field_audio_add';
    private $template_edit = 'admin.space.content.field_audio_edit';
    private $template_add_script = 'public/assets/admin/space/content/js/field_audio_add.js';
    private $template_edit_script = 'public/assets/admin/space/content/js/field_audio_edit.js';
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
     * Prepare template.
     *
     * @param String $field_key
     * @param Array $properties
     *
     * @return Array
     */
    public function prepare($field_key, $properties) {

        $field = [];
        $field = $properties;
        $field['#template'] = $this->template_add;
        $field['#template_script'] = $this->template_add_script;

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
        $field_arr['#template_script'] = $this->template_edit_script;
        $field_arr['#content'] = array('#value' => null);
        $field_arr['#content'] = array('#id' => null);

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        try {
            $audio = Audio::where('id', $field->value)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        $genericFile = GenericFile::where('id', $audio->file_id)->first();

        $field_arr['#content']['#value'] = asset($genericFile->uri);
        $field_arr['#content']['#id'] = $audio->id;

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

            if (!empty($value)) {
                $field->value = $value;
                $field->save();
            } else {
                $field->delete();
            }

        } catch (ModelNotFoundException $e) {

            if (!empty($value)) {
                $field = new Field;
                $field->content_id = $content_id;
                $field->key = $field_key;
                $field->type = $type;
                $field->value = $value;
                $field->save();
            }
        }

        return true;
    }


}
