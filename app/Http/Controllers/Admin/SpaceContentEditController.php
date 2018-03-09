<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Theme;
use App\Space;
use App\Content;
use App\Field;
use App\Content\ContentType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Validator;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use Log;

class SpaceContentEditController extends Controller {


    use AssetLibraryControllerTrait;


    private $contentType;

		private $referenceableFieldTypes; 


    /**
     * Create a new controller instance.
     *
     * @param ContentType $ct
     *
     * @return void
     */
    public function __construct(ContentType $ct) {

        $this->middleware('auth');
        $this->middleware('register.theme.eventlistener');
        $this->contentType = $ct;
        $this->referenceableFieldTypes = [
        		'position',
        		'space_reference'
    		];
    }


    /**
     * The content edit page.
     *
     * @param int $space_id Space id.
     * @param String $contenttype Name of content type.
     * @param int $content_id Content id.
     *
     * @return Response
     */
    public function content_edit($space_id, $contenttype, $content_id) {

        try {
            $space = Space::where('id', $space_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        $config = json_decode($theme->config, true);

        if (array_has($config, '#content-types.' . $contenttype)) {
            /* load and process content type and field content */
            $vars = $this->contentType->load($space_id, $content_id, $config['#content-types'][$contenttype]);
        } else {
            abort(404);
        }

        $has_contenttype_uri = false;
        if (isset($config['#content-types'][$contenttype]['#content-type-view']) && strlen($config['#content-types'][$contenttype]['#content-type-view']) > 0) {
            $has_contenttype_uri = true;
        }

        $theme_mod = array();
        $theme_mod['theme-name'] = $config['#theme-name'];
        $theme_mod['theme-version'] = $config['#theme-version'];
        $theme_mod['theme-author-name'] = $config['#theme-author-name'];
        $theme_mod['theme-screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        //\Log::debug($vars);

        $form = array('form' => $vars);

        //$form['space_status'] = Space::STATUS_DRAFT;
        $form['space_id'] = $space_id;
        $form['space_uri'] = $space->uri;
        $form['theme'] = $theme_mod;
        $form['contenttype_name'] = $contenttype;
        $form['has_contenttype_uri'] = $has_contenttype_uri;
        $form['content_id'] = $content_id;

        $form['css'] = [
            asset('public/assets/admin/space/content/css/content_add_edit_delete.css'),
            asset('public/assets/admin/asset-library/css/assets.css'),
        ];

        $form['js_header'] = [
            asset('public/aframe/' . config('app.aframe_lib_for_assets')),
            asset('public/aframe-extras/aframe-extras.loaders.min.js'),
            asset('public/assets/admin/asset-library/js/load-image-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-photosphere-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-video-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-videosphere-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/scene-floor-grid-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/reset-camera-aframe-comp.js')
        ];

        $form['js'] = [
						asset('public/tinymce/js/tinymce/tinymce.min.js'),
            asset('public/assets/admin/space/content/js/content_add_edit_delete.js'),
            asset('public/jquery-file-uploader/dmuploader.js'),
            asset('public/aframe-orbit-controls-component/aframe-orbit-controls-component.min.js'),
						asset('public/aframe-gif-shader/aframe-gif-shader.min.js'),
            asset('public/assets/admin/asset-library/js/assets.js')
        ];

        $form['js'] = array_merge($form['js'], $vars['field_type_scripts']); 
        unset($vars['field_type_scripts']);
 
        /* needed for asset library: resources/views/admin/asset_library/assets_modal.blade.php */
        $form['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
        $form['upload_max_filesize_tooltip'] = trans('asset_library_controller.upload_max_filesize_tooltip');
        $form['post_max_size'] = $this->phpPostMaxSizeSettings();
        $form['max_filesize_bytes'] = $this->phpFileUploadSizeInBytes();
        $form['images'] = $this->get_all_images();

        //Log::debug($vars);

        return view('admin.space.content.content_edit', $form);
    }


    /**
     * Edit content submission.
     *
     * @param Request $request
     * @param int $space_id Space id.
     * @param String $contenttype Name of content type.
     * @param int $content_id Content id.
     *
     * @return Response
     */
    public function content_edit_submit(Request $request, $space_id, $contenttype, $content_id) {

        try {
            $space = Space::where('id', $space_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        $config = json_decode($theme->config, true);

        if (array_has($config, '#content-types.' . $contenttype)) {

            $validation_rules_messages = $this->contentType->get_validation_rules_messages($request, $config['#content-types'][$contenttype]);

            /* add content title rule and message */
            $validation_rules_messages = $this->add_isvr_content_title_rules_messages($validation_rules_messages);

            /* add content uri rule and message if parameter exists */
            if (isset($config['#content-types'][$contenttype]['#content-type-view']) && strlen($config['#content-types'][$contenttype]['#content-type-view']) > 0) {
                $validation_rules_messages = $this->add_isvr_content_uri_rules_messages($validation_rules_messages);
            }
      
            $validator = Validator::make($request->all(), $validation_rules_messages['rules'], $validation_rules_messages['messages']);

            if ($validator->fails()) {
                return redirect('admin/space/' . $space_id . '/edit/' . $contenttype . '/' . $content_id . '/edit')->withErrors($validator)->withInput();
            }

            /* check if uri exists already; must be unique per space */
            if (isset($config['#content-types'][$contenttype]['#content-type-view']) && strlen($config['#content-types'][$contenttype]['#content-type-view']) > 0 && $request->has('isvr_content_uri')) {
                $count = Content::where('space_id', $space->id)->where('uri', str_slug($request->input('isvr_content_uri')))->count();
                if ($count > 0) {
                    $validator->after(function($validator) {
                        $validator->errors()->add('isvr_content_uri', trans('space_content_edit_controller.validation_content_uri_exists'));
                    });
                    if ($validator->fails()) {
                        return redirect('admin/space/' . $space_id . '/edit/' . $contenttype . '/' . $content_id . '/edit')->withErrors($validator)->withInput();
                    }
                }
            }

            $this->contentType->update($content_id, $contenttype, $config['#content-types'][$contenttype], $request->all());

        } else {

           abort(404);
        }

        return redirect('admin/space/' . $space_id . '/edit#' . $contenttype)->with('alert-success', trans('space_content_edit_controller.saved', ['label' => $config['#content-types'][$contenttype]['#label']]));
    }


    /**
     * The content delete page.
     *
     * @param int $space_id Space id.
     * @param String $contenttype Name of content type.
     * @param int $content_id Content id.
     *
     * @return Response
     */
    public function content_delete($space_id, $contenttype, $content_id) {

        try {
            $space = Space::where('id', $space_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        try {
            $content = Content::where('id', $content_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $config = json_decode($theme->config, true);

        $theme_mod = array();
        $theme_mod['theme-name'] = $config['#theme-name'];
        $theme_mod['theme-version'] = $config['#theme-version'];
        $theme_mod['theme-author-name'] = $config['#theme-author-name'];
        $theme_mod['theme-screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        $vars['theme'] = $theme_mod;

        $vars['title'] = $content->title;

        $vars['space_id'] = $space_id;
        $vars['contenttype_name'] = $contenttype;
        $vars['content_id'] = $content_id;
        $vars['label'] = $config['#content-types'][$contenttype]['#label'];

	
				/* content deletion protection */

				/* are there space_reference or position field types used in this theme? */
										
				$content_types = $config['#content-types'];

				foreach ($content_types as $content_type => $content_type_value) {

						foreach ($content_type_value['#fields'] as $field => $field_value) {

								if (isset($field_value['#type']) && in_array($field_value['#type'], $this->referenceableFieldTypes)) {	

            				$contents = Content::where('space_id', $space->id)->where('key', $content_type)->get();

										foreach ($contents as $content) {

												try {
														$fields = Field::where('content_id', $content->id)->where('type', $field_value['#type'])->get();
										
														foreach ($fields as $field) {

																if (isset($field->data) && $field->data != '') {

																		/* get data into array and search for content id from $content_id (content id to be deleted) */
																		$field_data = json_decode($field->data, true);

																		foreach ($field_data as $fd) {

																				/* is there a reference entry for the current - to be deleted - content id? */
																				if (array_key_exists('content_id', $fd) && $fd['content_id'] == $content_id) {

																						/* show message to user that this content is referenced */
																						$vars['referenced_content'][] = [
																								'content_type_other' => $config['#content-types'][$content_type]['#label'], 
																								'content_title_other' => $content->title,
																								'field_id' => $field->id
																						];
																				} /* if */
																		} /* foreach */
																} /* if */
														} /* foreach */
	
												} catch (ModelNotFoundException $e) {
														/* ignore */
												}

										} /* foreach */
								}
						}
				}



        $vars['css'] = [
            asset('public/assets/admin/space/content/css/content_add_edit_delete.css'),
        ];

        $vars['js'] = [
						asset('public/tinymce/js/tinymce/tinymce.min.js'),
            asset('public/assets/admin/space/content/js/content_add_edit_delete.js'),
        ];

        return view('admin.space.content.content_delete', $vars);

    }


    /**
     * Delete content submission.
     *
     * @param Request $request
     * @param int $space_id Space id.
     * @param String $contenttype Name of content type.
     * @param int $content_id Content id.
     *
     * @return Response
     */
    public function content_delete_submit(Request $request, $space_id, $contenttype, $content_id) {

        try {
            $space = Space::where('id', $space_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        $config = json_decode($theme->config, true);

        if (array_has($config, '#content-types.' . $contenttype)) {

            /* delete content and field content */
            $title = $this->contentType->delete($content_id, $config['#content-types'][$contenttype]);

        } else {

            abort(404);
        }


				/* delete reference entry, rewrite rest of data */
				if ($request->has('referenced_field_ids')) {

						$field_ids = $request->input('referenced_field_ids');
						$field_ids = explode(',', $field_ids);

						foreach ($field_ids as $field_id) {

								try {
            				$field = Field::where('id', $field_id)->firstOrFail();
										$data = json_decode($field->data, true);
										$data_copy = json_decode($field->data, true);
										for ($i = 0; $i < sizeof($data); $i++) {
												if ($data[$i]['content_id'] == $content_id) {
														unset($data_copy[$i]);
												}
										}

										if (empty($data_copy)) {
												$field->data = '';
										} else {
												$field->data = json_encode($data_copy);
										}
										$field->save();

								} catch (ModelNotFoundException $e) {
										/* ignore */
								}

						} /* foreach */
				}


        return redirect('admin/space/' . $space_id . '/edit')->with('alert-success', trans('space_content_edit_controller.deleted', ['label' => $title]));
    }


    /**
     * Content weight order submission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function content_weight_order_submit(Request $request) {

        $space_id = $request->input('space_id');        
        $weight_order = $request->input('weight_order');        
        //Log::debug($weight_order);
        foreach ($weight_order as $key => $val) {
            try {
            $content = Content::where('id', $val['id'])->firstOrFail();
            $content->weight = $val['weight'];
            $content->save();
            } catch (ModelNotFoundException $e) {
                /* do nothing */
            }
        }

        return response()->json(['success' => 'true', 'message' => trans('space_content_edit_controller.content_weight_order_saved')]); 
    }


    /**
     * Add rules and messages for content.
     *
     * @param Array $validation_rules_messages
     *
     * @return Array
     */
    function add_isvr_content_title_rules_messages($validation_rules_messages) {

        $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], 'isvr_content_title', 'required|max:250');

        /* array_dot is flattens the array because $field_key . '.required' creates new array */
        $validation_rules_messages['messages'] = array_dot(array_add(
            $validation_rules_messages['messages'],
            'isvr_content_title.required',
            trans('space_content_edit_controller.validation_required', ['label' => 'title'])
        ));

        /* array_dot flattens the array because $field_key . '.required' creates new array */
        $validation_rules_messages['messages'] = array_dot(array_add(
            $validation_rules_messages['messages'],
            'isvr_content_title.max',
            trans('space_content_edit_controller.validation_max', ['label' => 'title', 'max' => '250'])
        ));

        return $validation_rules_messages;
    }


    /**
     * Add rules and messages for content.
     *
     * @param Array $validation_rules_messages
     *
     * @return Array
     */
    function add_isvr_content_uri_rules_messages($validation_rules_messages) {

        $validation_rules_messages['rules'] = array_add($validation_rules_messages['rules'], 'isvr_content_uri', 'required|max:255');

        /* array_dot is flattens the array because $field_key . '.required' creates new array */
        $validation_rules_messages['messages'] = array_dot(array_add(
            $validation_rules_messages['messages'],
            'isvr_content_uri.required',
            trans('space_content_edit_controller.validation_required', ['label' => 'path'])
        ));

        /* array_dot flattens the array because $field_key . '.required' creates new array */
        $validation_rules_messages['messages'] = array_dot(array_add(
            $validation_rules_messages['messages'],
            'isvr_content_uri.max',
            trans('space_content_edit_controller.validation_max', ['label' => 'path', 'max' => '250'])
        ));

        return $validation_rules_messages;
    }


}
