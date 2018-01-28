<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\GenericFile;
use App\Model3D;
use App\Texture;
use App\Setting;
use App\Field;
use Auth;
use Image;
use File;
use Log;

class AssetLibraryModelsController extends Controller {


    use AssetLibraryControllerTrait;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }


    /**
     * Asset library index page.
     *
     * @return Response
     */
    public function index() {

        $vars = [
            'upload_max_filesize' => $this->phpFileUploadSizeSettings(),
            'upload_max_filesize_tooltip' => trans('asset_library_controller.upload_max_filesize_tooltip'),
            'post_max_size' => $this->phpPostMaxSizeSettings(),
            'max_filesize_bytes' => $this->phpFileUploadSizeInBytes(),
            'models' => $this->get_all_models()
        ];

        return view('admin.asset_library.models', $vars);
    }


    /**
     * Models upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_models(Request $request) {

        if (!$request->hasFile('file') && !$request->hasInput('queue_id') && !$request->hasInput('queue_length')) {
            abort(404);
        }

        $user = Auth::user();

        $file = $request->file('file');
        $queue_id = $request->input('queue_id');
        $queue_length = $request->input('queue_length');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'model')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_models_controller.wrong_file_type')]);
        }


        /* do not allow uploading a single mtl file */
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Model3D::FILE_EXTENSION_MTL) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }

        /* do not allow uploading a single obj file */
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Model3D::FILE_EXTENSION_OBJ) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }

        /* do not allow uploading single image files */
        if ($queue_length == 1 && (strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_PNG)) {  
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_JPG) { 
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_GIF) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TGA) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TIF) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
        if ($queue_length == 1 && strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TIFF) {
            return response()->json([
                'status' => 'success-ongoing'
            ]); 
        }
  

        $filename_orig = $file->getClientOriginalName();

        /* do not rename *.obj, *.mtl and texture files, as these are referenced in model files */
        if (strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_PNG && 
            strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_JPG &&
            strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_GIF &&
            strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_TGA && 
            strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_TIF && 
            strtolower($file->getClientOriginalExtension()) != Texture::FILE_EXTENSION_TIFF && 
            strtolower($file->getClientOriginalExtension()) != Model3D::FILE_EXTENSION_OBJ &&
            strtolower($file->getClientOriginalExtension()) != Model3D::FILE_EXTENSION_MTL) {
            do {
                $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
                $existingName = GenericFile::where('filename', $newName)->first();
            } while ($existingName !== null);
        } else {
            //$newName = strtolower($filename_orig);
            $newName = $filename_orig;
        }

        /* first file, make a new directory */
        if ($queue_id == 0) {
            $randomDirName = str_random(30);
        } else {
            /* another file which belongs to previous file; retrieve random directory name */ 
            $gf = GenericFile::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
            $pi = pathinfo($gf->uri);
            $randomDirName = str_replace(Model3D::MODEL_STORAGE_PATH, '', $pi['dirname']);
            $randomDirName = str_replace($pi['basename'], '', $randomDirName);                 
        }

        $uri = Model3D::MODEL_STORAGE_PATH . $randomDirName . '/' . $newName;

        /* first file, make a new directory */
        if ($queue_id == 0) {
            $success = File::makeDirectory(Model3D::MODEL_STORAGE_PATH . '/' . $randomDirName);
            if (!$success) {
                return response()->json(['status' => 'error', 'message' => trans('asset_library_models_controller.file_directory_creation_error')]);
            }
        }

        $success = $file->move(Model3D::MODEL_STORAGE_PATH . $randomDirName, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_models_controller.file_moving_error')]);
        }




        /* check if there is an associated mtl file for this obj file */
        if (strtolower($file->getClientOriginalExtension()) == Model3D::FILE_EXTENSION_OBJ) {

            $f = pathinfo($filename_orig);
            $genericFile = null;

            try {
                /* get last uploaded file for this user */
                //$genericFile = GenericFile::where('filename_orig', strtolower($f['filename'] . '.mtl'))->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
                $genericFile = GenericFile::where('filename_orig', 'like', '%.mtl')->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $newFile = GenericFile::create([
                    'user_id' => $user->id,
                    'filename' => $newName,
                    'uri' => $uri,
                    'filemime' => $file->getClientMimeType(),
                    'filesize' => $file->getClientSize(),
                    'filename_orig' => strtolower($filename_orig)
                ]);
                $model = Model3D::create([
                    'user_id' => $user->id,
                    'file_id_0' => $newFile->id,
                    'caption' => '',
                    'description' => '',
                    'data' => '{"scale":"1.0 1.0 1.0","rotation":"0 0 0"}'
                ]);

                /* get textures which belong to this model and set model id */
                $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get(); 
                foreach ($associatedFiles as $af) {
                    try {
                        $t = Texture::where('file_id', $af->id)->whereNull('model_id')->firstOrFail();
                        $t->model_id = $model->id;
                        $t->save();
                    } catch (ModelNotFoundException $e) {
                    } 
                }
            }

            if (!is_null($genericFile)) {
                try {
                    $model = Model3D::where('file_id_0', $genericFile->id)->whereNull('file_id_1')->firstOrFail();     
                    $newFile = GenericFile::create([
                        'user_id' => $user->id,
                        'filename' => $newName,
                        'uri' => $uri,
                        'filemime' => $file->getClientMimeType(),
                        'filesize' => $file->getClientSize(),
                        'filename_orig' => strtolower($filename_orig)
                    ]);
                    /* current file belongs to this model */
                    $model->file_id_1 = $newFile->id;
                    $model->save();

                } catch (ModelNotFoundException $e) {
                    /* current file does not belong to this model */
                    $newFile = GenericFile::create([
                        'user_id' => $user->id,
                        'filename' => $newName,
                        'uri' => $uri,
                        'filemime' => $file->getClientMimeType(),
                        'filesize' => $file->getClientSize(),
                        'filename_orig' => strtolower($filename_orig)
                    ]);
                    $model = Model3D::create([
                        'user_id' => $user->id,
                        'file_id_0' => $newFile->id,
                        'caption' => '',
                        'description' => '',
                        'data' => '{"scale":"1.0 1.0 1.0","rotation":"0 0 0"}'
                    ]);

                    /* get textures which belong to this model and set model id */
                    $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get(); 
                    foreach ($associatedFiles as $af) {
                        try {
                            $t = Texture::where('file_id', $af->id)->whereNull('model_id')->firstOrFail();
                            $t->model_id = $model->id;
                            $t->save();
                        } catch (ModelNotFoundException $e) {
                        } 
                    }

                    return response()->json([
                        'status' => 'success-ongoing'
                    ]);
                }

            } /* end if */
       
        /* check if there is an associated obj file for this mtl file */
        } else if (strtolower($file->getClientOriginalExtension()) == Model3D::FILE_EXTENSION_MTL) {

            $f = pathinfo($filename_orig);
            $genericFile = null;

            try {
                /* get last uploaded file for this user */
                //$genericFile = GenericFile::where('filename_orig', strtolower($f['filename'] . '.obj'))->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
                $genericFile = GenericFile::where('filename_orig', 'like', '%.obj')->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $newFile = GenericFile::create([
                    'user_id' => $user->id,
                    'filename' => $newName,
                    'uri' => $uri,
                    'filemime' => $file->getClientMimeType(),
                    'filesize' => $file->getClientSize(),
                    'filename_orig' => strtolower($filename_orig)
                ]);
                $model = Model3D::create([
                    'user_id' => $user->id,
                    'file_id_0' => $newFile->id,
                    'caption' => '',
                    'description' => '',
                    'data' => '{"scale":"1.0 1.0 1.0","rotation":"0 0 0"}'
                ]);

                /* get textures which belong to this model and set model id */
                $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get(); 
                foreach ($associatedFiles as $af) {
                    try {
                        $t = Texture::where('file_id', $af->id)->whereNull('model_id')->firstOrFail();
                        $t->model_id = $model->id;
                        $t->save();
                    } catch (ModelNotFoundException $e) {
                    } 
                }
            }

            if (!is_null($genericFile)) {
                try {
                    $model = Model3D::where('file_id_0', $genericFile->id)->whereNull('file_id_1')->firstOrFail();     
                    $newFile = GenericFile::create([
                        'user_id' => $user->id,
                        'filename' => $newName,
                        'uri' => $uri,
                        'filemime' => $file->getClientMimeType(),
                        'filesize' => $file->getClientSize(),
                        'filename_orig' => strtolower($filename_orig)
                    ]);
                    /* current file belongs to this model */
                    $model->file_id_1 = $newFile->id;
                    $model->save();

                } catch (ModelNotFoundException $e) {
                    /* current file does not belong to this model */
                    $newFile = GenericFile::create([
                        'user_id' => $user->id,
                        'filename' => $newName,
                        'uri' => $uri,
                        'filemime' => $file->getClientMimeType(),
                        'filesize' => $file->getClientSize(),
                        'filename_orig' => strtolower($filename_orig)
                    ]);
                    $model = Model3D::create([
                        'user_id' => $user->id,
                        'file_id_0' => $newFile->id,
                        'caption' => '',
                        'description' => '',
                        'data' => '{"scale":"1.0 1.0 1.0","rotation":"0 0 0"}'
                    ]);

                    /* get textures which belong to this model and set model id */
                    $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get(); 
                    foreach ($associatedFiles as $af) {
                        try {
                            $t = Texture::where('file_id', $af->id)->whereNull('model_id')->firstOrFail();
                            $t->model_id = $model->id;
                            $t->save();
                        } catch (ModelNotFoundException $e) {
                        } 
                    }

                    return response()->json([
                        'status' => 'success-ongoing'
                    ]);
                }
            }

        /* check if file is texture file */
        } else if (strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_PNG || 
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_JPG ||
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_GIF ||
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TIF ||
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TIFF ||
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_TGA) {

            $newFile = GenericFile::create([
                'user_id' => $user->id,
                'filename' => $newName,
                'uri' => $uri,
                'filemime' => $file->getClientMimeType(),
                'filesize' => $file->getClientSize(),
                'filename_orig' => strtolower($filename_orig)
            ]);

            $associatedModel_id = null;

            /* if it is not the first file, retrieve model which belongs to this file */
            if ($queue_id > 0) {
                $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get();
                foreach ($associatedFiles as $af) {
                    try {
                        $associatedModel = Model3D::where('file_id_0', $af->id)->firstOrFail();
                        $associatedModel_id = $associatedModel->id;
                    } catch (ModelNotFoundException $e) {
                        try {
                            $associatedModel = Model3D::where('file_id_1', $af->id)->firstOrFail();
                            $associatedModel_id = $associatedModel->id;
                        } catch (ModelNotFoundException $e) {
                        }
                    }
                }
            }

            $newTexture = Texture::create([
                'user_id' => $user->id,
                'file_id' => $newFile->id,
                'model_id' => $associatedModel_id
            ]);

            if (is_null($associatedModel_id)) {
                return response()->json([
                    'status' => 'success-ongoing'
                ]); 
            } else {
                $model = $associatedModel;
            }

        } else { 

            $newFile = GenericFile::create([
                'user_id' => $user->id,
                'filename' => $newName,
                'uri' => $uri,
                'filemime' => $file->getClientMimeType(),
                'filesize' => $file->getClientSize(),
                'filename_orig' => strtolower($filename_orig)
            ]);

            $model = Model3D::create([
                'user_id' => $user->id,
                'file_id_0' => $newFile->id,
                'caption' => '',
                'description' => '',
                'data' => '{"scale":"1.0 1.0 1.0","rotation":"0 0 0"}'
            ]);

            /* get textures which belong to this model and set model id */
            $associatedFiles = GenericFile::where('user_id', $user->id)->where('uri', 'like', '%'.$randomDirName.'%')->get(); 
            foreach ($associatedFiles as $af) {
                try {
                    $t = Texture::where('file_id', $af->id)->whereNull('model_id')->firstOrFail();
                    $t->model_id = $model->id;
                    $t->save();
                } catch (ModelNotFoundException $e) {
                } 
            }

        }

        if ($queue_id == ($queue_length-1)) {
            return response()->json([
                'status' => 'success',
                //'uri' => asset($uri),
                'model_id' => $model->id
            ]);
        } else {
            return response()->json([
                'status' => 'success-ongoing'
            ]);
        }
    }


    /**
     * Get localization strings for model uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_models_controller.file_type_error'),
            'file_size_error' => trans('asset_library_models_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_models_controller.file_ext_error'),
            'vr_view' => trans('template_asset_library_models.vr_view'),
            'edit' => trans('template_asset_library_models.edit'),
            'insert' => trans('template_asset_library_models.insert'),
            'save' => trans('template_asset_library_models.save'),
            'saved' => trans('template_asset_library_models.saved'),
            'model_save_as_image_error' => trans('template_asset_library_models.model_save_as_image_error'),
        ]);
    }


    /**
     * Get model preview code.
     *
     * @param int $model_id
     *
     * @return Array
     */
    public function get_model_preview_code($model_id) {

        if (is_null($model_id)) {
            abort(404);
        }

        try {
            $model = Model3D::where('id', $model_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $model->file_id_0)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        $file = pathinfo($genericFile->filename);

        switch (strtolower($file['extension'])) {

            case Model3D::FILE_EXTENSION_GLB:

                $vars = [
                    'model_glb' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_glb_preview', $vars);        

            case Model3D::FILE_EXTENSION_GLTF:

                $vars = [
                    'model_gltf' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_gltf_preview', $vars);        

            case Model3D::FILE_EXTENSION_DAE:

                $vars = [
                    'model_dae' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_dae_preview', $vars);        

            case Model3D::FILE_EXTENSION_OBJ:

                if (!is_null($model->file_id_1)) {
                    try {
                        $mtlFile = GenericFile::where('id', $model->file_id_1)->firstOrFail();
                        $vars = [
                            'model_obj' => asset($genericFile->uri),
                            'model_mtl' => asset($mtlFile->uri)
                        ];
                        return view('admin.asset_library.model_obj_mtl_preview', $vars);        

                    } catch (ModelNotFoundException $e) {
                    } 
                }
                $vars = [
                    'model_obj' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_obj_mtl_preview', $vars);        

            case Model3D::FILE_EXTENSION_MTL:

                if (!is_null($model->file_id_1)) {
                    try {
                        $mtlFile = GenericFile::where('id', $model->file_id_1)->firstOrFail();
                        $vars = [
                            'model_mtl' => asset($genericFile->uri),
                            'model_obj' => asset($mtlFile->uri)
                        ];
                        return view('admin.asset_library.model_obj_mtl_preview', $vars);        

                    } catch (ModelNotFoundException $e) {
                    } 
                }
                $vars = [
                    'model_mtl' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_obj_mtl_preview', $vars);        

            case Model3D::FILE_EXTENSION_PLY:

                $vars = [
                    'model_ply' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_ply_preview', $vars);        

        }

        abort(404);
    }


    /**
     * Save model as preview image. 
     *
     * @param Request $request
     *
     * @return Response
     */
    public function save_image(Request $request) {

        if (!$request->has('canvasData') || !$request->has('model_id')) {
            abort(404);
        }

        $filteredData = str_replace('data:image/png;base64,', '', $request->input('canvasData'));
        $filteredData = str_replace(' ', '+', $filteredData);
        $unencoded = base64_decode($filteredData);

        $model = Model3D::where('id', $request->input('model_id'))->first();
        $genericFile = GenericFile::where('id', $model->file_id_0)->first();
        $f = pathinfo($genericFile->uri);

        $filename = str_random(40) . '_preview.png';

        $image = Image::make($unencoded);

        $uri = $f['dirname'] . '/' . $filename; 

        $image->save($uri);

        $user = Auth::user();

        $genericFile = GenericFile::create([
            'user_id' => $user->id,
            'filename' => $filename,
            'uri' => $uri,
            'filemime' => $image->mime(),
            'filesize' => $image->filesize(),
            'filename_orig' => $filename
        ]);        

        $model->file_id_preview = $genericFile->id;
        $model->save();

        return response()->json([
            'status' => 'success',
            'model_id' => $model->id,
            'uri' => asset($uri)
        ]); 
    }


    /**
     * Model edit page.
     *
     * @param String $field_key
     * @param int $content_id
     * @param int $model_id
     *
     * @return Response
     */
    public function model_edit($field_key, $content_id, $model_id) {

        if (is_null($model_id)) {
            abort(404);
        }

        try {
            $model = Model3D::where('id', $model_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $genericFile = GenericFile::where('id', $model->file_id_0)->first();

        $vars = [];
        $vars['is_dae'] = false;
        $vars['is_gltf'] = false;
        $vars['is_glb'] = false;
        $vars['is_obj_mtl'] = false;
        $vars['is_obj'] = false;
        $vars['is_mtl'] = false;
        $vars['is_ply'] = false;

        $model_file_extension = '';

        $file = pathinfo($genericFile->filename);

        switch (strtolower($file['extension'])) {
            case Model3D::FILE_EXTENSION_GLB:
                $vars['is_glb'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_GLB;
                break;
            case Model3D::FILE_EXTENSION_GLTF:
                $vars['is_gltf'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_GLTF;
                break;
            case Model3D::FILE_EXTENSION_DAE:
                $vars['is_dae'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_DAE;
                break;
            case Model3D::FILE_EXTENSION_OBJ:
                if (!is_null($model->file_id_1)) {
                    $mtlFile = GenericFile::where('id', $model->file_id_1)->first();
                    $vars['is_obj_mtl'] = true;
                    $vars['obj_uri'] = asset($genericFile->uri);
                    $vars['mtl_uri'] = asset($mtlFile->uri);
                    $model_file_extension = Model3D::FILE_EXTENSION_OBJ;
                } else {
                    $vars['is_obj'] = true;
                    $vars['obj_uri'] = asset($genericFile->uri);
                }
                break;
            case Model3D::FILE_EXTENSION_MTL:
                if (!is_null($model->file_id_1)) {
                    $mtlFile = GenericFile::where('id', $model->file_id_1)->first();
                    $vars['is_obj_mtl'] = true;
                    $vars['mtl_uri'] = asset($genericFile->uri);
                    $vars['obj_uri'] = asset($mtlFile->uri);
                    $model_file_extension = Model3D::FILE_EXTENSION_OBJ;
                } else {
                    $vars['is_mtl'] = true;
                    $vars['mtl_uri'] = asset($genericFile->uri);
                }
                break;

              case Model3D::FILE_EXTENSION_PLY:
                $vars['is_ply'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_PLY;
                break;
        }

        /* if current content field meta data has a scale / rotation value, use that one to show in asset library; otherwise take the value from the models table */
        if (!is_null($content_id) && !is_null($field_key)) {
            try {
                $field = Field::where('content_id', $content_id)->where('key', $field_key)->where('data', $model_id)->firstOrFail();
                $meta_data = json_decode($field->meta_data, true);
                if (!is_null($meta_data) && array_key_exists(Model3D::MODEL_SCALE, $meta_data)) {
                    $scale = $meta_data[Model3D::MODEL_SCALE]; 
                } else {
                    $scale = '1.0 1.0 1.0';
                }
                if (!is_null($meta_data) && array_key_exists(Model3D::MODEL_ROTATION, $meta_data)) {
                    $rotation = $meta_data[Model3D::MODEL_ROTATION]; 
                } else {
                    $rotation = '0 0 0';
                }
            } catch (ModelNotFoundException $e) {
                $model_data = json_decode($model->data, true);
                if (is_null($model_data)) {
                    $scale = '1.0 1.0 1.0';
                    $rotation = '0 0 0';
                } else {
                    $scale = (array_key_exists(Model3D::MODEL_SCALE, $model_data)?$model_data[Model3D::MODEL_SCALE]:'1.0 1.0 1.0');
                    $rotation = (array_key_exists(Model3D::MODEL_ROTATION, $model_data)?$model_data[Model3D::MODEL_ROTATION]:'0 0 0');
                }
            }
        } else {
            $model_data = json_decode($model->data, true);
            if (is_null($model_data)) {
                $scale = '1.0 1.0 1.0';
                $rotation = '0 0 0';
            } else {
                $scale = (array_key_exists(Model3D::MODEL_SCALE, $model_data)?$model_data[Model3D::MODEL_SCALE]:'1.0 1.0 1.0');
                $rotation = (array_key_exists(Model3D::MODEL_ROTATION, $model_data)?$model_data[Model3D::MODEL_ROTATION]:'0 0 0');
            }
        }

        $rotation = explode(' ', $rotation);

        $vars['id'] = $model->id;
        $vars['rotation_x'] = $rotation[0];
        $vars['rotation_y'] = $rotation[1];
        $vars['rotation_z'] = $rotation[2];
        $vars['caption'] = $model->caption;
        $vars['description'] = $model->description;
        $vars['scale'] = $scale;
        $vars['uploaded_on'] = $model->created_at->format('F d, Y');
        $vars['model_file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['model_file_type'] = $genericFile->filemime . (($model_file_extension!='')?' ( *.' . $model_file_extension . ' )':'');

        return view('admin.asset_library.model_edit', $vars);
    }


    /**
     * Model edit save.
     *
     * @param Request $request
     * @param int $model_id
     *
     * @return Response
     */
    public function model_edit_save(Request $request, $model_id) {

        if ($model_id == null) {
            abort(404);
        }

        try {
            $model = Model3D::where('id', $model_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $model->caption = $request->input('caption');
        $model->description = $request->input('description');

        $model->data = json_encode(array(Model3D::MODEL_SCALE => $request->input('scale'), 
            Model3D::MODEL_ROTATION => $request->input('rotation_x') . ' ' . $request->input('rotation_y') . ' ' . $request->input('rotation_z')));

        $model->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * Model edit delete.
     *
     * @param Request $request
     * @param int $model_id
     *
     * @return Response
     */
    public function model_edit_delete(Request $request, $model_id) {

        if ($model_id == null) {
            abort(404);
        }

        try {
            $model = Model3D::where('id', $model_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $model->file_id_0)->firstOrFail();
            $f = pathinfo($genericFile->uri);
            File::delete($genericFile->uri);
            $genericFile->delete();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $model->file_id_1)->firstOrFail();
            File::delete($genericFile->uri);
            $genericFile->delete();
        } catch (ModelNotFoundException $e) {
            /* no problem */
        }

        try {
            $genericFile = GenericFile::where('id', $model->file_id_preview)->firstOrFail();
            File::delete($genericFile->uri);
            $genericFile->delete();
        } catch (ModelNotFoundException $e) {
            /* no problem */
        }

        $textures = Texture::where('model_id', $model->id)->get();
        foreach ($textures as $texture) {
            try {
                $genericFile = GenericFile::where('id', $texture->file_id)->firstOrFail();
                File::delete($genericFile->uri);
                $genericFile->delete();
                $texture->delete();
            } catch (ModelNotFoundException $e) {
                /* no problem */
            }
        }

        $directory = $f['dirname'];
        File::deleteDirectory($directory);

        $model->delete();

        return response()->json(['status' => 'success', 'model_id' => $model_id]);
    }


    /**
     * Model vr view page.
     *
     * @param int $model_id
     *
     * @return Response
     */
    public function model_vr_view($model_id) {

        if ($model_id == null) {
            abort(404);
        }

        try {
            $model = Model3D::where('id', $model_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $genericFile = GenericFile::where('id', $model->file_id_0)->first();

        $vars = [];
        $vars['is_gltf'] = false;
        $vars['is_glb'] = false;
        $vars['is_dae'] = false;
        $vars['is_obj_mtl'] = false;
        $vars['is_obj'] = false;
        $vars['is_mtl'] = false;
        $vars['is_ply'] = false;

        $model_file_extension = '';

        $file = pathinfo($genericFile->filename);

        switch (strtolower($file['extension'])) {
            case Model3D::FILE_EXTENSION_GLB:
                $vars['is_glb'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_GLB;
                break;
            case Model3D::FILE_EXTENSION_GLTF:
                $vars['is_gltf'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_GLTF;
                break;
            case Model3D::FILE_EXTENSION_DAE:
                $vars['is_dae'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_DAE;
                break;
            case Model3D::FILE_EXTENSION_OBJ:
                if (!is_null($model->file_id_1)) {
                    $mtlFile = GenericFile::where('id', $model->file_id_1)->first();
                    $vars['is_obj_mtl'] = true;
                    $vars['obj_uri'] = asset($genericFile->uri);
                    $vars['mtl_uri'] = asset($mtlFile->uri);
                    $model_file_extension = Model3D::FILE_EXTENSION_OBJ;
                } else {
                    $vars['is_obj'] = true;
                    $vars['obj_uri'] = asset($genericFile->uri);
                }
                break;
            case Model3D::FILE_EXTENSION_MTL:
                if (!is_null($model->file_id_1)) {
                    $mtlFile = GenericFile::where('id', $model->file_id_1)->first();
                    $vars['is_obj_mtl'] = true;
                    $vars['mtl_uri'] = asset($genericFile->uri);
                    $vars['obj_uri'] = asset($mtlFile->uri);
                    $model_file_extension = Model3D::FILE_EXTENSION_OBJ;
                } else {
                    $vars['is_mtl'] = true;
                    $vars['mtl_uri'] = asset($genericFile->uri);
                }
                break;

              case Model3D::FILE_EXTENSION_PLY:
                $vars['is_ply'] = true;
                $vars['uri'] = asset($genericFile->uri);
                $model_file_extension = Model3D::FILE_EXTENSION_PLY;
                break;
        }

        $model_data = json_decode($model->data, true);
        if (is_null($model_data)) {
            $scale = '1.0 1.0 1.0';
            $rotation = '0 0 0';
        } else {
            $scale = (array_key_exists(Model3D::MODEL_SCALE, $model_data)?$model_data[Model3D::MODEL_SCALE]:'1.0 1.0 1.0');
            $rotation = (array_key_exists(Model3D::MODEL_ROTATION, $model_data)?$model_data[Model3D::MODEL_ROTATION]:'0 0 0');
        }

        $rotation = explode(' ', $rotation);

        $vars['id'] = $model->id;
        $vars['scale'] = $scale;
        $vars['rotation_x'] = $rotation[0];
        $vars['rotation_y'] = $rotation[1];
        $vars['rotation_z'] = $rotation[2];
        $vars['uploaded_on'] = $model->created_at->format('F d, Y');
        $vars['model_file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['model_file_type'] = $genericFile->filemime . (($model_file_extension!='')?' ( *.' . $model_file_extension . ' )':'');

        return view('admin.asset_library.model_vr_view', $vars);
    }


}
