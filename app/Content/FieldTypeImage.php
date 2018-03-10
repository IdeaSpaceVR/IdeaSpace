<?php

namespace App\Content; 

use App\Field;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\GenericImage;
use App\GenericFile;
use Image;
use Event;
use App\Space;
use App\Theme;
use App\Content;
use File;

class FieldTypeImage {

    use FieldTypeTrait;

    private $template_add = 'admin.space.content.field_image_add';
    private $template_edit = 'admin.space.content.field_image_edit';
    private $template_add_script = 'public/assets/admin/space/content/js/field_image_add.js';
    private $template_edit_script = 'public/assets/admin/space/content/js/field_image_edit.js';
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
        $field['#template_script'] = $this->template_add_script;

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
        $field_arr['#template_script'] = $this->template_edit_script;
        $field_arr['#content'] = array('#value' => null);
        $field_arr['#content'] = array('#id' => null);

        try {
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        try {
            $image = GenericImage::where('id', $field->data)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $field_arr;
        }

        $genericFile = GenericFile::where('id', $image->file_id)->first();

        $thumbnail_uri = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . GenericFile::THUMBNAIL_FILE_SUFFIX . substr($genericFile->uri, strrpos($genericFile->uri, '.'));

        $field_arr['#content']['#value'] = asset($thumbnail_uri);
        $field_arr['#content']['#id'] = $image->id;

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

        /* a proper mime type validation has been done during asset library upload */

        $file_extensions = '';
        foreach ($properties['#file-extension'] as $file_ext) {
            $file_extensions .= $file_ext . ',';
        }
        $file_extensions = substr($file_extensions, 0, -1);

        if ($request->input($field_key) != '' ) {

            $field_value = trim($request->input($field_key));
            $genericImage = GenericImage::where('id', $field_value)->first();
            $genericFile = GenericFile::where('id', $genericImage->file_id)->first();

            $path_parts = pathinfo($genericFile->filename);
            $request->merge([$field_key => $path_parts['extension']]);
            /* needed if we want to store the file id instead of the extension */
            $request->request->add([$field_key . '__image_id' => $field_value]);
            /* needed if we want to retrieve the old input in case of validation error */
            $genericFileThumbnail = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . GenericFile::THUMBNAIL_FILE_SUFFIX . substr($genericFile->uri, strrpos($genericFile->uri, '.'));
            $request->request->add([$field_key . '__image_src' => asset($genericFileThumbnail)]);
        }


        if ($properties['#required']) {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'required|in:' . $file_extensions);

            /* array_dot is flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_key . '.required',
                trans('fieldtype_image.validation_required', ['label' => $properties['#label']])
            ));

            /* array_dot flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_key . '.in',
                trans('fieldtype_image.validation_in', ['label' => $properties['#label'], 'file_extensions' => implode(', ', explode(',', $file_extensions))])
            ));

        } else {

            $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], $field_key, 'in:' . $file_extensions);

            /* array_dot flattens the array because $field_key . '.required' creates new array */
            $validation_rules_messages['messages'] = array_dot(array_add(
                $validation_rules_messages['messages'],
                $field_key . '.in',
                trans('fieldtype_image.validation_in', ['label' => $properties['#label'], 'file_extensions' => implode(', ', explode(',', $file_extensions))])
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

        $first_or_updated = false;

        try {
            /* there is only one field key per content (id) */
            $field = Field::where('content_id', $content_id)->where('key', $field_key)->firstOrFail();

            if (array_has($request_all, $field_key . '__image_id')) {

                /* updated value */
                if ($field->data !== $request_all[$field_key . '__image_id']) { 
                    $old_data = $field->data;
                    $field->data = $request_all[$field_key . '__image_id'];
                    $field->save();

                    /* delete generated images for this field, because file changed */
                    //$genericImage = GenericImage::where('id', $old_data)->first();
                    //$genericFile = GenericFile::where('id', $genericImage->file_id)->first();
                    //$pathinfo = pathinfo($genericFile->uri);

                    $meta_data = json_decode($field->meta_data, true);
                    if (!is_null($meta_data) && array_key_exists(Theme::THEME_GENERATED_IMAGES, $meta_data)) {
                        foreach ($meta_data[Theme::THEME_GENERATED_IMAGES] as $image_info => $image_info_value) {            
                            File::delete(GenericImage::IMAGE_STORAGE_PATH . $image_info_value);
                        }
                    }

                    $first_or_updated = true;
                }

            } else {

                /* delete generated images for this field */
                //$genericImage = GenericImage::where('id', $field->data)->first();
                //$genericFile = GenericFile::where('id', $genericImage->file_id)->first();
                //$pathinfo = pathinfo($genericFile->uri);

                $meta_data = json_decode($field->meta_data, true);
                if (!is_null($meta_data) && array_key_exists(Theme::THEME_GENERATED_IMAGES, $meta_data)) {
                    foreach ($meta_data[Theme::THEME_GENERATED_IMAGES] as $image_info => $image_info_value) {            
                        File::delete(GenericImage::IMAGE_STORAGE_PATH . $image_info_value);
                    }
                }
                $field->delete();
            }

        } catch (ModelNotFoundException $e) {

            if (array_has($request_all, $field_key . '__image_id')) {
                $field = new Field;
                $field->content_id = $content_id;
                $field->key = $field_key;
                $field->type = $type;
                $field->data = $request_all[$field_key . '__image_id'];
                $field->save();

                $first_or_updated = true;
            }
        }


        if ($first_or_updated) {

            $genericImage = GenericImage::where('id', $field->data)->first();
            $genericFile = GenericFile::where('id', $genericImage->file_id)->first();

            $space = Space::where('id', $space_id)->first();
            $theme = Theme::where('id', $space->theme_id)->first();
            $config = json_decode($theme->config, true); 

            $image = Image::make($genericFile->uri);

            /* fire events defined in theme functions.php */
            $content = Content::where('id', $content_id)->first();
            $image_settings = Event::fire($config['#theme-key'] . '.' . $content->key . '.' . $field_key, $image);
            $image->destroy();

            /* defined in app/Helpers/* */
            $images_info = generate_images($genericFile->uri, $image_settings, $field->id); 

            $field->meta_data = json_encode($images_info);
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

        try {
            $image = GenericImage::where('id', $field->data)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return;
        }

        $genericFile = GenericFile::where('id', $image->file_id)->first();

        /* delete generated images for this field */
        $pathinfo = pathinfo($genericFile->uri);
        $meta_data = json_decode($field->meta_data, true);
        if (!is_null($meta_data) && array_key_exists(Theme::THEME_GENERATED_IMAGES, $meta_data)) {
            foreach ($meta_data[Theme::THEME_GENERATED_IMAGES] as $image_info => $image_info_value) {
                File::delete(GenericImage::IMAGE_STORAGE_PATH . $image_info_value);
            }
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
            '#file-extension' => 'array'];

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

        try {
            $image = GenericImage::where('id', $field->data)->firstOrFail();
            $genericFile = GenericFile::where('id', $image->file_id)->first();
            //$pathinfo = pathinfo($genericFile->uri);

            $meta_data = json_decode($field->meta_data, true);

            if (!is_null($meta_data) && array_key_exists(Theme::THEME_GENERATED_IMAGES, $meta_data)) {
                foreach ($meta_data[Theme::THEME_GENERATED_IMAGES] as $image_info => $image_info_value) {

                    $content_arr[$image_info]['#uri']['#value'] = asset(GenericImage::IMAGE_STORAGE_PATH . $image_info_value);
                }
            }

            $content_arr['#id'] = $field->id;
            $content_arr['#content-id'] = $field->content_id;
            $content_arr['#type'] = $field->type;
            $content_arr['#mime-type'] = $genericFile->filemime;
            $content_arr['#caption'] = $image->caption;
            $content_arr['#description'] = $image->description;
            $content_arr['#width'] = $image->width;
            $content_arr['#height'] = $image->height;
            $content_arr['#uri']['#value'] = asset($genericFile->uri);

        } catch (ModelNotFoundException $e) {
            /* if image has been deleted from assets */
        }

        return $content_arr;
    }


}
