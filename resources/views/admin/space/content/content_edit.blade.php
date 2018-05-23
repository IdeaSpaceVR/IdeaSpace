@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:20px">{{ trans('template_content_edit.edit') }} {{ $form['#label'] }}</h1>

    {!! Form::open(array('route' => ['content_edit', $space_id, $contenttype_name, $content_id], 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row">
        <div class="col-md-9" style="padding-left:35px">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-9" style="padding-left:35px">
            <div class="alert alert-danger">
            {{ trans('template_content_edit.field_errors') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <!-- mainbar //-->
        <div class="col-md-9" style="padding-left:35px">

            <div class="form-group {{ $errors->has('isvr_content_title')?'has-error':'' }}" @if ($has_contenttype_uri) style="margin-bottom:15px" @endif>
                {!! Form::text('isvr_content_title', $form['isvr_content_title'], array('class'=>'form-control input-lg', 'placeholder'=> trans('template_content_edit.content_title_placeholder'), 'maxlength' => '250')) !!}
                <span class="info-block">{{ trans('template_content_edit.content_title_info') }} <span class="label label-danger">{{ trans('template_fields.required') }}</span></span>
                {!! $errors->has('isvr_content_title')?$errors->first('isvr_content_title', '<span class="help-block">:message</span>'):'' !!}
            </div>

            @if ($has_contenttype_uri)
            <div class="form-group {{ $errors->has('isvr_content_uri')?'has-error':'' }}">
                <div class="input-group">
                    <div class="input-group-addon">{{ url('/') . '/' . $space_uri . '/' }}</div>
                    {!! Form::text('isvr_content_uri', $form['isvr_content_uri'], array('class'=>'form-control', 'placeholder'=> trans('template_content_edit.content_uri_placeholder'), 'maxlength' => '255')) !!}
                </div>
                {!! $errors->has('isvr_content_uri')?$errors->first('isvr_content_uri', '<span class="help-block">:message</span>'):'' !!}
            </div>
            @endif

            <?php
            /* include template modals only once */
            $field_template_arr = [];
            ?>
            @foreach ($form['#fields'] as $field_id => $properties)
                @include($properties['#template'], ['field_id' => $field_id, 'form' => $properties])
                @if (isset($properties['#template_modal']) && !in_array($properties['#template_modal'], $field_template_arr))
                    @push('field_modals')
                        @include($properties['#template_modal'], ['isvr_content_title' => $form['isvr_content_title'], 'field_id' => $field_id, 'form' => $properties])
                    @endpush
                    <?php $field_template_arr[] = $properties['#template_modal'];  ?>
                @endif
            @endforeach        

            <div class="form-group text-center">
                <button type="button" class="btn btn-primary btn-lg content-add-save" style="margin-right:20px"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_content_edit.save') }}</button> <a href="{{ route('content_delete', ['space_id' => $space_id, 'contenttype' => $contenttype_name, 'content_id' => $content_id]) }}" role="button" class="btn btn-default btn-lg content-add-cancel" style="margin-right:20px"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {{ trans('template_content_edit.delete') }}</a> <a href="{{ route('space_edit', ['id' => $space_id]) }}#{{ $contenttype_name }}" role="button" class="btn btn-default btn-lg content-add-cancel"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_content_edit.cancel') }}</a> 
            </div>

        </div>

        <!-- sidebar //-->
        <div class="col-md-3">

            @include('admin.space.theme_partial', ['theme' => $theme])

        </div>

    </div><!-- row //-->

    {!! Form::close() !!}

    @stack('field_modals')

    @include('admin.asset_library.assets_modal')

@endsection
