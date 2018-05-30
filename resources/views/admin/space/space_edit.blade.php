@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 id="space-edit-headline" style="padding-left:20px">{{ trans('template_space_add_edit.headline_edit_space') }} <a style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" role="button" href="{{ route('spaces_all') }}">{{ trans('template_space_add_edit.back') }}</a></h1>

    {!! Form::open(array('route' => array('space_edit', $space->id), 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-9" style="padding-left:35px">
            <div class="alert alert-danger">
            {{ trans('template_space_add_edit.field_errors') }} 
            </div>
        </div>
    </div>
    @endif

    @if (session('alert-success'))
    <div class="row">
        <div class="col-md-9" style="padding-left:35px">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    @if (session('alert-error'))
    <div class="row">
        <div class="col-md-9" style="padding-left:35px">
            <div class="alert alert-danger">
            {!! session('alert-error') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <!-- mainbar //-->
        <div class="col-md-9" style="padding-left:35px">
            <div class="form-group {{ $errors->has('space_title')?'has-error':'' }}">
            {!! Form::text('space_title', $space->title, array('class'=>'form-control input-lg', 'placeholder'=> trans('template_space_add_edit.space_title_placeholder'), 'maxlength' => '512')) !!}
            {!! $errors->has('space_title')?$errors->first('space_title', '<span class="help-block">:message</span>'):'' !!}
            </div>
            <div class="form-group {{ $errors->has('space_uri')?'has-error':'' }}">
                <div class="input-group">
                    <div class="input-group-addon">{{ url('/') . '/' }}</div>
                    {!! Form::text('space_uri', $space->uri, array('class'=>'form-control', 'placeholder'=> trans('template_space_add_edit.space_uri_placeholder'), 'maxlength' => '255')) !!}
                </div>
                {!! $errors->has('space_uri')?$errors->first('space_uri', '<span class="help-block">:message</span>'):'' !!}
            </div>

            @if (isset($content))
                @include('admin.space.content.contentlist', ['contentlist' => $content])
            @else
                @include('admin.space.content.contenttypes', ['contenttypes' => $theme['contenttypes']])
            @endif

        </div>

        <!-- sidebar //-->
        <div class="col-md-3">
      
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('template_space_add_edit.publish') }}</h3>
                    <input type="hidden" name="space_id" value="{{ $space->id }}">
                    <input type="hidden" name="theme_id" value="{{ $space->theme_id }}">
                    <input type="hidden" id="contenttype_key" name="contenttype_key" value="">
                </div>
                <div class="panel-body">
                    <div class="clearfix">
                        <a href="{{ url($space->uri . '/preview') }}" target="_blank" role="button" class="btn btn-primary pull-right" id="space-preview"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;&nbsp;{{ trans('template_space_add_edit.preview') }}</a>
                    </div>
                    <div style="margin-top:10px">
                        <div>{{ trans('template_space_add_edit.space_status') }} <strong>{{ ucwords($space->status) }}</strong>&nbsp;&nbsp;<a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">{{ trans('template_space_add_edit.edit') }}</a></div>
                        <div>{{ trans('template_space_add_edit.updated') }} {{ $space->updated_at }}</div>
                    </div>
                    <div class="collapse form-inline" id="space-status" style="margin-top:10px">
                        <div class="form-group">
                            <select name="space_status" class="form-control" style="width:150px">
                                <option value="published" @if ($space->status == App\Space::STATUS_PUBLISHED) selected="selected" @endif>{{ trans('template_space_add_edit.published') }}</option>
                                <option value="draft" @if ($space->status == App\Space::STATUS_DRAFT) selected="selected" @endif>{{ trans('template_space_add_edit.draft') }}</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <button class="btn btn-default" id="space-status-change" type="submit">{{ trans('template_space_add_edit.ok') }}</button>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">{{ trans('template_space_add_edit.cancel') }}</a>
                        </div>
                    </div>
                    <div class="clearfix" style="margin-top:10px;position:relative;">
                        <a href="{{ route('space_trash', ['id' => $space->id]) }}" id="space-move-trash" style="color:#c9302c;position:absolute;bottom:5px;left:0;">{{ trans('template_space_add_edit.move_to_trash') }}</a>
                        <button type="button" class="btn btn-success pull-right" style="margin-top:10px" id="space-save-update"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;&nbsp;{{ trans('template_space_add_edit.update') }}&nbsp;</button>
                    </div>
                </div>
            </div>

            @include('admin.space.theme_partial', ['theme' => $theme])

            @if ($space->status == App\Space::STATUS_PUBLISHED)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('template_space_add_edit.embed_code') }}</h3>
                </div>
                <div class="panel-body">
                <textarea id="space-embed-code" class="form-control" rows="4" aria-describedby="embed-code-help">{{ space_embed_code(url($space->uri), '100%') }}</textarea>
                <span id="embed-code-help" class="help-block">{{ trans('template_space_add_edit.embed_code_help') }}</span>
                </div>
            </div>
            @endif
        </div>
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
