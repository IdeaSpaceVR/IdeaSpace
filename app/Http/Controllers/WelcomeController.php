<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Schema;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if (env('DB_HOST', '') == '' || 
            env('DB_DATABASE', '') == '' || 
            env('DB_USERNAME', '') == '' || 
            env('DB_PASSWORD', '') == '' || 
            Schema::hasTable('spaces') === false || 
            Schema::hasTable('themes') === false) {
            return redirect('install');
        } else if (!Auth::check()) {
            return view('welcome');
        } else {
            return redirect('admin');
        }
    }
}
