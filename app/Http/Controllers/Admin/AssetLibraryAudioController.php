<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use App\GenericFile;
use App\Audio;
use App\Setting;
use Auth;
use File;
use Log;

class AssetLibraryAudioController extends Controller {


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
            'audio_files' => $this->get_all_audiofiles()
        ];

        return view('admin.asset_library.audio', $vars);
    }

    
    /**
     * Audio upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_audio(Request $request) {

        if (!$request->hasFile('file')) {
            abort(404);
        }

        $file = $request->file('file');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'audio')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_audio_controller.wrong_file_type')]);
        }

        do {
            $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
            $existingName = GenericFile::where('filename', $newName)->first();
        } while ($existingName !== null);

        $uri = Audio::AUDIO_STORAGE_PATH . $newName;
        $filename_orig = $file->getClientOriginalName();

        $success = $file->move(Audio::AUDIO_STORAGE_PATH, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_audio_controller.file_moving_error')]);
        }

        
        $getID3 = new \getID3;
        $analyze = $getID3->analyze($uri);
        $audio_duration = $analyze['playtime_string'];
        //$analyze['filesize'];

        $user = Auth::user();

        $newFile = GenericFile::create([
            'user_id' => $user->id,
            'filename' => $newName,
            'uri' => $uri,
            'filemime' => $file->getClientMimeType(),
            'filesize' => $file->getClientSize(),
            'filename_orig' => $filename_orig
        ]);

        $audio = Audio::create([
            'user_id' => $user->id,
            'file_id' => $newFile->id,
            'caption' => '',
            'description' => '',
            'duration' => $audio_duration
            //'data' => ''
        ]);


        return response()->json([
            'status' => 'success',
            'uri' => asset($uri),
            'audio_id' => $audio->id
        ]);
    }


    /**
     * Get localization strings for audio uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_audio_controller.file_type_error'),
            'file_size_error' => trans('asset_library_audio_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_audio_controller.file_ext_error'),
            'edit' => trans('template_asset_library_audio.edit'),
            'insert' => trans('template_asset_library_audio.insert'),
            'save' => trans('template_asset_library_audio.save'),
            'saved' => trans('template_asset_library_audio.saved'),
        ]);
    }


    /**
     * Audio edit page.
     *
     * @param int $audio_id
     *
     * @return Response
     */
    public function audio_edit($audio_id) {

        if ($audio_id == null) {
            abort(404);
        }

        try {
            $audio = Audio::where('id', $audio_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $audio->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $vars = [];
        $vars['id'] = $audio->id;
        $vars['caption'] = $audio->caption;
        $vars['description'] = $audio->description;
        $vars['duration'] = $audio->duration;
        $vars['uploaded_on'] = $audio->created_at->format('F d, Y');
        $vars['file_size'] = number_format(round($genericFile->filesize / 1024), 0, '', '') . 'KB';
        $vars['file_type'] = $genericFile->filemime;
        $vars['audio_id'] = $audio_id;
        $vars['uri'] = asset($genericFile->uri);

        return view('admin.asset_library.audio_edit', $vars);
    }


    /**
     * Audio edit save.
     *
     * @param Request $request
     * @param int $audio_id
     *
     * @return Response
     */
    public function audio_edit_save(Request $request, $audio_id) {

        if ($audio_id == null) {
            abort(404);
        }

        try {
            $audio = Audio::where('id', $audio_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $audio->caption = $request->input('caption');
        $audio->description = $request->input('description');
        $audio->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * Audio edit delete.
     *
     * @param Request $request
     * @param int $audio_id
     *
     * @return Response
     */
    public function audio_edit_delete(Request $request, $audio_id) {

        if ($audio_id == null) {
            abort(404);
        }

        try {
            $audio = Audio::where('id', $audio_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        try {
            $genericFile = GenericFile::where('id', $audio->file_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $uri = $genericFile->uri;

        File::delete($uri);

        $audio->delete();
        $genericFile->delete();

        return response()->json(['status' => 'success', 'audio_id' => $audio_id]);
    }

    
}
