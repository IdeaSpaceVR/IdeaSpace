<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Event;
use App\GenericFile;
use File;
use Image;
use App\Space;
use App\FieldControl;
use App\FieldDataImage;
use App\FieldDataText;
use Auth;
use App\SpaceTrait;
use Log;

class ViewSpaceController extends Controller
{
    use SpaceTrait;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* CORS = Cross Origin Resource Sharing */
        $this->middleware('cors');
        $this->middleware('register.theme.eventlistener');
    }


    /**
     * View published space.
     *
     * @param string $space_uri The space URI identifier.
     *
     * @return Response
     */
    public function view_space($space_uri) {

        try {
            $space = Space::where('uri', $space_uri)->where('status', Space::STATUS_PUBLISHED)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = $this->prepare_space_vars($space, false);

        /* cut off .blade.php */
        return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);
    }


    /**
     * Preview published space.
     *
     * @param string $space_uri The space URI identifier.
     *
     * @return Response
     */
    public function preview_space($space_uri) {

        if (Auth::check()) {

            $user = Auth::user();

            try {
                $space = Space::where('uri', $space_uri)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            $vars = $this->prepare_space_vars($space, true);
        
            /* cut off .blade.php */
            return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);
        }

        return redirect('login');
    }


    /**
     * JSON endpoint for retrieving field data as specified in the theme's config file (preview).
     *
     * @param Request $request The request.
     * @param string $uri The space URI identifier.
     *
     * @return Response
     */
    public function preview_field_data_json(Request $request, $uri) {

        if (Auth::check()) {

            $user = Auth::user();

            try {
                $space = Space::where('uri', $uri)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'Record not found'], 404);
            }

            $response = $this->get_field_data_json($request, $uri, $space);

            return response()->json($response);
        }
        abort(404);
    }


    /**
     * JSON endpoint for retrieving field data as specified in the theme's config file.
     *
     * @param Request $request The request.
     * @param string $uri The space URI identifier.
     *
     * @return Response
     */
    public function field_data_json(Request $request, $uri) {

        try {
            $space = Space::where('uri', $uri)->where('status', Space::STATUS_PUBLISHED)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $response = $this->get_field_data_json($request, $uri, $space);

        return response()->json($response);
    }


    /**
     * Get field data json response.
     * 
     * @param Request $request The request.
     * @param string $uri The space URI identifier.
     * @param Space $space The space.
     *
     * @return response string
     */
    private function get_field_data_json($request, $uri, $space) {

        $response = [];

        $query_params = $request->all();
        if (array_has($query_params, 'key')) {
                try {
                    $field_control = FieldControl::where('space_id', $space->id)->where('key', $query_params['key'])->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    return response()->json(['message' => 'Record not found'], 404);
                }
                switch ($field_control->type) {
                    case Theme::TYPE_IMAGES:
                        if (array_has($query_params, 'chunk-size')) {  
                            $field_data_images = FieldDataImage::where('field_control_id', $field_control->id)->orderBy('weight', 'desc')->paginate(abs($query_params['chunk-size']));
                            $field_data_images->appends(['key' => $query_params['key'], 'chunk-size' => abs($query_params['chunk-size'])]);
                        } else {
                            $field_data_images = FieldDataImage::where('field_control_id', $field_control->id)->orderBy('weight', 'desc')->get();
                        }
                        foreach ($field_data_images as $field_data_image) {
                            $generic_file = GenericFile::where('id', $field_data_image->file_id)->first();
                            $arr = ['image' => asset($generic_file->uri)]; 
                            $image_thumb = $this->get_file_uri($generic_file->uri, '_thumb');
                            if (File::exists($image_thumb)) {
                                $arr['image-thumbnail'] = asset($image_thumb); 
                            }
                            $response['type'] = Theme::TYPE_IMAGES;
                            $response['data'][] = $arr;
                        }
                        break;
                    case Theme::TYPE_IMAGE:

                        break;
                    case Theme::TYPE_MODEL:

                        break;                
                    case Theme::TYPE_MODELS:

                        break;                
                    case Theme::TYPE_TEXTINPUT:
                        $field_data_text = FieldDataText::where('field_control_id', $field_control->id)->first();
                        $response['type'] = Theme::TYPE_TEXTINPUT;
                        $response['data'] = $field_data_text->text;
                        break;                
                    case Theme::TYPE_TEXTAREA:
                        $field_data_text = FieldDataText::where('field_control_id', $field_control->id)->first();
                        $response['type'] = Theme::TYPE_TEXTAREA;
                        $response['data'] = $field_data_text->text;
                        break;                
                    case Theme::TYPE_AUDIO:

                        break;                
                    case Theme::TYPE_VIDEO:

                        break;                
                } /* end: switch */
        }

        if (array_has($query_params, 'chunk-size')) {

            $response['total'] = $field_data_images->total();
            $response['per_page'] = $field_data_images->count();
            $response['current_page'] = $field_data_images->currentPage();
            $response['last_page'] = $field_data_images->lastPage();
            if ($field_data_images->hasMorePages()) {
                $response['next_page_url'] = $field_data_images->nextPageUrl();
            } else {
                $response['next_page_url'] = null;
            }
            $response['prev_page_url'] = $field_data_images->previousPageUrl();
            $response['from'] = $field_data_images->firstItem();
            if ($field_data_images->hasMorePages()) {
                $response['to'] = $field_data_images->lastItem();
            } else {
                $response['to'] = $field_data_images->total();
            }
        } 
        
        return $response;
    }

}



