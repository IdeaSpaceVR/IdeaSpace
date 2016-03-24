@extends('layouts.install_app')

@section('title', 'IdeaSpace')

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <h1>IdeaSpace</h1>
        </div>
    </div>

    {!! Form::open(array('route' => 'install', 'method' => 'POST', 'autocomplete' => 'false', 'class' => 'form-horizontal')) !!}

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">

                <div class="panel-body">

                    @if (session('alert-success'))
                    <div class="alert alert-success">
                        {!! session('alert-success') !!}
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        There are errors in the fields below.
                    </div>
                    @endif

                <div class="form-group">
                    <label for="" class="col-sm-2 col-sm-offset-2 control-label"></label>
                    <div class="col-sm-4">
                    <h4>Enter some more information.</h4>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('username')?'has-error':'' }}">
                    <label for="username" class="col-sm-2 col-sm-offset-2 control-label">Username</label>
                    <div class="col-sm-4">
                        {!! Form::text('username', '', array('class'=>'form-control', 'placeholder'=>'Enter a username')) !!}
                        {!! $errors->has('username')?$errors->first('username', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password')?'has-error':'' }}" id="password-container">
                    <label for="password" class="col-sm-2 col-sm-offset-2 control-label">Password</label>
                    <div class="col-sm-4">
                        {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'Enter a password')) !!}
                        <div style="margin-top:10px" class="pwstrength_viewport_progress"></div>
                        {!! $errors->has('password')?$errors->first('password', '<span style="margin-top:-10px" class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email')?'has-error':'' }}">
                    <label for="email" class="col-sm-2 col-sm-offset-2 control-label">Your E-mail</label>
                    <div class="col-sm-4">
                        {!! Form::text('email', '', array('class'=>'form-control', 'placeholder'=>'Enter your e-mail')) !!}
                        {!! $errors->has('email')?$errors->first('email', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 col-sm-offset-2 control-label"></label>
                    <div class="col-sm-4">
                        <button class="btn btn-primary" type="submit">Install IdeaSpace</button>
                    </div>
                </div>

                </div> <!-- end panel-body //-->

            </div><!-- end panel //-->

        </div>

    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
