@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    {!! Form::open(array('route' => 'themes', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    <h1 style="padding-left:35px">{{ trans('template_themes_config.themes') }} <a href="{{ config('app.theme_directory_url') }}" style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" role="button" target="_blank"><i class="fa fa-btn fa-download"></i> {{ trans('template_themes_config.get_themes') }}</a> <a href="{{ route('space_add') }}" style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" role="button"><i class="fa fa-btn fa-pencil"></i> {{ trans('template_themes_config.add_new_space') }}</a></h1> 

    <?php $i=0; ?>
    @foreach ($themes as $theme)
    <?php if ($i % 3 == 0) { ?>
      <?php if ($i != 0) { ?>
      </div> <!-- end row //-->
      <?php } ?>
    <div class="row" style="padding-left:35px">
    <?php } ?>
        <div class="col-md-4 text-center">
            <input type="hidden" name="id-{{ $theme['id'] }}" value="{{ $theme['id'] }}">
            <div class="thumbnail">
                <img width="470" src="{{ $theme['screenshot'] }}" class="img-responsive" alt="{{ $theme['theme-name'] }}">
                <div class="caption">
                    <h3 class="name">{{ $theme['theme-name'] }}</h3>
                    @if ($theme['status_aria_pressed'] == 'true')
                    <div class="label label-success installed" style="padding-top:4px;font-size:14px"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_themes_config.installed') }}</div>
                    @else
                    <div class="label label-success installed" style="padding-top:4px;font-size:14px;visibility:hidden"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_themes_config.installed') }}</div>
                    @endif
                    <h5><strong>{{ trans('template_themes_config.version') }}</strong> {{ $theme['theme-version'] }}</h5>
                    <h5><strong>{{ trans('template_themes_config.author') }}</strong> {{ $theme['theme-author-name'] }}</h5>
                    <h5><a href="{{ $theme['theme-homepage'] }}" target="_blank">{{ $theme['theme-homepage'] }}</a></h5>
                    <p>{{ $theme['theme-description'] }}</p>
                    <p style="margin-top:20px"><button type="button" class="theme-btn btn @if($theme['status']==\App\Theme::STATUS_ERROR || $theme['status']==\App\Theme::STATUS_INCOMPATIBLE) btn-danger @else btn-primary @endif {{ $theme['status_class'] }}" data-toggle="button" aria-pressed="{{ $theme['status_aria_pressed'] }}" autocomplete="off" data-theme-status="{{ $theme['status'] }}" @if($theme['status']==\App\Theme::STATUS_ERROR || $theme['status']==\App\Theme::STATUS_INCOMPATIBLE) disabled="disabled" @endif>{{ $theme['status_text'] }}</button></p>
                </div>
            </div>
        </div>
    <?php $i++; ?>
    @endforeach
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
