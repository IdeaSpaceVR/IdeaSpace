<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Http\Requests;
use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Event;
use App\GenericFile;
use Auth;
use File;
use Image;
use Validator;
use App\Space;
use App\FieldControl;
use App\FieldDataImage;
use App\FieldDataText;
use App\Setting;
use Route;
use Log;

class SpaceController extends Controller
{
    private $image_path = 'public/assets/user/media/images/'; 

    private $control_types = [
        Theme::TYPE_IMAGES => [
            'image/gif', 'image/jpeg', 'image/png', 'image/bmp'
        ],
        Theme::TYPE_IMAGE => [
            'image/gif', 'image/jpeg', 'image/png', 'image/bmp'
        ],
        Theme::TYPE_VIDEO => [
            'video/mp4'
        ],
        Theme::TYPE_AUDIO => [
            'audio/mpeg'
        ],
        Theme::TYPE_MODELS => [
            'application/octet-stream'
        ],
        Theme::TYPE_MODEL => [
            'application/octet-stream'
        ],
        Theme::TYPE_TEXTINPUT => [
            'text/html'
        ],
        Theme::TYPE_TEXTAREA => [
            'text/html'
        ]
    ];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('register.theme.eventlistener');
    }

    /**
     * Show the add space and select theme page.
     *
     * @return Response
     */
    public function select_theme()
    {
        $themes = Theme::where('status', Theme::STATUS_ACTIVE)->get();

        $themes_mod = array();

        foreach ($themes as $theme) {
            $config = json_decode($theme->config);
            $theme_mod = array();
            $theme_mod['id'] = $theme->id;
            $theme_mod['title'] = $config->title;
            $theme_mod['description'] = $config->description;
            //$theme_mod['compatibility'] = $config->headset_compatibility;
            $theme_mod['screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);
            $themes_mod[] = $theme_mod; 
        }

        $vars = [
            'themes' => $themes_mod,
            'js' => array(asset('public/assets/admin/space/js/space_add_select_theme.js')),
            'css' => array(asset('public/assets/admin/space/css/space_add_select_theme.css'))
        ];
        
        return view('admin.space.space_add_select_theme', $vars);
    }


    /**
     * Ajax post submitting theme id.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function select_theme_submit(Request $request)
    {
        $all = $request->all();

        if (array_has($all, 'id')) {

          $request->session()->put('theme-id', $all['id']);

          return response()->json(['redirect' => url('admin/space/add')]);

        } else {
            abort(404);
        }
    }


    /**
     * The space add page.
     *
     * @return Response
     */
    public function space_add()
    {
        $theme_id = session('theme-id');        

        try {
            $theme = Theme::where('id', $theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('space_add_select_theme');
        }

        /* if session has vars then take these; for validation errors and keeping form field values */ 
        if (session()->has('vars')) {
            $vars = session()->get('vars');
            session()->forget('vars');
        } else {
            $vars = $this->prepare_config($theme);
        }

        $vars['space_status'] = Space::STATUS_DRAFT;
        $vars['space_mode'] = Space::MODE_ADD;

        return response()->view('admin.space.space', $vars);
    }


    /**
     * The space edit page.
     *
     * @return Response
     */
    public function space_edit($id) {

        try {
            $space = Space::where('id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $theme = Theme::where('id', $space->theme_id)->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            /* case: space exists but theme has been disabled */
            abort(404);
        }

        $vars = $this->prepare_config($theme);

        $theme_mod = $vars['theme'];

        /* populate data for view */
        $field_controls = FieldControl::where('space_id', $space->id)->get();
        foreach ($field_controls as $field_control) {

            $data = [];

            switch ($field_control['type']) {
                case Theme::TYPE_IMAGES:
                    $field_data_images = FieldDataImage::where('field_control_id', $field_control['id'])->orderBy('created_at', 'desc')->get();
                    foreach ($field_data_images as $field_data_image) {
                        $file = GenericFile::where('id', $field_data_image['file_id'])->first();
                        $data[] = [
                            'file_id' => $field_data_image['file_id'],
                            'uri' => url($this->get_file_uri($file->uri, '_preview')),
                            'delete_text' => 'Delete' 
                        ];
                    }
                    break;
                case Theme::TYPE_IMAGE:
                    $field_data_image = FieldDataImage::where('field_control_id', $field_control['id'])->first();
                    $file = GenericFile::where('id', $field_data_image['file_id'])->first();
                    $data[] = [
                        'file_id' => $field_data_image->file_id,
                        'uri' => url($this->get_file_uri($file->uri, '_preview')),
                        'delete_text' => 'Delete'
                    ]; 
                    break;
                case Theme::TYPE_TEXTINPUT:
                case Theme::TYPE_TEXTAREA:
                    $field_data_text = FieldDataText::where('field_control_id', $field_control['id'])->first();
                    $data[] = [
                        'text' => $field_data_text->text
                    ];
                    break;
                case Theme::TYPE_MODEL:

                    break;
                case Theme::TYPE_MODELS:

                    break;
                case Theme::TYPE_AUDIO:

                    break;
                case Theme::TYPE_VIDEO:

                    break;
            }
            $theme_mod['controls'][$field_control['key']]['data'] = $data;
        }

        $vars['space_status'] = $space->status;
        $vars['space_updated_time'] = $space->updated_at;
        $vars['space_mode'] = Space::MODE_EDIT;
        $vars['space_id'] = $space->id;
        $vars['space_title'] = $space->title;
        $vars['space_uri'] = $space->uri;

        $vars['theme'] = $theme_mod;

        //Log::debug($vars['theme']);

        /* needed for middleware: app/Http/Middleware/RegisterThemeEventListener.php */
        session(['theme-id' => $theme->id]);

        return view('admin.space.space', $vars);
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

        $field_controls = FieldControl::where('space_id', $space->id)->get(); 
        foreach ($field_controls as $field_control) {
            switch ($field_control->type) {
                case Theme::TYPE_IMAGES:
                case Theme::TYPE_IMAGE:
                    $field_data_images = FieldDataImage::where('space_id', $space->id)->get();
                    foreach ($field_data_images as $field_data_image) {
                        $generic_file = GenericFile::where('id', $field_data_image->file_id)->first();
                        if (File::exists($generic_file->uri)) {
                            File::delete($generic_file->uri);
                        }
                        $image_preview_uri = $this->get_file_uri($generic_file->uri, '_preview');
                        if (File::exists($image_preview_uri)) {
                            File::delete($image_preview_uri);
                        }
                        $thumbnail_uri = $this->get_file_uri($generic_file->uri, '_thumb');
                        if (File::exists($thumbnail_uri)) {
                            File::delete($thumbnail_uri);
                        }
                        $generic_file->delete();
                        $field_data_image->delete();
                    }
                    break;
                case Theme::TYPE_VIDEO:
  
                    break;
                case Theme::TYPE_AUDIO:
  
                    break;
                case Theme::TYPE_MODEL:
  
                    break;
                case Theme::TYPE_MODELS:
  
                    break;
                case Theme::TYPE_TEXTINPUT:
                case Theme::TYPE_TEXTAREA:
                    $field_data_text = FieldDataText::where('space_id', $space->id)->first(); 
                    $field_data_text->delete();
                    break;
            }      
            $field_control->delete();
        }        
        $space->delete();

        return redirect()->route('spaces_all')->with('alert-success', 'Space has been deleted.'); 
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

        return redirect()->route('spaces_all')->with('alert-success', 'Space moved to trash. <a href="' . route('space_restore', ['id' => $space->id]) . '">Undo</a>.'); 
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

        return redirect()->route('spaces_all')->with('alert-success', 'Space has been restored.'); 
    }


    /**
     * Delete an image via jQuery.
     *
     * @return Response
     */
    public function space_media_images_delete(Request $request)
    {
        if ($request->has('image_id') && $request->has('ref_id')) {

            $image_id = $request->input('image_id');
            $image_id = substr(strrchr($image_id, '-'), 1);

            $ref_id = $request->input('ref_id');
            $ref_id = substr(strrchr($ref_id, '-'), 1);

            $user = Auth::user();

            try {
                $genericFile = GenericFile::where('id', $ref_id)->where('user_id', $user->id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return redirect()->route('space_add');
            } 

            try {
                $field_data_image = FieldDataImage::where('file_id', $ref_id)->firstOrFail();
                $field_data_image->delete();
                $field_control = FieldControl::where('id', $field_data_image->field_control_id)->firstOrFail();
                if ($field_control->type == Theme::TYPE_IMAGES) {
                    /* of type images but no images in field data images table anymore, field control entry can be deleted as well */
                    try {
                        FieldDataImage::where('space_id', $field_data_image->space_id)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        $field_control->delete();
                    } 
                }
            } catch (ModelNotFoundException $e) {

            } 

            if (File::exists($genericFile->uri)) {

                File::delete($genericFile->uri);

                /* delete preview images */
                //$thumbnail_uri = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . '_preview' . substr($genericFile->uri, strrpos($genericFile->uri, '.'));
                $image_preview_uri = $this->get_file_uri($genericFile->uri, '_preview');
                if (File::exists($image_preview_uri)) {
                    File::delete($image_preview_uri);
                }

                /* delete thumbnails */
                //$thumbnail_uri = substr($genericFile->uri, 0, strrpos($genericFile->uri, '.')) . '_thumb' . substr($genericFile->uri, strrpos($genericFile->uri, '.'));
                $thumbnail_uri = $this->get_file_uri($genericFile->uri, '_thumb');
                if (File::exists($thumbnail_uri)) {
                    File::delete($thumbnail_uri);
                }

                $genericFile->delete();

                return response()->json(['status' => 'success', 'message' => 'Image file deleted.', 'image_id' => $image_id]);

            } else {
                return response()->json(['status' => 'error', 'message' => 'There was an error when deleting the image.', 'image_id' => $image_id]);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'There was an error when deleting the image.', 'image_id' => $image_id]);
        }
    }


    /**
     * Images upload via jQuery.
     *
     * @return Response
     */
    public function space_media_images_add(Request $request)
    {
        if ($request->hasFile('file') && $request->has('type')) {
            
            $file = $request->file('file');
            $type = $request->input('type');

            /* verify control type and file mime type */
            if ($this->validControlType($file, $type)) {

                do {
                    $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
                    $existingName = GenericFile::where('filename', $newName)->first();
                } while ($existingName !== null);

                $uri = $this->image_path . $newName;

                $filename_orig = $file->getClientOriginalName();

                $success = $file->move($this->image_path, $newName);
 
                if (!$success) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong while moving the file. Please check your directory configuration.']);
                }  

                /* image width and height must be power of two; resize image */
                $this->create_image_nearest_power_of_two($uri, $uri);

                /* fire event */
                $image_settings = Event::fire('media.image.manipulation', $uri);

                /* create image from settings */
                if (!empty($image_settings)) {
                    $this->create_image($uri, $uri, $image_settings[0]);
                }

                /* fire event */
                Event::fire('media.image.save_pre', $uri);

                $user = Auth::user();

                $newFile = GenericFile::create([
                    'user_id' => $user->id,
                    'filename' => $newName,
                    'uri' => $uri,
                    'filemime' => $file->getClientMimeType(),
                    'filesize' => $file->getClientSize(),
                    'filename_orig' => $filename_orig,
                    'status' => GenericFile::STATUS_PUBLISHED
                ]);

                /* fire event */
                Event::fire('media.image.save', $uri);

                /* create preview image */
                //$newName = substr($newName, 0, strrpos($newName, '.')) . '_preview' . substr($newName, strrpos($newName, '.'));
                $newNamePreview = $this->get_file_uri($newName, '_preview');
                $preview_image_uri = $this->image_path . $newNamePreview;

                /* thumbnail images are shown in the web interface, no need to convert size according to power of two principle */
                $this->create_image($uri, $preview_image_uri, array('width' => '400'));


                /* fire event */
                $thumbnail_settings = Event::fire('media.image.thumbnail.manipulation', $uri);

                if (!empty($thumbnail_settings)) {

                    //$newName = substr($newName, 0, strrpos($newName, '.')) . '_thumb' . substr($newName, strrpos($newName, '.'));
                    $newName = $this->get_file_uri($newName, '_thumb');
                    $thumbnail_uri = $this->image_path . $newName;

                    /* create image from settings */
                    $this->create_image($uri, $thumbnail_uri, $thumbnail_settings[0]);

                    /* we don't save thumbnail images into the DB */
                }

                return response()->json(['status' => 'success', 'message' => 'Upload successful.', 'uri' => asset($preview_image_uri), 'delete_text' => 'Delete', 'ref_id' => $newFile->id]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Wrong file type. Image file type is required. Please try again.']);
            } /* end: is valid control type */

        }

    }


    /**
     * Mime type and control type validation.
     *
     * @param File $file The file.
     * @param string $type The control type.
     *
     * @return True if valid, false otherwise. 
     */
    private function validControlType($file, $type) {
        //Log::debug($file->getMimeType());
        $mime_types = $this->control_types[$type];
        foreach ($mime_types as $mime_type) {
            if ($mime_type === $file->getMimeType()) {
                return true;
            }
        }
        return false;
    }


    /**
     * Helper function for displaying php file upload size settings. 
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpFileUploadSizeSettings() {

        if (ini_get('upload_max_filesize') !== false && ini_get('upload_max_filesize') != '') {
            return '<br>(Max. Upload File Size: ' . str_replace('M', 'MB', ini_get('upload_max_filesize')) . ') <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" rel="tooltip" title="You can configure this setting in your php configuraton file (php.ini). Ask your web administrator for help."></span>';
        } 
        return '';
    }

    
    /**
     * Helper function for displaying php post max size settings.
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpPostMaxSizeSettings() {
       
        if (ini_get('post_max_size') !== false && ini_get('post_max_size') != '') {
            return '<br>(Max. Post Size: ' . str_replace('M', 'MB', ini_get('post_max_size')) . ') <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" rel="tooltip" title="You can configure this setting in your php configuration file (php.ini). Ask your web administrator for help."></span>';
        } 
        return '';
    }


    /**
     * Helper function for getting maximum file upload size in bytes.
     *
     * @return Bytes string if setting exists.
     */ 
    private function phpFileUploadSizeInBytes() {

      if (ini_get('upload_max_filesize') !== false) {

        $filesize = ini_get('upload_max_filesize');

        if (substr($filesize, -1) == 'M') {

          return substr($filesize, 0, -1) * 1024 * 1024;

        } else if (substr($filesize, -1) == 'G') {

          return substr($filesize, 0, -1) * 1024 * 1024 * 1024;
        }
      }
      return 0;
    }
 
    /**
     * Apply image settings.
     *
     * @param String $file_uri_orig
     * @param String $file_uri_new
     * @param Array $image_settings
     * @return void 
     */
    private function create_image($file_uri_orig, $file_uri_new, $image_settings) {

        /* image quality */
        $quality = 90;
        if (array_has($image_settings, 'quality')) {
            $quality = $image_settings['quality'];
        } 

        if (array_has($image_settings, 'width') && array_has($image_settings, 'height')) {

            $file = Image::make($file_uri_orig)->resize($image_settings['width'], $image_settings['height']);
            $file->save($file_uri_new, $quality);

        } else if (array_has($image_settings, 'width')) {

            $file = Image::make($file_uri_orig)->resize($image_settings['width'], null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save($file_uri_new, $quality);

        } else if (array_has($image_settings, 'height')) {

            $file = Image::make($file_uri_orig)->resize(null, $image_settings['height'], function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save($file_uri_new, $quality);

        } else if (array_has($image_settings, 'quality')) {

            $file = Image::make($file_uri_orig);
            $file->save($file_uri_new, $quality);
        }
    }


    /**
     * Resize image with size according to nearest power of two.
     *
     * @param String $file_uri_orig
     * @param String $file_uri_new
     * @return void 
     */
    private function create_image_nearest_power_of_two($file_uri_orig, $file_uri_new) {

        $image = Image::make($file_uri_orig);

        if (is_power_of_two($image->width())) {
            $width = $image->width();
        } else {
            $width = nearest_power_of_two($image->width());
        }

        $setting = Setting::where('key', 'MAX_IMAGE_WIDTH')->first();
        $width = (($width<=$setting->value)?$width:$setting->value);

        $image_settings = [
            'width' => $width
        ];

        $this->create_image($file_uri_orig, $file_uri_new, $image_settings);
    }


    /**
     * Add space submission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function space_add_submit(Request $request)
    {
        $validation_rules = [
            'space_title' => 'required|max:512',
            'space_uri' => 'required|max:255',
        ];

        $validation_messages = [
            'space_title.required' => 'The title field is required.',
            'space_title.max' => 'The title field may not be larger than :max characters.',
            'space_uri.required' => 'The path field is required.',
            'space_uri.max' => 'The path field may not be larger than :max characters.',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            $vars = $this->prepare_field_data($request);
            return redirect('admin/space/add')->withErrors($validator)->withInput()->with('vars', $vars);
        }

        /* generate url-friendly slug */
        $space_uri = str_slug($request->input('space_uri'));

        /* check if uri exists already */
        try {
            $existing_space = Space::where('uri', $space_uri)->firstOrFail();
            if ($existing_space != null) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', 'This path already exists.');
                });              
                if ($validator->fails()) {
                    $vars = $this->prepare_field_data($request);
                    return redirect('admin/space/add')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        } catch (ModelNotFoundException $e) {
        }

        /* check if uri exists as system uri already */
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if ($route->getPath() == $space_uri) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', 'This path already exists.');
                });
                if ($validator->fails()) {
                    $vars = $this->prepare_field_data($request);
                    return redirect('admin/space/add')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        }       


        $user = Auth::user();
        $theme_id = $request->input('theme_id');
        $theme = Theme::where('id', $theme_id)->first();
        /* convert to an array */
        $config = json_decode($theme->config, true);
        if (!isset($config['configuration']['controls'])) {
            abort(404);
        }
        $controls = $config['configuration']['controls'];

        $space = [
            'user_id' => $user->id,
            'theme_id' => $theme_id,
            'uri' => $space_uri, 
            'title' => $request->input('space_title'), 
            'status' => $request->input('space_status')
        ];
  
        /* fire event */
        Event::fire('space.save_pre', $space);

        $space = Space::create($space);

        foreach ($controls as $key => $control) {

            if ($request->has($control['type'] . '--' . $key)) {

                $request_val = $request->input($control['type'] . '--' . $key);

                switch ($control['type']) {
                    case Theme::TYPE_IMAGES:
                        $field_control = FieldControl::create([
                            'space_id' => $space->id,
                            'key' => $key,
                            'type' => $control['type']
                        ]);
                        /* iterate over image file ids */
                        foreach ($request_val as $val) {
                            FieldDataImage::create([
                                'space_id' => $space->id,
                                'field_control_id' => $field_control->id,
                                'file_id' => $val,
                                'weight' => 0
                            ]);
                        }
                        break;
                    case Theme::TYPE_IMAGE:
                        $field_control = FieldControl::create([
                            'space_id' => $space->id,
                            'key' => $key,
                            'type' => $control['type']
                        ]);
                        FieldDataImage::create([
                            'space_id' => $space->id,
                            'field_control_id' => $field_control->id,
                            'file_id' => $request_val,
                            'weight' => 0
                        ]);
                      break;
                    case Theme::TYPE_VIDEO:
  
                      break;
                    case Theme::TYPE_AUDIO:
  
                      break;
                    case Theme::TYPE_MODEL:
  
                      break;
                    case Theme::TYPE_MODELS:
  
                      break;
                    case Theme::TYPE_TEXTINPUT:
                    case Theme::TYPE_TEXTAREA:
                        $field_control = FieldControl::create([
                            'space_id' => $space->id,
                            'key' => $key,
                            'type' => $control['type']
                        ]);
                        FieldDataText::create([
                            'space_id' => $space->id,
                            'field_control_id' => $field_control->id,
                            'text' => $request_val
                        ]);
                      break;
                }      


            } /* end: if */

        } /* end: foreach */

        /* fire event */
        Event::fire('space.save', $space);

        /* space_uri should we shown in an url-friendly way */
        return redirect('admin/space/' . $space->id . '/edit')->withInput($request->except('space_uri'))->with('space_uri', $space_uri)->with('alert-success', 'Space saved.');
    }


    /**
     * Edit space submission.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function space_edit_submit(Request $request)
    {
        if (!$request->has('space_id') && !$request->has('space_uri') && !$request->has('space_title') && !$request->has('space_status')) {
            abort(404);
        }

        $validation_rules = [
            'space_title' => 'required|max:512',
            'space_uri' => 'required|max:255',
        ];

        $validation_messages = [
            'space_title.required' => 'The title field is required.',
            'space_title.max' => 'The title field may not be larger than :max characters.',
            'space_uri.required' => 'The path field is required.',
            'space_uri.max' => 'The path field may not be larger than :max characters.',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return redirect('admin/space/' . $request->input('space_id') . '/edit')->withErrors($validator)->withInput();
        }


        $space_id = $request->input('space_id');

        /* generate url-friendly slug */
        $space_uri = str_slug($request->input('space_uri'));

        /* check if uri exists already, except own url */
        try {
            $existing_space = Space::where('uri', $space_uri)->firstOrFail();
            if ($existing_space != null && $existing_space->id != $space_id) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', 'This path already exists.');
                });
                if ($validator->fails()) {
                    $vars = $this->prepare_field_data($request);
                    return redirect('admin/space/' . $space_id . '/edit')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        } catch (ModelNotFoundException $e) {
        }

        /* check if uri exists as system uri already */
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if ($route->getPath() == $space_uri) {
                $validator->after(function($validator) {
                    $validator->errors()->add('space_uri', 'This path already exists.');
                });
                if ($validator->fails()) {
                    $vars = $this->prepare_field_data($request);
                    return redirect('admin/space/' . $space_id . '/edit')->withErrors($validator)->withInput()->with('vars', $vars);
                }
            }
        }       


        try {

            $space = Space::where('id', $space_id)->firstOrFail();
            $space->title = $request->input('space_title');
            $space->uri = $space_uri;
            $space->status = $request->input('space_status');
            $space->save();

        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $theme_id = $request->input('theme_id');
        $theme = Theme::where('id', $theme_id)->first();
        /* convert to an array */
        $config = json_decode($theme->config, true);
        if (!isset($config['configuration']['controls'])) {
            abort(404);
        }
        $controls = $config['configuration']['controls'];

        foreach ($controls as $key => $control) {

            /* return true if present or an empty string if not */
            if ($request->has($control['type'] . '--' . $key)) {

                $request_val = $request->input($control['type'] . '--' . $key);

                switch ($control['type']) {
                    case Theme::TYPE_IMAGES:
                        /* iterate over image file ids */
                        foreach ($request_val as $val) {
                            try {
                                FieldDataImage::where('space_id', $space_id)->where('file_id', $val)->firstOrFail();
                            } catch (ModelNotFoundException $e) {
                                try {
                                    $field_control = FieldControl::where('space_id', $space_id)->where('type', $control['type'])->where('key', $key)->firstOrFail();
                                } catch (ModelNotFoundException $e) {
                                    /* does not exist, create it */
                                    $field_control = FieldControl::create([
                                        'space_id' => $space->id,
                                        'key' => $key,
                                        'type' => $control['type']
                                    ]);
                                }
                                /* does not exist, create it */
                                FieldDataImage::create([
                                    'space_id' => $space_id,
                                    'field_control_id' => $field_control->id,
                                    'file_id' => $val
                                ]); 
                            } 
                        }
                        break;
                    case Theme::TYPE_IMAGE:
                        try {
                            FieldDataImage::where('space_id', $space_id)->where('file_id', $val)->firstOrFail();
                        } catch (ModelNotFoundException $e) {
                            try {
                                $field_control = FieldControl::where('space_id', $space_id)->where('type', $control['type'])->where('key', $key)->firstOrFail();
                            } catch (ModelNotFoundException $e) {
                                /* does not exist, create it */
                                $field_control = FieldControl::create([
                                    'space_id' => $space->id,
                                    'key' => $key,
                                    'type' => $control['type']
                                ]);
                            }
                            /* does not exist, create it */
                            FieldDataImage::create([
                                'space_id' => $space_id,
                                'field_control_id' => $field_control->id,
                                'file_id' => $request_val
                            ]); 
                        } 
                        break;
                    case Theme::TYPE_VIDEO:
  
                        break;
                    case Theme::TYPE_AUDIO:
  
                        break;
                    case Theme::TYPE_MODEL:
  
                        break;
                    case Theme::TYPE_MODELS:
  
                        break;
                    case Theme::TYPE_TEXTINPUT:
                    case Theme::TYPE_TEXTAREA:
                        try {
                            $field_control = FieldControl::where('space_id', $space_id)->where('type', $control['type'])->where('key', $key)->firstOrFail();
                        } catch (ModelNotFoundException $e) {
                            /* does not exist, create it */
                            $field_control = FieldControl::create([
                                'space_id' => $space->id,
                                'key' => $key,
                                'type' => $control['type']
                            ]);
                        }

                        try {
                            $field_data_text = FieldDataText::where('space_id', $space_id)->where('field_control_id', $field_control->id)->firstOrFail();
                        } catch (ModelNotFoundException $e) {
                            /* does not exist, create it */
                            FieldDataText::create([
                                'space_id' => $space_id,
                                'field_control_id' => $field_control->id,
                                'text' => $request_val
                            ]); 
                        } 
                        $field_data_text->text = $request_val;
                        $field_data_text->save();
                        break;
                }      


            } /* end: if */

        } /* end: foreach */

        return redirect('admin/space/' . $space->id . '/edit')->withInput()->with('alert-success', 'Space saved.');
    }


    /**
     * Prepare dynamically generated field data during space add process, 
     * in case of validation errors.
     *
     * @param Request $request
     *
     * @return $vars Array
     */
    private function prepare_field_data($request) {
      
        if (!$request->has('theme_id')) { 
            abort(404);
        }

        try {
            $theme = Theme::where('id', $request->input('theme_id'))->where('status', Theme::STATUS_ACTIVE)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = $this->prepare_config($theme);

        $theme_mod = $vars['theme'];
  
        foreach ($theme_mod['controls'] as $key => $control) {

            $data = [];

            switch ($control['type']) {

                case Theme::TYPE_IMAGES:
                    /* eg. images--images_upload */
                    if (array_has($request->all(), Theme::TYPE_IMAGES . '--' . $key)) {
                        foreach ($request->input(Theme::TYPE_IMAGES . '--' . $key) as $input) {
                            $file = GenericFile::where('id', $input)->first();
                            $data[] = [
                                'file_id' => $input,
                                'uri' => url($this->get_file_uri($file['uri'], '_preview')),
                                'delete_text' => 'Delete' 
                            ];
                        }
                    }
                    break;
                case Theme::TYPE_IMAGE:
                    /* eg. image--my_image_upload */
                    if (array_has($request->all(), Theme::TYPE_IMAGE . '--' . $key)) {
                        foreach ($request->input(Theme::TYPE_IMAGE . '--' . $key) as $input) {
                            $file = GenericFile::where('id', $input)->first();
                            $data[] = [
                                'file_id' => $input,
                                'uri' => url($this->get_file_uri($file['uri'], '_preview')),
                                'delete_text' => 'Delete' 
                            ];
                        }
                    }
                    break;
                case Theme::TYPE_VIDEO:

                    break;
                case Theme::TYPE_AUDIO:

                    break;
                case Theme::TYPE_MODEL:

                    break;
                case Theme::TYPE_MODELS:

                    break;
                case Theme::TYPE_TEXTINPUT:
                    /* eg. textinput--my_text_input_field */
                    if (array_has($request->all(), Theme::TYPE_TEXTINPUT . '--' . $key)) {
                        $data[] = [
                            'text' => $request->input(Theme::TYPE_TEXTINPUT . '--' . $key)
                        ];
                    }
                    break;
                case Theme::TYPE_TEXTAREA:
                    /* eg. textarea--my_textarea */
                    if (array_has($request->all(), Theme::TYPE_TEXTAREA . '--' . $key)) {
                        $data[] = [
                            'text' => $request->input(Theme::TYPE_TEXTAREA . '--' . $key)
                        ];
                    }
                    break;
            }      
            $theme_mod['controls'][$key]['data'] = $data;
        }

        $vars['theme'] = $theme_mod;
        
        return $vars;
    }


    /**
     * Prepare space view.
     *
     * @param Theme $theme The theme which is currently in use.
     *
     * @return $vars The vars array for the view.
     */
    private function prepare_config($theme) {

        $theme_mod = array();

        /* convert to an array */
        $config = json_decode($theme->config, true);
        $theme_mod = array();
        $theme_mod['id'] = $theme->id;
        $theme_mod['title'] = $config['title'];
        $theme_mod['screenshot'] = url($theme->root_dir . '/' . Theme::SCREENSHOT_FILE);

        /* panels and controls for this theme */
        if (isset($config['configuration']) && isset($config['configuration']['controls'])) {

            if (isset($config['configuration']['panels'])) {
                $theme_mod['panels'] = $config['configuration']['panels']; 
            } else {
                $theme_mod['panels'] = array();
            }
            $theme_mod['controls'] = $config['configuration']['controls']; 

        } else {

            $theme_mod['controls'] = array();
            $theme_mod['panels'] = array();
        }


        //Log::debug(serialize($theme_mod));
        $media_js = array();
        $media_css = array();
        $types = array();

        foreach ($theme_mod['controls'] as $key => $control) {
            switch ($control['type']) {
                case Theme::TYPE_IMAGES:

                    $media_js[] = asset('public/jquery-file-uploader/dmuploader.js');
                    $media_js[] = asset('public/assets/admin/space/js/space_images_upload.js');
                    $media_css[] = asset('public/assets/admin/space/css/space_images_upload.css');
                    $types[$key] = Theme::TYPE_IMAGES;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_IMAGES . '--' . $key;
                    break;  
                case Theme::TYPE_IMAGE:

                    $types[$key] = Theme::TYPE_IMAGE;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_IMAGE . '--' . $key;
                    break;
                case Theme::TYPE_TEXTINPUT:

                    $types[$key] = Theme::TYPE_TEXTINPUT;
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_TEXTINPUT . '--' . $key;
                    break;
                case Theme::TYPE_TEXTAREA:

                    $types[$key] = Theme::TYPE_TEXTAREA;
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_TEXTAREA . '--' . $key;
                    break;
                case Theme::TYPE_MODEL:

                    $types[$key] = Theme::TYPE_MODEL;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_MODEL . '--' . $key;
                    break;
                case Theme::TYPE_MODELS:

                    $types[$key] = Theme::TYPE_MODELS;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_MODELS . '--' . $key;
                    break;
                case Theme::TYPE_AUDIO:
                    $types[$key] = Theme::TYPE_AUDIO;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_AUDIO . '--' . $key;
                    break;
                case Theme::TYPE_VIDEO:
                    $types[$key] = Theme::TYPE_VIDEO;
                    $theme_mod['controls'][$key]['upload_max_filesize'] = $this->phpFileUploadSizeSettings();
                    $theme_mod['controls'][$key]['post_max_size'] = $this->phpPostMaxSizeSettings();
                    $theme_mod['controls'][$key]['max_file_size_bytes'] = $this->phpFileUploadSizeInBytes();
                    $theme_mod['controls'][$key]['control_id'] = Theme::TYPE_VIDEO . '--' . $key;
                    break;
            }
        }

        /* store types in session in order to validate type on json media upload submission */
        //session(['types' => $types]);

        $js = [
            // add additional js files
            asset('public/assets/admin/space/js/space.js')
        ];

        $css = [
            // add additional css files
            asset('public/assets/admin/space/css/space.css')
        ];

        $js = array_merge($js, $media_js);
        $css = array_merge($css, $media_css);

        $vars = [
            'space_theme_id' => $theme->id,
            'theme' => $theme_mod,
            'js' => $js, 
            'css' => $css 
        ];
      
        return $vars;
    }


    /**
     * Get file URI with suffix. Preserves the file extension.
     * 
     * @param String $uri The file URI.
     * @param String $suffix The suffix to append to file URI.
     *
     * @return New file URI with suffix and file extension.
     */
    private function get_file_uri($uri, $suffix) {
        return substr($uri, 0, strrpos($uri, '.')) . $suffix . substr($uri, strrpos($uri, '.'));        
    }




}
