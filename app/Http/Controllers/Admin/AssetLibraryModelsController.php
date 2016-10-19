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

        $filename_orig = $file->getClientOriginalName();

        /* do not rename texture files, as these are referenced in model files */
        if ($file->getClientOriginalExtension() != Texture::FILE_EXTENSION_PNG && 
            $file->getClientOriginalExtension() != Texture::FILE_EXTENSION_JPG &&
            $file->getClientOriginalExtension() != Texture::FILE_EXTENSION_GIF) {
            do {
                $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
                $existingName = GenericFile::where('filename', $newName)->first();
            } while ($existingName !== null);
        } else {
            $newName = strtolower($filename_orig);
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
                /* get last uploaded file with same file name */
                $genericFile = GenericFile::where('filename_orig', strtolower($f['filename'] . '.mtl'))->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
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
                    //'data' => ''
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
                        //'data' => ''
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
       
        /* check if there is an associated obj file for this mtl file */
        } else if (strtolower($file->getClientOriginalExtension()) == Model3D::FILE_EXTENSION_MTL) {

            $f = pathinfo($filename_orig);
            $genericFile = null;

            try {
                /* get last uploaded file with file name */
                $genericFile = GenericFile::where('filename_orig', strtolower($f['filename'] . '.obj'))->where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
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
                    //'data' => ''
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
                        //'data' => ''
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
            strtolower($file->getClientOriginalExtension()) == Texture::FILE_EXTENSION_GIF) {

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
                //'data' => ''
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
     * Get model embed code.
     *
     * @param int $model_id
     *
     * @return Array
     */
    public function get_embed_code($model_id) {

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

            case Model3D::FILE_EXTENSION_DAE:

                $vars = [
                    'model_dae' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_dae', $vars);        

            case Model3D::FILE_EXTENSION_OBJ:

                if (!is_null($model->file_id_1)) {
                    try {
                        $mtlFile = GenericFile::where('id', $model->file_id_1)->firstOrFail();
                        $vars = [
                            'model_obj' => asset($genericFile->uri),
                            'model_mtl' => asset($mtlFile->uri)
                        ];
                        return view('admin.asset_library.model_obj_mtl', $vars);        

                    } catch (ModelNotFoundException $e) {
                    } 
                }
                $vars = [
                    'model_obj' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_obj_mtl', $vars);        

            case Model3D::FILE_EXTENSION_MTL:

                if (!is_null($model->file_id_1)) {
                    try {
                        $mtlFile = GenericFile::where('id', $model->file_id_1)->firstOrFail();
                        $vars = [
                            'model_mtl' => asset($genericFile->uri),
                            'model_obj' => asset($mtlFile->uri)
                        ];
                        return view('admin.asset_library.model_obj_mtl', $vars);        

                    } catch (ModelNotFoundException $e) {
                    } 
                }
                $vars = [
                    'model_mtl' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_obj_mtl', $vars);        

            case Model3D::FILE_EXTENSION_PLY:

                $vars = [
                    'model_ply' => asset($genericFile->uri)
                ];
                return view('admin.asset_library.model_ply', $vars);        

        }

        abort(404);
    }


    /**
     * Save model as image. 
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

        $filename = str_random(40) . '_preview.png';

        $image = Image::make($unencoded);

        $uri = Model3D::MODEL_STORAGE_PATH . $filename; 

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

        $model = Model3D::where('id', $request->input('model_id'))->first();
        $model->file_id_preview = $genericFile->id;
        $model->save();

        return response()->json([
            'status' => 'success',
            'uri' => asset($uri)
        ]); 
    }


    /**
     * Video edit page.
     *
     * @param int $video_id
     *
     * @return Response
     */
    /*public function video_edit($video_id) {

        if ($video_id == null) {
            abort(404);
        }

        try {
            $video = Video::where('id', $video_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $video->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [];
        $vars['id'] = $video->id;
        $vars['caption'] = $video->caption;
        $vars['description'] = $video->description;
        $vars['dimensions'] = $video->width . ' x ' . $video->height;
        $vars['duration'] = $video->duration;
        $vars['uploaded_on'] = $video->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['video_id'] = $video_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.video_edit', $vars);
    }*/


    /**
     * Video edit save.
     *
     * @param Request $request
     * @param int $video_id
     *
     * @return Response
     */
    /*public function video_edit_save(Request $request, $video_id) {

        if ($video_id == null) {
            abort(404);
        }

        try {
            $video = Video::where('id', $video_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $video->caption = $request->input('caption');
        $video->description = $request->input('description');
        $video->save();

        return response()->json(['status' => 'success']);
    }*/


    /**
     * Video edit delete.
     *
     * @param Request $request
     * @param int $video_id
     *
     * @return Response
     */
    /*public function video_edit_delete(Request $request, $video_id) {

        if ($video_id == null) {
            abort(404);
        }

        try {
            $video = Video::where('id', $video_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $video->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $uri = $genericFile->uri;

        File::delete($uri);

        $video->delete();
        $genericFile->delete();

        return response()->json(['status' => 'success', 'video_id' => $video_id]);
    }*/


    /**
     * Video vr view page.
     *
     * @param int $video_id
     *
     * @return Response
     */
    /*public function video_vr_view($video_id) {

// old code from get_all_models() from Trait?


        if ($video_id == null) {
            abort(404);
        }

        try {
            $video = Video::where('id', $video_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $video->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

  
        $vars = [];
        $vars['id'] = $video->id;
        $vars['dimensions'] = $video->width . ' x ' . $video->height;
        $vars['duration'] = $video->duration;
        $vars['width'] = $width;
        $vars['height'] = $height;
        $vars['width_meter'] = $width_meter;
        $vars['height_meter'] = $height_meter;
        $vars['uploaded_on'] = $video->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['video_id'] = $video_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.video_vr_view', $vars);
    }*/


}
