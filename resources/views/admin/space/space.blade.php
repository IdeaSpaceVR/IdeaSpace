@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    <h1><?php echo (($space_mode==App\Space::MODE_ADD)?'Add New':'Edit'); ?> Space</h1>

    {!! Form::open(array('route' => (($space_mode==App\Space::MODE_ADD)?'space_add':array('space_edit_submit', $space_id)), 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-danger">
            There are errors in the fields below.
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
        <div class="col-md-9">
            <div class="form-group {{ $errors->has('space_title')?'has-error':'' }}">
            {!! Form::text('space_title', (($space_mode==App\Space::MODE_ADD)?'':$space_title), array('class'=>'form-control input-lg', 'placeholder'=>'Enter title here', 'maxlength' => '512')) !!}
            {!! $errors->has('space_title')?$errors->first('space_title', '<span class="help-block">:message</span>'):'' !!}
            </div>
            <div class="form-group {{ $errors->has('space_uri')?'has-error':'' }}">
                <div class="input-group">
                    <div class="input-group-addon">{{ url('/') . '/' }}</div>
                    {!! Form::text('space_uri', (($space_mode==App\Space::MODE_ADD)?'':$space_uri), array('class'=>'form-control', 'placeholder'=>'Enter path here', 'maxlength' => '255')) !!}
                </div>
                {!! $errors->has('space_uri')?$errors->first('space_uri', '<span class="help-block">:message</span>'):'' !!}
            </div>

            @include('admin.space.controls.configuration', ['panels' => $theme['panels'], 'controls' => $theme['controls']])

        </div>

        <!-- sidebar //-->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Publish</h3>
                    @if ($space_mode == App\Space::MODE_EDIT)
                    <input type="hidden" name="space_id" value="{{ $space_id }}">
                    @endif
                    <input type="hidden" name="theme_id" value="{{ $space_theme_id }}">
                </div>
                <div class="panel-body">
                    <div class="clearfix">
                        @if ($space_mode == App\Space::MODE_EDIT)
                        <a href="{{ url($space_uri . '/preview') }}" target="_blank" role="button" class="btn btn-default pull-right" id="space-preview">Preview</a>
                        @endif
                        @if ($space_mode == App\Space::MODE_ADD)
                        <button type="button" class="btn btn-default" id="space-save-draft">Save Draft</button>
                        @endif
                    </div>
                    <div style="margin-top:10px">
                        <div>Status: <strong>{{ ucwords($space_status) }}</strong>&nbsp;&nbsp;<a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">Edit</a></div> 
                        @if ($space_mode == App\Space::MODE_EDIT)
                        <div>Updated on: {{ $space_updated_time }}</div>
                        @endif
                    </div>
                    <div class="collapse form-inline" id="space-status" style="margin-top:10px">
                        <div class="form-group">
                            <select name="space_status" class="form-control" style="width:150px">
                                <option value="published" @if ($space_status == App\Space::STATUS_PUBLISHED) selected="selected" @endif>Published</option>
                                <option value="draft" @if ($space_status == App\Space::STATUS_DRAFT) selected="selected" @endif>Draft</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <button class="btn btn-default" id="space-status-change" type="submit">OK</button>
                        </div>
                        <div class="form-group" style="margin-left:10px">
                            <a href="#" style="text-decoration:underline;" data-toggle="collapse" data-target="#space-status">Cancel</a>
                        </div>
                    </div>
                    <div class="clearfix" style="margin-top:10px;position:relative;">
                        @if ($space_mode == App\Space::MODE_EDIT)
                        <a href="{{ route('space_trash', ['id' => $space_id]) }}" id="space-move-trash" style="color:#c9302c;position:absolute;bottom:5px;left:0;">Move to Trash</a>
                        @endif
                        @if ($space_mode == App\Space::MODE_EDIT)
                        <button type="button" class="btn btn-success pull-right" style="margin-top:10px" id="space-save-update">Update</button>
                        @else
                        <button type="button" class="btn btn-success pull-right" style="margin-top:10px" id="space-save-publish">Publish</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Theme</h3>
                </div>
                <div class="panel-body text-center">
                    <img src="{{ $theme['screenshot'] }}" class="img-responsive" alt="{{ $theme['title'] }}">
                    <p style="font-weight:bold;margin-top:20px">{{ $theme['title'] }}</p>
                </div>
            </div>
            @if ($space_status == App\Space::STATUS_PUBLISHED)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Embed Code</h3>
                </div>
                <div class="panel-body">
                <textarea id="space-embed-code" class="form-control" rows="4" aria-describedby="embed-code-help">{{ space_embed_code(url($space_uri), '100%') }}</textarea>
                <span id="embed-code-help" class="help-block">Copy the code and embed this space on any web site.</span>
                </div>
            </div>
            @endif
        </div>
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
