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
                    <h4>Enter the database connection details.</h4>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db_name')?'has-error':'' }}">
                    <label for="db_name" class="col-sm-2 col-sm-offset-2 control-label">Database Name</label>
                    <div class="col-sm-4">
                        {!! Form::text('db_name', '', array('class'=>'form-control', 'placeholder'=>'Enter the name of the database')) !!}
                        {!! $errors->has('db_name')?$errors->first('db_name', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db_user_name')?'has-error':'' }}">
                    <label for="db_user_name" class="col-sm-2 col-sm-offset-2 control-label">User Name</label>
                    <div class="col-sm-4">
                        {!! Form::text('db_user_name', '', array('class'=>'form-control', 'placeholder'=>'Enter your database username')) !!}
                        {!! $errors->has('db_user_name')?$errors->first('db_user_name', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db_user_password')?'has-error':'' }}">
                    <label for="db_user_password" class="col-sm-2 col-sm-offset-2 control-label">Password</label>
                    <div class="col-sm-4">
                        {!! Form::text('db_user_password', '', array('class'=>'form-control', 'placeholder'=>'Enter your database password')) !!}
                        {!! $errors->has('db_user_password')?$errors->first('db_user_password', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db_host')?'has-error':'' }}">
                    <label for="db_host" class="col-sm-2 col-sm-offset-2 control-label">Database Host</label>
                    <div class="col-sm-4">
                        {!! Form::text('db_host', 'localhost', array('class'=>'form-control', 'placeholder'=>'Enter the database host')) !!}
                        {!! $errors->has('db_host')?$errors->first('db_host', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('db_table_prefix')?'has-error':'' }}">
                    <label for="db_name" class="col-sm-2 col-sm-offset-2 control-label">Table Prefix</label>
                    <div class="col-sm-4">
                        {!! Form::text('db_table_prefix', 'isvr_', array('class'=>'form-control', 'placeholder'=>'Enter your preferred table prefix')) !!}
                        {!! $errors->has('db_table_prefix')?$errors->first('db_table_prefix', '<span class="help-block">:message</span>'):'' !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 col-sm-offset-2 control-label"></label>
                    <div class="col-sm-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>

                </div> <!-- end panel-body //-->

            </div><!-- end panel //-->

        </div>

    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
