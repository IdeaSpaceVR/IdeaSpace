@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    {!! Form::open(array('route' => 'themes', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    <?php $i=0; ?>
    @foreach ($themes as $theme)
    <?php if ($i % 3 == 0) { ?>
      <?php if ($i != 0) { ?>
      </div> <!-- end row //-->
      <?php } ?>
    <div class="row">
    <?php } ?>
        <div class="col-md-4 text-center">
            <input type="hidden" name="id-{{ $theme['id'] }}" value="{{ $theme['id'] }}">
            <div class="thumbnail">
                <img width="470" src="{{ $theme['screenshot'] }}" class="img-responsive" alt="{{ $theme['theme-name'] }}">
                <div class="caption">
                    <h3 class="name">{{ $theme['theme-name'] }}</h3>
                    @if ($theme['status_aria_pressed'] == 'true')
                    <span class="label label-success installed" style="font-size:100%"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_themes_config.installed') }}</span>
                    @else
                    <span class="label label-success installed" style="font-size:100%;display:none"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_themes_config.installed') }}</span>
                    @endif
                    <h5><strong>{{ trans('template_themes_config.version') }}</strong> {{ $theme['theme-version'] }}</h5>
                    <h5><strong>{{ trans('template_themes_config.author') }}</strong> {{ $theme['theme-author-name'] }}</h5>
                    <h5><a href="{{ $theme['theme-homepage'] }}" target="_blank">{{ $theme['theme-homepage'] }}</a></h5>
                    <p>{{ $theme['theme-description'] }}</p>
                    @foreach ($theme['theme-compatibility'] as $theme_comp)
                    <span class="label label-info" style="display:inline-block">{{ $theme_comp }}</span>
                    @endforeach
                    <p style="margin-top:20px"><button type="button" class="theme-btn btn btn-primary {{ $theme['status_class'] }}" data-toggle="button" aria-pressed="{{ $theme['status_aria_pressed'] }}" autocomplete="off" data-theme-status="{{ $theme['status'] }}">{{ $theme['status_text'] }}</button></p>
                </div>
            </div>
        </div>
    <?php $i++; ?>
    @endforeach
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
