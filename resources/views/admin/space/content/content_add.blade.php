@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    <h1 style="padding-left:20px">{{ trans('template_content_add.add_new') }} {{ $form['#label'] }}</h1>

    {!! Form::open(array('route' => ['content_add', $space_id, $contenttype_name], 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-danger">
            {{ trans('template_space_add.field_errors') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <!-- mainbar //-->
        <div class="col-md-9" style="padding-left:35px">

            @foreach ($form['#fields'] as $field_id => $properties)
                @include($properties['#template'], ['field_id' => $field_id, 'form' => $properties])
            @endforeach        

        </div>

        <!-- sidebar //-->
        <div class="col-md-3">

            @include('admin.space.theme_partial', ['theme' => $theme])

        </div>

    </div><!-- row //-->

    {!! Form::close() !!}

@endsection
