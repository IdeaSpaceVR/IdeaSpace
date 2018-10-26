@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:35px">{{ trans('user_profile.edit_user_profile') }}</h1>

    {!! Form::open(array('route' => ['save_user_profile', $user_id], 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row" style="padding-left:35px">
        <div class="col-md-6">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    @if (session('alert-warning'))
    <div class="row" style="padding-left:35px">
        <div class="col-md-6">
            <div class="alert alert-warning">
            {!! session('alert-warning') !!}
            </div>
        </div>
    </div>
    @endif

		<div class="form-group {{ $errors->has('username')?'has-error':'' }}">
				<div class="row" style="margin-top:20px;padding-left:35px">
						<div class="col-md-2">
								<label for="username" class="control-label" style="margin-top:7px">{{ trans('user_profile.username') }}</label>
						</div>
						<div class="col-md-4">
								{!! Form::text('username', $username, array('class'=>'form-control', 'placeholder'=>trans('user_profile.enter_username'))) !!}	
								{!! $errors->has('username')?$errors->first('username', '<span class="help-block">:message</span>'):'' !!}
						</div> <!-- end col-md //-->
				</div> <!-- end row //-->
		</div>

		<div class="form-group {{ $errors->has('password')?'has-error':'' }}">
				<div class="row" style="margin-top:40px;padding-left:35px">
						<div class="col-md-2">
								<label for="password" class="control-label" style="margin-top:7px">{{ trans('user_profile.new_password') }}</label>
						</div>
						<div class="col-md-4">
								{!! Form::text('password', '', array('class'=>'form-control', 'placeholder'=>trans('user_profile.enter_password'))) !!}
								<div style="margin-top:10px" class="pwstrength_viewport_progress"></div>
								{!! $errors->has('password')?$errors->first('password', '<span style="margin-top:-10px" class="help-block">:message</span>'):'' !!}
						</div> <!-- end col-md //-->
				</div> <!-- end row //-->
		</div>

		<div class="form-group {{ $errors->has('email')?'has-error':'' }}">
				<div class="row" style="margin-top:20px;padding-left:35px">
						<div class="col-md-2">
								<label for="email-address" class="control-label" style="margin-top:7px">{{ trans('user_profile.email_address') }}</label>
						</div>
						<div class="col-md-4">
								{!! Form::text('email', $email_address, array('class'=>'form-control', 'placeholder'=>trans('user_profile.enter_email_address'))) !!}
								{!! $errors->has('email')?$errors->first('email', '<span class="help-block">:message</span>'):'' !!}
						</div> <!-- end col-md //-->
				</div> <!-- end row //-->
		</div>

		<div class="form-group {{ $errors->has('email')?'has-error':'' }}">
    <div class="row" style="margin-top:40px;padding-left:35px">
        <div class="col-md-10 col-md-offset-2">
        <button type="submit" class="btn btn-primary">{{ trans('user_profile.save_changes') }}</button>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
