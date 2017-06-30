<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Content\ContentType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Content;
use App\Content\FieldTypePosition;
use App\Model3D;
use App\GenericFile;
use App\GenericImage;
use App\Photosphere;
use App\Videosphere;
use App\Video;
use Log;

class FieldTypePositionController extends Controller {


    private $fieldTypePosition;


    /**
     * Create a new controller instance.
     *
     * @param FieldTypePosition $ftp
     *
     * @return void
     */
    public function __construct(FieldTypePosition $ftp) {

        $this->middleware('auth');
        $this->fieldTypePosition = $ftp;
    }


    /**
     * The add/edit positions page.
     *
     * @param int $space_id 
     * @param String $contenttype 
     * @param String $subject_type The type of the subject (model, image, etc.), already validated during theme installation.
     * @param int $subject_id The id of the subject (model, image, etc.). Optional.
     *
     * @return Response
     */
    public function positions_subject($space_id, $contenttype, $subject_type, $subject_id = NULL) {

        if ($subject_type == ContentType::FIELD_TYPE_MODEL3D && !is_null($subject_id)) {

            /* scale and rotation values must be taken from models table because there might be no fields entry yet */
            /* model data (rotation, scale) is the same as field meta data; when content is saved, model data is copied to field meta data */
            try {
                $model3d = Model3D::where('id', $subject_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            try {
                $genericFile = GenericFile::where('id', $model3d->file_id_0)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            $pathinfo = pathinfo($genericFile->filename);

            switch (strtolower($pathinfo['extension'])) {

                case Model3D::FILE_EXTENSION_GLTF:            
                    $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type . '__' . Model3D::FILE_EXTENSION_GLTF];
                    $model_data = json_decode($model3d->data, true);
                    $scale = '0 0 0';
                    $rotation_x = '0';
                    $rotation_y = '0';
                    $rotation_z = '0';
                    if (!is_null($model_data) && array_key_exists(Model3D::MODEL_SCALE, $model_data) && array_key_exists(Model3D::MODEL_ROTATION, $model_data)) {
                        $scale = $model_data[Model3D::MODEL_SCALE];
                        $rotation = explode(' ', $model_data[Model3D::MODEL_ROTATION]);
                        $rotation_x = $rotation[0];
                        $rotation_y = $rotation[1];
                        $rotation_z = $rotation[2];
                    }
                    $vars = [
                        'model_gltf' => asset($genericFile->uri),
                        'scale' => $scale,
                        'rotation_x' => $rotation_x,
                        'rotation_y' => $rotation_y,
                        'rotation_z' => $rotation_z
                    ];
                    return view($template, $vars);       
                    break;

                case Model3D::FILE_EXTENSION_GLB:            
                    $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type . '__' . Model3D::FILE_EXTENSION_GLB];
                    $model_data = json_decode($model3d->data, true);
                    $scale = '0 0 0';
                    $rotation_x = '0';
                    $rotation_y = '0';
                    $rotation_z = '0';
                    if (!is_null($model_data) && array_key_exists(Model3D::MODEL_SCALE, $model_data) && array_key_exists(Model3D::MODEL_ROTATION, $model_data)) {
                        $scale = $model_data[Model3D::MODEL_SCALE];
                        $rotation = explode(' ', $model_data[Model3D::MODEL_ROTATION]);
                        $rotation_x = $rotation[0];
                        $rotation_y = $rotation[1];
                        $rotation_z = $rotation[2];
                    }
                    $vars = [
                        'model_glb' => asset($genericFile->uri),
                        'scale' => $scale,
                        'rotation_x' => $rotation_x,
                        'rotation_y' => $rotation_y,
                        'rotation_z' => $rotation_z
                    ];
                    return view($template, $vars);       
                    break;

                case Model3D::FILE_EXTENSION_DAE:            
                    $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type . '__' . Model3D::FILE_EXTENSION_DAE];
                    $model_data = json_decode($model3d->data, true);
                    $scale = '0 0 0';
                    $rotation_x = '0';
                    $rotation_y = '0';
                    $rotation_z = '0';
                    if (!is_null($model_data) && array_key_exists(Model3D::MODEL_SCALE, $model_data) && array_key_exists(Model3D::MODEL_ROTATION, $model_data)) {
                        $scale = $model_data[Model3D::MODEL_SCALE];
                        $rotation = explode(' ', $model_data[Model3D::MODEL_ROTATION]);
                        $rotation_x = $rotation[0];
                        $rotation_y = $rotation[1];
                        $rotation_z = $rotation[2];
                    }
                    $vars = [
                        'model_dae' => asset($genericFile->uri),
                        'scale' => $scale,
                        'rotation_x' => $rotation_x,
                        'rotation_y' => $rotation_y,
                        'rotation_z' => $rotation_z
                    ];
                    return view($template, $vars);       
                    break;

                case Model3D::FILE_EXTENSION_OBJ:            
                case Model3D::FILE_EXTENSION_MTL:            
                    $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type . '__' . Model3D::FILE_EXTENSION_OBJ . '_' . Model3D::FILE_EXTENSION_MTL];
                    $model_data = json_decode($model3d->data, true);
                    $scale = '0 0 0';
                    $rotation_x = '0';
                    $rotation_y = '0';
                    $rotation_z = '0';
                    if (!is_null($model_data) && array_key_exists(Model3D::MODEL_SCALE, $model_data) && array_key_exists(Model3D::MODEL_ROTATION, $model_data)) {
                        $scale = $model_data[Model3D::MODEL_SCALE];
                        $rotation = explode(' ', $model_data[Model3D::MODEL_ROTATION]);
                        $rotation_x = $rotation[0];
                        $rotation_y = $rotation[1];
                        $rotation_z = $rotation[2];
                    }
                    if (strtolower($pathinfo['extension']) == Model3D::FILE_EXTENSION_OBJ) { 
                        $model_obj_uri = $genericFile->uri;
                        try {
                            $genericFile2 = GenericFile::where('id', $model3d->file_id_1)->firstOrFail();
                            $model_mtl_uri = $genericFile2->uri;
                        } catch (ModelNotFoundException $e) {
                        } 
                    } else if (strtolower($pathinfo['extension']) == Model3D::FILE_EXTENSION_MTL) {
                        $model_mtl_uri = $genericFile->uri;
                        try {
                            $genericFile2 = GenericFile::where('id', $model3d->file_id_1)->firstOrFail();
                            $model_obj_uri = $genericFile2->uri;
                        } catch (ModelNotFoundException $e) {
                        } 
                    }
                    $vars = [
                        'model_obj' => asset($model_obj_uri),
                        'model_mtl' => asset($model_mtl_uri),
                        'scale' => $scale,
                        'rotation_x' => $rotation_x,
                        'rotation_y' => $rotation_y,
                        'rotation_z' => $rotation_z
                    ];
                    return view($template, $vars);       
                    break;

                case Model3D::FILE_EXTENSION_PLY:            
                    $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type . '__' . Model3D::FILE_EXTENSION_PLY];
                    $model_data = json_decode($model3d->data, true);
                    $scale = '0 0 0';
                    $rotation_x = '0';
                    $rotation_y = '0';
                    $rotation_z = '0';
                    if (!is_null($model_data) && array_key_exists(Model3D::MODEL_SCALE, $model_data) && array_key_exists(Model3D::MODEL_ROTATION, $model_data)) {
                        $scale = $model_data[Model3D::MODEL_SCALE];
                        $rotation = explode(' ', $model_data[Model3D::MODEL_ROTATION]);
                        $rotation_x = $rotation[0];
                        $rotation_y = $rotation[1];
                        $rotation_z = $rotation[2];
                    }
                    $vars = [
                        'model_ply' => asset($genericFile->uri),
                        'scale' => $scale,
                        'rotation_x' => $rotation_x,
                        'rotation_y' => $rotation_y,
                        'rotation_z' => $rotation_z
                    ];
                    return view($template, $vars);       
                    break;
            }

        } else if ($subject_type == ContentType::FIELD_TYPE_IMAGE && !is_null($subject_id)) {

            try {
                $image = GenericImage::where('id', $subject_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            try {
                $genericFile = GenericFile::where('id', $image->file_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            /* calculate aspect ratio for a-frame */
            $width = $image->width;
            $height = $image->height;
            if ($width > $height) {
                $width_meter = $width / $height;
                $height_meter = 1;
            } else if ($width < $height) {
                $height_meter = $height / $width;
                $width_meter = 1;
            } else if ($width == $height) {
                $width_meter = 1;
                $height_meter = 1;
            }
            $vars = [
                'uri' => asset($genericFile->uri),
                'width_meter' => $width_meter,
                'height_meter' => $height_meter
            ];
            $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type];
            return view($template, $vars);       

        } else if ($subject_type == ContentType::FIELD_TYPE_PHOTOSPHERE && !is_null($subject_id)) {

            try {
                $photosphere = Photosphere::where('id', $subject_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            try {
                $genericFile = GenericFile::where('id', $photosphere->file_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            $vars = [
                'uri' => asset($genericFile->uri)
            ];
            $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type];
            return view($template, $vars);       

        } else if ($subject_type == ContentType::FIELD_TYPE_VIDEOSPHERE && !is_null($subject_id)) {

            try {
                $videosphere = Videosphere::where('id', $subject_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            try {
                $genericFile = GenericFile::where('id', $videosphere->file_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            $vars = [
                'uri' => asset($genericFile->uri)
            ];
            $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type];
            return view($template, $vars);       

        } else if ($subject_type == ContentType::FIELD_TYPE_VIDEO && !is_null($subject_id)) {

            try {
                $video = Video::where('id', $subject_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }

            try {
                $genericFile = GenericFile::where('id', $video->file_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                abort(404);
            }
            $vars = [
                'uri' => asset($genericFile->uri)
            ];
            $template = $this->fieldTypePosition->subjectTypeTemplates[$subject_type];
            return view($template, $vars);       

        } else {

            $template = $this->fieldTypePosition->subjectTypeTemplates[FieldTypePosition::NONE];
            $vars = [];
            return view($template, $vars);       
        }
 
    }


}


