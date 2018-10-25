@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:35px">{{ trans('template_space_settings.space_settings') }}</h1>

    {!! Form::open(array('route' => 'space_settings', 'method' => 'POST', 'autocomplete' => 'false')) !!}

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
            <label for="front-page-display" class="control-label" style="margin-top:7px">{{ trans('template_space_settings.frontpage_displays') }}</label>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <div class="radio">
                        <label>
                        {!! Form::radio('front-page-display', 'one-space', $one_space_checked) !!}
                        {{ trans('template_space_settings.one_space_select_below') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <?php 
                $arr = ['class' => 'form-control'];
                ?>
                {!! Form::select('space', $spaces, $space_id_selected, $arr) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="radio">
                        <label>
                        {!! Form::radio('front-page-display', 'blank-page', $blank_page_checked) !!}
                        {{ trans('template_space_settings.blank_page') }}
                        </label>
                    </div>
                </div>
            </div>
        </div> <!-- end col-md-10 //-->
    </div> <!-- end row //-->

    <div class="row" style="margin-top:20px;padding-left:35px">
        <div class="col-md-10 col-md-offset-2">
        <button type="submit" class="btn btn-primary">{{ trans('template_space_settings.save_changes') }}</button>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
