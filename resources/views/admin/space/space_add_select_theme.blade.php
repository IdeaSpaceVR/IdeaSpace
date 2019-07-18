@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:35px">{{ trans('template_space_add_edit.headline_new_space') }}</h1> 
    <h3 style="padding-left:35px">{{ trans('template_space_add_edit.select_theme') }}</h3>

    {!! Form::open(array('route' => 'space_add_select_theme_submit', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($themes) === 0) 
        <div class="row" style="padding-left:35px">
            <div class="col-md-12" style="font-size:16px">
            {{ trans('template_space_add_edit.no_installed_themes') }} <a href="{{ route('themes') }}" style="color:#000000;text-decoration:underline">{{ trans('template_space_add_edit.install_some_themes') }}</a>.
            </div>    
        </div>    
    @endif 

    <?php $i=0; ?>
    @foreach ($themes as $theme)
    <?php if ($i % 3 == 0) { ?>
      <?php if ($i != 0) { ?>
      </div> <!-- end row //-->
      <?php } ?>
    <div class="row" style="padding-left:35px">
    <?php } ?>
        <div class="col-md-4 text-center">
            <div class="thumbnail">
                <input type="hidden" name="id-{{ $theme['id'] }}" value="{{ $theme['id'] }}">
                <img width="470" src="{{ $theme['screenshot'] }}" class="img-responsive" alt="{{ $theme['theme-name'] }}">
                <div class="caption">
                    <h3>{{ $theme['theme-name'] }}</h3>
                    <p class="text-center">{{ $theme['theme-description'] }}</p>
                    <button class="btn btn-default btn-primary" type="button">{{ trans('template_space_add_edit.select') }}</button>
                </div>
            </div>
        </div>
    <?php $i++; ?>
    @endforeach
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
