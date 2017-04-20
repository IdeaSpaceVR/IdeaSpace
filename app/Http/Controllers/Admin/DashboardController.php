<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Cache;
use App\Space;

class DashboardController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {

        $vars = [];

        $number_spaces = Space::where('status', '<>', Space::STATUS_TRASH)->count();
        $upload_max_filesize = $this->phpFileUploadSizeSettings();
        $post_max_size = $this->phpPostMaxSizeSettings();
        $memory_usage = (memory_get_peak_usage(true)/1024/1024) . 'MiB';
        $memory_limit = ini_get('memory_limit');

        if (Cache::has('dashboard-news-update-counter')) {

            Cache::increment('dashboard-news-update-counter');
            /* number of requests before news are fetched again */
            if (Cache::get('dashboard-news-update-counter') > 3) {
                /* time to update news */
                $vars = [
                    'js' => array(asset('public/assets/admin/dashboard/js/dashboard-json-news.js'),
                        asset('public/assets/admin/dashboard/js/dashboard.js')),
                    'css' => array(asset('public/assets/admin/dashboard/css/dashboard.css')),
                    'number_spaces' => $number_spaces,
                    'upload_max_filesize' => $upload_max_filesize,
                    'post_max_size' => $post_max_size,
                    'post_max_size' => $post_max_size,
                    'memory_usage' => $memory_usage,
                    'memory_limit' => $memory_limit
                ];
                /* minutes parameter just works with cron setup */
                Cache::put('dashboard-news-update-counter', 0, 2400);
            } else {
                /* fetch cached news */
                $vars = [
                    'js' => array(asset('public/assets/admin/dashboard/js/dashboard.js')),
                    'css' => array(asset('public/assets/admin/dashboard/css/dashboard.css')),
                    'cached_news' => Cache::get('dashboard-news'),
                    'number_spaces' => $number_spaces,
                    'upload_max_filesize' => $upload_max_filesize,
                    'post_max_size' => $post_max_size,
                    'memory_usage' => $memory_usage,
                    'memory_limit' => $memory_limit
                ];      
            }

        } else {

            /* time to update news */
            $vars = [
                'js' => array(asset('public/assets/admin/dashboard/js/dashboard-json-news.js'),
                    asset('public/assets/admin/dashboard/js/dashboard.js')),
                'css' => array(asset('public/assets/admin/dashboard/css/dashboard.css')),
                'number_spaces' => $number_spaces,
                'upload_max_filesize' => $upload_max_filesize,
                'post_max_size' => $post_max_size,
                'memory_usage' => $memory_usage
            ];
            /* minutes parameter just works with cron setup */
            Cache::put('dashboard-news-update-counter', 0, 2400);
        }

        return view('admin.dashboard', $vars);
    }


    /**
     * Retrieve and save news items.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function submit_dashboard_news(Request $request) {

        $news = $request->input('news');

        /* minutes parameter just works with cron setup */
        Cache::put('dashboard-news', $news, 2400); 
  
        return response()->json(['status' => 'success']);        
    }


    /**
     * Helper function for displaying php file upload size settings.
     *
     * @return String if setting exists, empty string otherwise.
     */
    private function phpFileUploadSizeSettings() {

        if (ini_get('upload_max_filesize') !== false && ini_get('upload_max_filesize') != '') {

            $upload_max_filesize = ini_get('upload_max_filesize');
            $upload_max_filesize = str_replace('M', 'MB', $upload_max_filesize);
            $upload_max_filesize = str_replace('G', 'GB', $upload_max_filesize);

            return $upload_max_filesize;
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

            $post_max_size = ini_get('post_max_size');
            $post_max_size = str_replace('M', 'MB', $post_max_size);
            $post_max_size = str_replace('G', 'GB', $post_max_size);

            return $post_max_size;
        }
        return '';
    }


}
