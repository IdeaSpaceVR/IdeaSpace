<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AssetLibraryControllerTrait;
use Log;

class AssetLibraryController extends Controller {


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
            'js_header' => [
                asset('public/aframe/' . config('app.aframe_lib_for_assets')),
                asset('public/aframe-extras/aframe-extras.loaders.min.js'),
                asset('public/assets/admin/asset-library/js/load-image-aframe-comp.js'),
                asset('public/assets/admin/asset-library/js/load-photosphere-aframe-comp.js'),
                asset('public/assets/admin/asset-library/js/load-video-aframe-comp.js'),
                asset('public/assets/admin/asset-library/js/load-videosphere-aframe-comp.js'),
                asset('public/assets/admin/asset-library/js/scene-floor-grid-aframe-comp.js'),
                asset('public/assets/admin/asset-library/js/reset-camera-aframe-comp.js')
            ],
            'js' => [
								asset('public/aframe-gif-shader/aframe-gif-shader.min.js'),
                asset('public/jquery-file-uploader/dmuploader.js'),
                asset('public/assets/admin/asset-library/js/assets.js'),
                asset('public/assets/admin/asset-library/js/images.js'), 
            ],
            'css' => array(asset('public/assets/admin/asset-library/css/assets.css')),
            'upload_max_filesize' => $this->phpFileUploadSizeSettings(),
            'upload_max_filesize_tooltip' => trans('asset_library_controller.upload_max_filesize_tooltip'),
            'post_max_size' => $this->phpPostMaxSizeSettings(),
            'max_filesize_bytes' => $this->phpFileUploadSizeInBytes(),
            'images' => $this->get_all_images()
        ];

        return view('admin.asset_library.assets', $vars);
    }


}
