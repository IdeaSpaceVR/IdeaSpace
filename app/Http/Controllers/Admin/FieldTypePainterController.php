<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Content\ContentType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Content;
use App\Content\FieldTypePainter;
use Log;

class FieldTypePainterController extends Controller {


    private $fieldTypePainter;


    /**
     * Create a new controller instance.
     *
     * @param FieldTypePainter $ftr
     *
     * @return void
     */
    public function __construct(FieldTypePainter $ftp) {

        $this->middleware('auth');
        $this->fieldTypePainter = $ftp;
    }


    /**
     * The add/edit painter page.
     *
     * @param int $space_id 
     * @param String $contenttype 
     * @param String $scene_template 
     *
     * @return Response
     */
    public function init_painter($space_id, $contenttype, $scene_template) {

				$vars = [];
				return view('theme::' . $theme_template, $vars);       
    }


}


