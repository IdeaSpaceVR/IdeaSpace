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
use Log;

class SpaceContentAddController extends Controller {

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
        $this->middleware('register.theme.eventlistener');
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

        $theme_id = session('theme-id');        

        try {
            $theme = Theme::where('id', $theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        $config = json_decode($theme->config, true);

        if (array_has($config, '#content-types.' . $contenttype)) {

            /* process content type and fields */
            $vars = $this->contentType->process($config['#content-types'][$contenttype]);

        } else {

            abort(404);
        }

        $theme_mod = array();
        $theme_mod['theme-name'] = $config['#theme-name'];
        $theme_mod['theme-version'] = $config['#theme-version'];
        $theme_mod['theme-author-name'] = $config['#theme-author-name'];
        $theme_mod['theme-screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        $form = array('form' => $vars);
        $form['space_status'] = Space::STATUS_DRAFT;
        $form['space_id'] = $id;
        $form['theme'] = $theme_mod;
        $form['contenttype_name'] = $contenttype;

        $form['css'] = [
            asset('public/medium-editor/css/medium-editor.min.css'),
            asset('public/medium-editor/css/themes/bootstrap.min.css'),
            asset('public/assets/admin/space/content/css/content_add.css'),
        ];

        $form['js'] = [
            asset('public/medium-editor/js/medium-editor.min.js'),
            asset('public/assets/admin/space/content/js/content_add.js'),
        ];
        //Log::debug($vars);

        return response()->view('admin.space.content.content_add', $form);
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

        $theme_id = session('theme-id');        

        //Log::debug($request->all());

        try {
            $theme = Theme::where('id', $theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        $config = json_decode($theme->config, true);

        if (array_has($config, '#content-types.' . $contenttype)) {

            $validation_rules_messages = $this->contentType->get_validation_rules_messages($request, $config['#content-types'][$contenttype]);
            //Log::debug($validation_rules_messages['rules']);
            //Log::debug($validation_rules_messages['messages']);
            $validator = Validator::make($request->all(), $validation_rules_messages['rules'], $validation_rules_messages['messages']);

            if ($validator->fails()) {
                /* process content type and fields */
                //$vars = $this->contentType->process($config['#content-types'][$contenttype]);
                //Log::debug($vars);
                //$request->session()->flash('errors', $validator->getMessageBag());
                //$request->session()->flash('vars', $vars);
                //$request->flash();
                //return response()->json(['redirect' => url('admin/space/' . $id . '/edit/' . $contenttype . '/add')]);
                return redirect('admin/space/' . $id . '/edit/' . $contenttype . '/add')->withErrors($validator)->withInput(); //->with('vars', $vars);
            }

        } else {

            abort(404);
        }


        //$contenType->save();

        /* space_uri should we shown in an url-friendly way */
        return redirect('admin/space/' . $id . '/edit'); //->withInput($request->except('space_uri'))->with('space_uri', $space_uri)->with('alert-success', 'Space saved.');
    }


}
