<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Theme;
use App\Space;
use App\Content\ContentType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Event;
use Auth;
use Validator;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use Log;

class SpaceContentAddController extends Controller {


    use AssetLibraryControllerTrait; 


    private $contentType;


    /**
     * Create a new controller instance.
     *
     * @param ContentType $ct
     *
     * @return void
     */
    public function __construct(ContentType $ct) {

        $this->middleware('auth');
        //$this->middleware('register.theme.eventlistener');
        $this->contentType = $ct;
    }


    /**
     * The content add page.
     *
     * @param int $id Space id.
     * @param String $contenttype Name of content type.
     *
     * @return Response
     */
    public function content_add($id, $contenttype) {

        //$theme_id = session('theme-id');        
        try {
            $space = Space::where('id', $id)->firstOrFail();
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

            /* prepare content type and fields */
            $vars = $this->contentType->prepare($config['#content-types'][$contenttype]);

        } else {

            abort(404);
        }

        $theme_mod = array();
        $theme_mod['theme-name'] = $config['#theme-name'];
        $theme_mod['theme-version'] = $config['#theme-version'];
        $theme_mod['theme-author-name'] = $config['#theme-author-name'];
        $theme_mod['theme-screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        $form = array('form' => $vars);
        //$form['space_status'] = Space::STATUS_DRAFT;
        $form['space_id'] = $id;
        $form['theme'] = $theme_mod;
        $form['contenttype_name'] = $contenttype;

        $form['css'] = [
            asset('public/medium-editor/css/medium-editor.min.css'),
            asset('public/medium-editor/css/themes/bootstrap.min.css'),
            asset('public/assets/admin/space/content/css/content_add_edit_delete.css'),
            asset('public/assets/admin/asset-library/css/assets.css'),
        ];

        $form['js_header'] = [
            asset('public/aframe/aframe.min.js'),
            asset('public/assets/admin/asset-library/js/load-image-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-photosphere-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-video-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/load-videosphere-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/scene-floor-grid-aframe-comp.js'),
            asset('public/assets/admin/asset-library/js/reset-camera-aframe-comp.js')
        ];

        $form['js'] = [
            asset('public/vanilla-color-picker/vanilla-color-picker.min.js'),
            asset('public/medium-editor/js/medium-editor.min.js'),
            asset('public/assets/admin/space/content/js/content_add_edit_delete.js'),
            asset('public/jquery-file-uploader/dmuploader.js'),
            asset('public/assets/admin/asset-library/js/assets.js'),
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

        return view('admin.space.content.content_add', $form);
    }


    /**
     * Add content submission.
     *
     * @param Request $request
     * @param int $id Space id.
     * @param String $contenttype Name of content type.
     *
     * @return Response
     */
    public function content_add_submit(Request $request, $id, $contenttype) {

        //$theme_id = session('theme-id');        
        try {
            $space = Space::where('id', $id)->firstOrFail();
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

            $validator = Validator::make($request->all(), $validation_rules_messages['rules'], $validation_rules_messages['messages']);

            if ($validator->fails()) {
                return redirect('admin/space/' . $id . '/edit/' . $contenttype . '/add')->withErrors($validator)->withInput(); 
            }


            /* id = space id */
            $content_id = $this->contentType->create($id, $contenttype, $config['#content-types'][$contenttype], $request->all());

        } else {

            abort(404);
        }

        return redirect('admin/space/' . $id . '/edit#' . $contenttype)->with('alert-success', trans('space_content_add_controller.saved', ['label' => $config['#content-types'][$contenttype]['#label']])); 
    }


    /**
     * Add rules and messages for content title.
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
            trans('space_content_add_controller.validation_required', ['label' => 'title'])
        ));

        /* array_dot flattens the array because $field_key . '.required' creates new array */
        $validation_rules_messages['messages'] = array_dot(array_add(
            $validation_rules_messages['messages'],
            'isvr_content_title.max',
            trans('space_content_add_controller.validation_max', ['label' => 'title', 'max' => '250'])
        ));

        return $validation_rules_messages;
    }


}
