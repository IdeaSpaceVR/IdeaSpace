<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Space;
use App\User;
use App\Theme;
use App\Content;
use App\Field;
use Log;

class SpacesController extends Controller {

    private $items_per_page = 8;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the spaces page.
     *
     * @return Response
     */
    public function spaces_all()
    {
        $spaces = Space::where('status', '<>', Space::STATUS_TRASH)->orderBy('updated_at', 'desc')->paginate($this->items_per_page);
        $spaces_all = Space::where('status', '<>', Space::STATUS_TRASH)->get();

        foreach ($spaces as $space) {
            $user = User::where('id', $space->user_id)->first();
            $space['author'] = ucfirst($user->name); 
            $theme = Theme::where('id', $space->theme_id)->first();
            $config = json_decode($theme->config, true);
            $space['theme_name'] = $config['#theme-name'];
        }
        
        $number_spaces_published = Space::where('status', Space::STATUS_PUBLISHED)->count();
        $number_spaces_deleted = Space::where('status', Space::STATUS_TRASH)->count();

        $vars['number_spaces_all'] = count($spaces_all);
        $vars['number_spaces_published'] = $number_spaces_published;
        $vars['number_spaces_deleted'] = $number_spaces_deleted;
        $vars['spaces'] = $spaces;
        $vars['js'] = array(asset('public/assets/admin/spaces/js/spaces.js'));
        $vars['css'] = array(asset('public/assets/admin/spaces/css/spaces.css'));
  
        return view('admin.spaces', $vars);
    }

    /**
     * Show the spaces page.
     *
     * @return Response
     */
    public function spaces_published()
    {
        $spaces = Space::where('status', Space::STATUS_PUBLISHED)->orderBy('updated_at', 'desc')->paginate($this->items_per_page);
        $spaces_all = Space::where('status', Space::STATUS_PUBLISHED)->get();

        foreach ($spaces as $space) {
            $user = User::where('id', $space->user_id)->first();
            $space['author'] = ucfirst($user->name); //$space->user_id;
            $theme = Theme::where('id', $space->theme_id)->first();
            $config = json_decode($theme->config, true);
            $space['theme_name'] = $config['#theme-name'];
        }
        
        $number_spaces_all = Space::count();
        $number_spaces_deleted = Space::where('status', Space::STATUS_TRASH)->count();

        $vars['number_spaces_all'] = $number_spaces_all;
        $vars['number_spaces_published'] = count($spaces_all);
        $vars['number_spaces_deleted'] = $number_spaces_deleted;
        $vars['spaces'] = $spaces;
        $vars['js'] = array(asset('public/assets/admin/spaces/js/spaces.js'));
        $vars['css'] = array(asset('public/assets/admin/spaces/css/spaces.css'));
  
        return view('admin.spaces', $vars);

    }

    /**
     * Show the spaces page.
     *
     * @return Response
     */
    public function spaces_deleted()
    {
        $spaces = Space::where('status', Space::STATUS_TRASH)->orderBy('updated_at', 'desc')->paginate($this->items_per_page);
        $spaces_all = Space::where('status', Space::STATUS_TRASH)->get();

        foreach ($spaces as $space) {
            $user = User::where('id', $space->user_id)->first();
            $space['author'] = ucfirst($user->name); //$space->user_id;
            $theme = Theme::where('id', $space->theme_id)->first();
            $config = json_decode($theme->config, true);
            $space['theme_name'] = $config['#theme-name'];
        }
        
        $number_spaces_all = Space::count();
        $number_spaces_published = Space::where('status', Space::STATUS_PUBLISHED)->count();

        $vars['number_spaces_all'] = $number_spaces_all;
        $vars['number_spaces_published'] = $number_spaces_published;
        $vars['number_spaces_deleted'] = count($spaces_all);
        $vars['spaces'] = $spaces;
        $vars['js'] = array(asset('public/assets/admin/spaces/js/spaces.js'));
        $vars['css'] = array(asset('public/assets/admin/spaces/css/spaces.css'));

        return view('admin.spaces', $vars);
    }


     /**
     * Delete a space.
     *
     * @return Response
     */
    public function space_delete($id) {

        try {
            $space = Space::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $content = Content::where('space_id', $space->id)->get();
        foreach ($content as $cont) {
            $fields = Field::where('content_id', $cont->id)->get();
            foreach ($fields as $field) {
                $field->delete();
            }
            $cont->delete();
        }    

        $space->delete();

        return redirect()->route('spaces_deleted')->with('alert-success', trans('spaces_controller.space_deleted'));
    }


    /**
     * Trash a space (move to trash).
     *
     * @return Response
     */
    public function space_trash($id) {

        try {
            $space = Space::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $space->status = Space::STATUS_TRASH;
        $space->save();

        return redirect()->route('spaces_all')->with('alert-success', trans('spaces_controller.space_trashed', ['route' => route('space_restore', ['id' => $space->id])]));
    }


    /**
     * Restore a space (from trash).
     *
     * @return Response
     */
    public function space_restore($id) {

        try {
            $space = Space::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $space->status = Space::STATUS_DRAFT;
        $space->save();

        return redirect()->route('spaces_all')->with('alert-success', trans('spaces_controller.space_restored'));
    }


}
