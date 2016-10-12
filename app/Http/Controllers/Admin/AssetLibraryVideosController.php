<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use App\GenericFile;
use App\Video;
use App\Setting;
use Auth;
use File;
use Log;

class AssetLibraryVideosController extends Controller {


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
            'videos' => $this->get_all_videos()
        ];

        return view('admin.asset_library.videos', $vars);
    }


    /**
     * Videos upload via jQuery.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add_videos(Request $request) {

        if (!$request->hasFile('file')) {
            abort(404);
        }

        $file = $request->file('file');

        /* verify mime type */
        if (!$this->validateMimeType($file, 'video')) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_videos_controller.wrong_file_type')]);
        }

        do {
            $newName = str_random(60) . '.' . strtolower($file->getClientOriginalExtension());
            $existingName = GenericFile::where('filename', $newName)->first();
        } while ($existingName !== null);

        $uri = Video::VIDEO_STORAGE_PATH . $newName;
        $filename_orig = $file->getClientOriginalName();

        $success = $file->move(Video::VIDEO_STORAGE_PATH, $newName);
        if (!$success) {
            return response()->json(['status' => 'error', 'message' => trans('asset_library_videos_controller.file_moving_error')]);
        }


        $getID3 = new \getID3;
        $analyze = $getID3->analyze($uri);
        $video_duration = $analyze['playtime_string'];
        $video_width = $analyze['video']['resolution_x'];
        $video_height = $analyze['video']['resolution_y'];
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

        $video = Video::create([
            'user_id' => $user->id,
            'file_id' => $newFile->id,
            'caption' => '',
            'description' => '',
            'duration' => $video_duration,
            'width' => $video_width,
            'height' => $video_height
            //'data' => ''
        ]);


        return response()->json([
            'status' => 'success',
            'uri' => asset($uri),
            'video_id' => $video->id
        ]);
    }


    /**
     * Get localization strings for video uploading ajax script.
     *
     * @return Array
     */
    public function get_localization_strings() {

        return response()->json([
            'file_type_error' => trans('asset_library_videos_controller.file_type_error'),
            'file_size_error' => trans('asset_library_videos_controller.file_size_error'),
            'file_ext_error' => trans('asset_library_videos_controller.file_ext_error'),
            'vr_view' => trans('template_asset_library_videos.vr_view'),
            'edit' => trans('template_asset_library_videos.edit'),
            'insert' => trans('template_asset_library_videos.insert'),
            'save' => trans('template_asset_library_videos.save'),
            'saved' => trans('template_asset_library_videos.saved'),
        ]);
    }


    /**
     * Video edit page.
     *
     * @param int $video_id
     *
     * @return Response
     */
    public function video_edit($video_id) {

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
    }


    /**
     * Video edit save.
     *
     * @param Request $request
     * @param int $video_id
     *
     * @return Response
     */
    public function video_edit_save(Request $request, $video_id) {

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
    }


    /**
     * Video edit delete.
     *
     * @param Request $request
     * @param int $video_id
     *
     * @return Response
     */
    public function video_edit_delete(Request $request, $video_id) {

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
    }


    /**
     * Video vr view page.
     *
     * @param int $video_id
     *
     * @return Response
     */
    public function video_vr_view($video_id) {

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


        /* calculate aspect ratio for a-frame */
        $width = $video->width;
        $height = $video->height;
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
    }


}


