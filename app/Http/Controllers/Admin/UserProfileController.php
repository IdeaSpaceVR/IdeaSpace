<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;

class UserProfileController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('auth');
    }


    /**
     * Show the edit user profile page.
     *
     * @return Response
     */
    public function edit($user_id) {

				$user = Auth::user();

				if ($user->id != $user_id) {
						abort(404);
				} 

        $vars = [
						'js' => [
								asset('public/assets/admin/user_profile/js/user_profile.js'),
            		asset('public/jquery-pwstrength/pwstrength.js')
						],
						'user_id' => $user->id,
						'username' => $user->name,
						'email_address' => $user->email,
				];

        return view('admin.user_profile', $vars);
    }


    /**
     * Save changes to user profile.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function save(Request $request) {

				$user = Auth::user();

				$validation_rules = [
            'username' => 'required',
            'email' => 'required'
        ];

        $validation_messages = [
            'username.required' => trans('user_profile.username_required'), 
            'email.required' => trans('user_profile.email_required') 
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return redirect()->route('edit_user_profile')->withErrors($validator)->withInput();
        }

        $username = trim($request->input('username'));
				if ($username != $user->name) {
						$user->name = $username;
				}

				$password = trim($request->input('password'));
				if ($password != '') {
        		$user->password = Hash::make($password);
				}

        $email = trim($request->input('email'));
				if ($email != $user->email) {
						/* send validation e-mail? what if the platform does not support sending e-mails? */
						$user->email = $email;
				}

				$user->save();

				return redirect()->route('edit_user_profile', ['user_id' => $user->id])->with('alert-success', trans('user_profile.save_success_message'));  
    }


}
