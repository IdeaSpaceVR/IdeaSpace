<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Validator;
use App\Space;
use App\Content;
use App\Content\ContentType;
use App\Field;
use App\GenericImage;
use App\GenericFile;
use App\Photosphere;
use Route;
use App\Http\Controllers\Admin\SpaceControllerTrait;
use Log;

class SpaceEditController extends Controller {


    use SpaceControllerTrait;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }


    /**
     * The space edit page.
     *
     * @param String $id 
     *
     * @return Response
     */
    public function space_edit($id) {

        try {
            $space = Space::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            /* case: space exists but theme has been uninstalled */
            abort(404);
        }

				/* find #content-preview-image */
				$preview_field_key ='';
				$config = json_decode($theme->config, true);
				foreach ($config['#content-types'] as $content_type) {
						foreach ($content_type['#fields'] as $field => $field_value) {
								if (array_key_exists('#content-preview-image', $field_value)) {
										if ($field_value['#type'] == ContentType::FIELD_TYPE_IMAGE || $field_value['#type'] == ContentType::FIELD_TYPE_PHOTOSPHERE) {
												$preview_field_key = $field;
										}
								}
						}
				}


        $vars = $this->process_theme($theme);

        /* jquery-ui for draggable and sortable table rows */
        $vars['js'][] = asset('public/jquery-ui/jquery-ui.min.js');
        $vars['js'][] = asset('public/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js');

        foreach ($vars['theme']['contenttypes'] as $contenttype_key => $contenttype_value) {

            $content_vars[$contenttype_key] = $contenttype_value;
            $content = Content::where('space_id', $space->id)->where('key', $contenttype_key)->orderBy('weight', 'asc')->get();

            if (!$content->isEmpty()) {
                foreach ($content->toArray() as $content_key => $content_value) {

										if ($preview_field_key != '') {

												try {
														$preview_field = Field::where('content_id', $content_value['id'])->where('key', $preview_field_key)->where('data', '<>', '')->firstOrFail();

														if ($preview_field->type == ContentType::FIELD_TYPE_PHOTOSPHERE) {

																$preview_field_photosphere = Photosphere::where('id', $preview_field->data)->firstOrFail();
																$preview_img_file = GenericFile::where('id', $preview_field_photosphere->file_id)->firstOrFail();

																$content_value['preview_image_uri'] = asset(substr($preview_img_file->uri, 0, strrpos($preview_img_file->uri, '.')) . GenericFile::THUMBNAIL_FILE_SUFFIX . substr($preview_img_file->uri, strrpos($preview_img_file->uri, '.')));

														} else if ($preview_field->type == ContentType::FIELD_TYPE_IMAGE) {

																$preview_field_image = GenericImage::where('id', $preview_field->data)->firstOrFail();
																$preview_img_file = GenericFile::where('id', $preview_field_image->file_id)->firstOrFail();

																$content_value['preview_image_uri'] = asset(substr($preview_img_file->uri, 0, strrpos($preview_img_file->uri, '.')) . GenericFile::THUMBNAIL_FILE_SUFFIX . substr($preview_img_file->uri, strrpos($preview_img_file->uri, '.')));
														} 
												} catch (ModelNotFoundException $e) {
														/* do nothing */
												}
										}
										//\Log::debug($content_value);
                    $content_vars[$contenttype_key]['content'][$content_key] = $content_value;
                }
            }
        }
        //Log::debug($content_vars); 
        $vars['content'] = $content_vars;
        $vars['space'] = $space;

        /* needed for middleware: app/Http/Middleware/RegisterThemeEventListener.php */
        //session(['theme-id' => $theme->id]);

        return view('admin.space.space_edit', $vars);
    }


    /**
     * Edit space submission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function space_edit_submit(Request $request) {

        return $this->space_edit_submit_process($request);
    }


    /**
     * Save space and redirect to content page.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function space_edit_content_add_submit(Request $request) {

        return $this->space_edit_submit_process($request);
    }


    /**
     * Space submit process.
     *
     * @param Request $request
     *
     * @return Response
     */
    private function space_edit_submit_process(Request $request) {


        $user = Auth::user();
        $theme = Theme::where('id', $request->input('theme_id'))->first();

        $validation_rules = [
            'space_title' => 'required|max:512',
            'space_uri' => 'required|max:255',
        ];

        $validation_messages = [
            'space_title.required' => trans('space_add_controller.validation_space_title_required'),
            'space_title.max' => trans('space_add_controller.validation_space_title_max', ['max' => ':max']),
            'space_uri.required' => trans('space_add_controller.validation_space_uri_required'),
            'space_uri.max' => trans('space_add_controller.validation_space_uri_max', ['max' => ':max']),
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            $vars = $this->process_theme($theme);
            return redirect('admin/space/' . $request->input('space_id') . '/edit')->withErrors($validator)->withInput()->with('vars', $vars);
        }

        $space_id = $request->input('space_id');

        /* generate url-friendly slug */
        $space_uri = str_slug($request->input('space_uri'));

        /* check if uri exists already, except own url */
        try {
            $existing_space = Space::where('uri', $space_uri)->firstOrFail();
            if ($existing_space != null && $existing_space->id != $space_id) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', trans('space_add_controller.validation_space_uri_exists'));
                });
                if ($validator->fails()) {
                    $vars = $this->process_theme($theme);
                    return redirect('admin/space/' . $space_id . '/edit')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        } catch (ModelNotFoundException $e) {
        }

        /* check if uri exists as system uri already */
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if ($route->getPath() == $space_uri) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', trans('space_add_controller.validation_space_uri_exists'));
                });
                if ($validator->fails()) {
                    $vars = $this->process_theme($theme);
                    return redirect('admin/space/' . $space_id . '/edit')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        }
  
        try {
            $space = Space::where('id', $space_id)->firstOrFail();
            $space->title = $request->input('space_title');
            $space->uri = $space_uri;
            $space->status = $request->input('space_status');
            $space->save();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        if ($request->input('contenttype_key') != '') {
            /* space_uri should we shown in an url-friendly way */
            return redirect('admin/space/' . $space->id . '/edit/' . $request->input('contenttype_key') . '/add')->withInput($request->except('space_uri'))->with('space_uri', $space_uri)->with('alert-success', trans('space_add_controller.space_saved'));
        }

        /* space_uri should we shown in an url-friendly way */
        return redirect('admin/space/' . $space->id . '/edit')->withInput($request->except('space_uri'))->with('space_uri', $space_uri)->with('alert-success', trans('space_add_controller.space_saved'));

    }


}
