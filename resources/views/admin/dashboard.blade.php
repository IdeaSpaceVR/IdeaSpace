@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')
    <div class="row" style="padding-left:35px;margin-bottom:20px">
        <div class="col-md-12">
            <h1>{{ trans('template_dashboard.dashboard') }}</h1>
        </div>
    </div>

    <div class="row" style="padding-left:35px;margin-bottom:10px">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-body welcome">
                    <p style="font-weight:bold;font-size:25px" class="lead">{{ trans('template_dashboard.welcome_to_ideaspacevr') }}</p>
                    <p style="font-size:16px;color:#999">{{ trans('template_dashboard.links_to_get_you_started') }}</p>
                    <div class="row" style="margin-top:20px;padding-bottom:10px">
                        <div class="col-md-4">
                            <div> 
                                <a href="{{ route('general_settings') }}" style="font-size:16px"><i class="fa fa-btn fa-font"></i> {{ trans('template_dashboard.site_title') }}</a>
                            </div> 
                            <div style="margin-top:10px"> 
                                <a href="{{ route('space_add_select_theme') }}" style="font-size:16px"><i class="fa fa-btn fa-pencil"></i> {{ trans('template_dashboard.add_new_space') }}</a>
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div> 
                                <a href="{{ env('THEME_DIRECTORY_URL') }}" target="_blank" style="font-size:16px"><i class="fa fa-btn fa-paint-brush"></i> {{ trans('template_dashboard.get_themes') }}</a>
                            </div> 
                            <div style="margin-top:10px"> 
                                <a href="{{ env('CONTACT_URL') }}" target="_blank" style="font-size:16px"><i class="fa fa-btn fa-envelope"></i> {{ trans('template_dashboard.contact') }}</a>
                            </div> 
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-left:35px;margin-bottom:10px">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body at-a-glance">
                    <p class="lead">{{ trans('template_dashboard.at_a_glance') }}</p>
                    <div>
                        <a href="{{ route('spaces_all') }}" style="font-size:16px"><i class="fa fa-btn fa-cube"></i> {{ $number_spaces }} {{ trans('template_dashboard.spaces') }}</a>
                    </div>
                    <div style="margin-top:10px">
                        <p style="font-size:16px"><i class="fa fa-btn fa-upload" aria-hidden="true"></i> {{ trans('template_dashboard.upload_max_filesize') }} {{ $upload_max_filesize }} <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ trans('template_dashboard.upload_post_size_help') }}"></span></p>
                    </div>
                    <div style="margin-top:10px">
                        <p style="font-size:16px"><i class="fa fa-btn fa-file" aria-hidden="true"></i> {{ trans('template_dashboard.post_max_size') }} {{ $post_max_size }} <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ trans('template_dashboard.upload_post_size_help') }}"></span></p>
                    </div>
                    <div style="margin-top:10px">
                        <p style="font-size:16px"><i class="fa fa-btn fa-cog" aria-hidden="true"></i> {{ trans('template_dashboard.memory_usage') }} {{ $memory_usage }} <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" data-toggle="tooltip" data-placement="right" title="" data-original-title="{{ trans('template_dashboard.memory_usage_help') }}"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" @if (!isset($cached_news)) style="display:none" @endif>
                <div class="panel-body news">
                    <p class="lead">{{ trans('template_dashboard.ideaspacevr_news') }}</p>
                    <div class="news-headlines">
                    @if (isset($cached_news))
                        @foreach ($cached_news as $cn)
                            {!! $cn !!}
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
