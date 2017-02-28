@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:35px">{{ trans('template_general_settings.general_settings') }}</h1>

    {!! Form::open(array('route' => 'general_settings', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row" style="padding-left:35px">
        <div class="col-md-9">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row" style="margin-top:20px;padding-left:35px">
        <div class="col-md-2">
            <label for="site-title" class="control-label">{{ trans('template_general_settings.site_title') }}</label>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="site-title" name="site-title" value="{{ $site_title }}" placeholder="{{ trans('template_general_settings.enter_site_title') }}">
        </div> <!-- end col-md //-->
    </div> <!-- end row //-->

    <div class="row" style="margin-top:20px;padding-left:35px">
        <div class="col-md-2">
            <label for="site-title" class="control-label">{{ trans('template_general_settings.language') }}</label>
        </div>
        <div class="col-md-4">
            {!! Form::select('site-localization', $site_localization_options, $site_localization, array('class' => 'form-control')) !!}
        </div> <!-- end col-md //-->
    </div> <!-- end row //-->

    <div class="row" style="margin-top:20px;padding-left:35px">
        <div class="col-md-10 col-md-offset-2">
        <button type="submit" class="btn btn-primary">{{ trans('template_general_settings.save_changes') }}</button>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
