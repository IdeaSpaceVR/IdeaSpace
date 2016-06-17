<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Theme;
use App\Space;
use App\Content\ContentType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Event;
use Auth;
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

        $form['css'] = [asset('public/assets/admin/space/css/content_add.css')];
        //Log::debug($vars);

        return response()->view('admin.space.content.content_add', $form);
    }


    /**
     * Add content submission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function content_add_submit(Request $request) {

        $contenType->validate();

        $contenType->save();

        /* space_uri should we shown in an url-friendly way */
        return redirect('admin/space/' . $space->id . '/edit')->withInput($request->except('space_uri'))->with('space_uri', $space_uri)->with('alert-success', 'Space saved.');
    }


}
