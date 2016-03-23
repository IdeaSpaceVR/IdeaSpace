<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Space;
use App\User;
use App\Theme;

class SpacesController extends Controller
{

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
            $config = json_decode($theme->config);
            $space['theme_title'] = $config->title;
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


}
