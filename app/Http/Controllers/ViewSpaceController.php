<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\GenericFile;
use File;
use Image;
use App\Space;
use App\FieldControl;
use App\FieldDataImage;
use App\FieldDataText;
use Auth;
use App\Content\ContentType;

class ViewSpaceController extends Controller {

    use SpaceTrait;

    private $contentType;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentType $ct) {

        /* CORS = Cross Origin Resource Sharing */
        $this->middleware('cors');
        $this->contentType = $ct;
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

        $vars = $this->prepare_space_content($space, $this->contentType, false);

        /* cut off .blade.php */
        return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);
    }


    /**
     * Preview space.
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

            $vars = $this->prepare_space_content($space, $this->contentType, true);
        
            /* cut off .blade.php */
            return view('theme::' . substr(Theme::TEMPLATES_SCENE_FILE, 0, -10), $vars);
        }

        return redirect('login');
    }


    /**
     * JSON endpoint for retrieving field data (preview).
     *
     * @param Request $request The request.
     * @param string $uri The space URI identifier.
     * @param string $contenttype_key 
     *
     * @return Response
     */
    public function preview_content_json(Request $request, $uri, $contenttype_key) {

        if (Auth::check()) {

            $user = Auth::user();

            try {
                $space = Space::where('uri', $uri)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json(['message' => 'Record not found'], 404);
            }

            $response = $this->prepare_space_content_json($request, $space, $this->contentType, $contenttype_key);

            return response()->json($response);
        }
        abort(404);
    }


    /**
     * JSON endpoint for retrieving field data as specified in the theme's config file.
     *
     * @param Request $request The request.
     * @param string $uri The space URI identifier.
     * @param string $contenttype_key
     *
     * @return Response
     */
    public function content_json(Request $request, $uri, $contenttype_key) {

        try {
            $space = Space::where('uri', $uri)->where('status', Space::STATUS_PUBLISHED)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $response = $this->prepare_space_content_json($request, $space, $this->contentType, $contenttype_key);

        return response()->json($response);
    }


}



