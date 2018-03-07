@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:20px">{{ trans('template_content_delete.delete') }} {{ $label }}</h1>

    {!! Form::open(array('route' => ['content_delete', $space_id, $contenttype_name, $content_id], 'method' => 'POST', 'autocomplete' => 'false')) !!}

		@if (isset($referenced_content))
				<?php $field_ids = ''; ?>
				@foreach ($referenced_content as $ref_content)
				<?php $field_ids = $field_ids . $ref_content['field_id'] . ','; ?>	
				@endforeach
				<?php $field_ids = substr($field_ids, 0, -1); ?>
		<input type="hidden" name="referenced_field_ids" value="{{ $field_ids }}">
		@endif

    <div class="row">

        <!-- mainbar //-->
        <div class="col-md-9" style="padding-left:35px">
						@if (isset($referenced_content))
								@foreach ($referenced_content as $ref_content)
								<div class="alert alert-info" role="alert">{!! trans('template_content_delete.referenced_content_message', ['title' => $title, 'other_type' => $ref_content['content_type_other'], 'title_other' => $ref_content['content_title_other']]) !!}</div>
								@endforeach
						@endif
            <h3>{{ trans('template_content_delete.are_you_sure') }} <em>{{ $title }}</em> ?</h3>
            <div>{{ trans('template_content_delete.action_cannot_be_undone') }}</div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-danger btn-lg content-delete" style="margin-right:20px"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {{ trans('template_content_delete.delete') }}</button> <a href="{{ route('space_edit', ['id' => $space_id]) }}" role="button" class="btn btn-default btn-lg content-add-cancel"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_content_edit.cancel') }}</a>
            </div>
        </div>

        <!-- sidebar //-->
        <div class="col-md-3">

            @include('admin.space.theme_partial', ['theme' => $theme])

        </div>

    </div><!-- row //-->

    {!! Form::close() !!}

@endsection
