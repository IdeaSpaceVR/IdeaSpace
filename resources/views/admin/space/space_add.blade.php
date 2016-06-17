@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    <h1 style="padding-left:20px">{{ trans('template_space_add.headline') }}</h1>

    {!! Form::open(array('route' => 'space_add', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-danger">
            {{ trans('template_space_add.field_errors') }} 
            </div>
        </div>
    </div>
    @endif

    @if (session('alert-success'))
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <!-- mainbar //-->
        <div class="col-md-9" style="padding-left:35px">
            <div class="form-group {{ $errors->has('space_title')?'has-error':'' }}">
            {!! Form::text('space_title', '', array('class'=>'form-control input-lg', 'placeholder'=> trans('template_space_add.space_title_placeholder'), 'maxlength' => '512')) !!}
            {!! $errors->has('space_title')?$errors->first('space_title', '<span class="help-block">:message</span>'):'' !!}
            </div>
            <div class="form-group {{ $errors->has('space_uri')?'has-error':'' }}">
                <div class="input-group">
                    <div class="input-group-addon">{{ url('/') . '/' }}</div>
                    {!! Form::text('space_uri', '', array('class'=>'form-control', 'placeholder'=> trans('template_space_add.space_uri_placeholder'), 'maxlength' => '255')) !!}
                </div>
                {!! $errors->has('space_uri')?$errors->first('space_uri', '<span class="help-block">:message</span>'):'' !!}
            </div>

            @include('admin.space.content.contenttypes', ['contenttypes' => $theme['contenttypes']])

        </div>

        <!-- sidebar //-->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('template_space_add.publish') }}</h3>
                    <input type="hidden" name="theme_id" value="{{ $space_theme_id }}">
                    <input type="hidden" id="contenttype_key" name="contenttype_key" value="">
                </div>
                <div class="panel-body">
                    <div class="clearfix">
                        <button type="button" class="btn btn-default" id="space-save-draft">{{ trans('template_space_add.save_draft') }}</button>
                    </div>
                    <div style="margin-top:10px">
                        <div>{{ trans('template_space_add.status') }} <strong>{{ ucwords($space_status) }}</strong>&nbsp;&nbsp;<a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">{{ trans('template_space_add.edit') }}</a></div> 
                    </div>
                    <div class="collapse form-inline" id="space-status" style="margin-top:10px">
                        <div class="form-group">
                            <select name="space_status" class="form-control" style="width:150px">
                                <option value="published" @if ($space_status == App\Space::STATUS_PUBLISHED) selected="selected" @endif>{{ trans('template_space_add.published') }}</option>
                                <option value="draft" @if ($space_status == App\Space::STATUS_DRAFT) selected="selected" @endif>{{ trans('template_space_add.draft') }}</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <button class="btn btn-default" id="space-status-change" type="submit">{{ trans('template_space_add.ok') }}</button>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">{{ trans('template_space_add.cancel') }}</a>
                        </div>
                    </div>
                    <div class="clearfix" style="margin-top:10px;position:relative;">
                        <button type="button" class="btn btn-success pull-right" style="margin-top:10px" id="space-save-publish">{{ trans('template_space_add.publish') }}</button>
                    </div>
                </div>
            </div>
      
            @include('admin.space.theme_partial', ['theme' => $theme])

            @if ($space_status == App\Space::STATUS_PUBLISHED)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('template_space_add.embed_code') }}</h3>
                </div>
                <div class="panel-body">
                <textarea id="space-embed-code" class="form-control" rows="4" aria-describedby="embed-code-help">{{ space_embed_code(url($space_uri), '100%') }}</textarea>
                <span id="embed-code-help" class="help-block">{{ trans('template_space_add.embed_code_help') }}</span>
                </div>
            </div>
            @endif
        </div>
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
