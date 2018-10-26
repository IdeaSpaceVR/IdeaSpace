<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}"/>

    <meta name="abstract" content="IdeaSpaceVR - create interactive 3D and VR web experiences for desktop, mobile & VR devices" />
    <meta name="description" content="IdeaSpaceVR - create interactive 3D and VR web experiences for desktop, mobile & VR devices" />
    <meta name="keywords" content="web vr 3D interactive webvr virtual reality" />
    <meta name="robots" content="follow, index" />

    <meta http-equiv="origin-trial" data-feature="{{ $origin_trial_token_data_feature }}" data-expires="{{ $origin_trial_token_data_expires }}" content="{{ $origin_trial_token }}">

    <meta property="og:site_name" content="@yield('title')" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:description" content="IdeaSpaceVR - create interactive 3D and VR web experiences for desktop, mobile & VR devices" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="{{ asset('public/font-awesome/css/font-awesome.min.css') }}" rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

		@php embed_fonts(); @endphp



    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/layouts/app/css/app.css') }}">

    <?php 
    if (isset($css)) {
      foreach ($css as $c) { 
    ?>
    <link href="<?php echo $c; ?>" rel="stylesheet">
    <?php 
      }
    } 
    ?>

    <?php 
    if (isset($js_header)) {
      foreach ($js_header as $j_h) { 
    ?>
    <script src="<?php echo $j_h; ?>" type="text/javascript"></script>
    <?php 
      }
    } 
    ?>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                    <span class="sr-only">{{ trans('template_app.toggle_navigation') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}"><img alt="IdeaSpace" style="width:20px;display:inline" src="{{ asset('public/assets/layouts/app/images/isvr-logo-v2.png') }}"></a>
            </div>

            <div class="collapse navbar-collapse" id="spark-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                    <li role="presentation"><a href="{{ url('/') }}"><i class="fa fa-btn fa-home"></i> {{ trans('template_app.home') }}</a></li>
                    @else
                    <li role="presentation"><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-home"></i> {{ trans('template_app.dashboard') }}</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li role="presentation"><a href="{{ url('/login') }}">{{ trans('template_app.login') }}</a></li>
                    @else
                        <li class="hidden-lg hidden-md hidden-sm dropdown">
                            <a href="#" class="dropdown-toggle menu-has-submenu" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-btn fa-cube"></i> {{ trans('template_app.spaces') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" id="spaces-sub-xs">
                            <li @if (Route::currentRouteName() == 'spaces_all' || Route::currentRouteName() == 'space_edit' || Route::currentRouteName() == 'content_add' || Route::currentRouteName() == 'content_edit') class="active" @endif role="presentation"><a href="{{ route('spaces_all') }}"><i class="fa fa-btn fa-cubes"></i> {{ trans('template_app.all') }}</a></li>
                            <li @if (Route::currentRouteName() == 'space_add_select_theme' || Route::currentRouteName() == 'space_add') class="active" @endif role="presentation"><a href="{{ route('space_add_select_theme') }}"><i class="fa fa-btn fa-pencil"></i> {{ trans('template_app.add_new') }}</a></li>
                        </ul>
                        </li>
                        <li class="hidden-lg hidden-md hidden-sm @if (Route::currentRouteName() == 'assets') active @endif" role="presentation"><a href="{{ route('assets') }}"><i class="fa fa-btn fa-image"></i> {{ trans('template_app.assets') }}</a></li>
                        <li class="hidden-lg hidden-md hidden-sm @if (Route::currentRouteName() == 'themes') active @endif" role="presentation"><a href="{{ route('themes') }}"><i class="fa fa-btn fa-paint-brush"></i> {{ trans('template_app.themes') }}</a></li>   
                        <li class="hidden-lg hidden-md hidden-sm dropdown">
                            <a href="#" class="dropdown-toggle menu-has-submenu" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-btn fa-cogs"></i> {{ trans('template_app.settings') }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" id="spaces-sub-xs">
                            <li @if (Route::currentRouteName() == 'general_settings') class="active" @endif role="presentation"><a href="{{ route('general_settings') }}"><i class="fa fa-btn fa-cog"></i> {{ trans('template_app.general') }}</a></li>
                            <li @if (Route::currentRouteName() == 'space_settings') class="active" @endif role="presentation"><a href="{{ route('space_settings') }}"><i class="fa fa-btn fa-cube"></i> {{ trans('template_app.space') }}</a></li>
                        </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ ucfirst(Auth::user()->name) }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation"><a href="{{ route('edit_user_profile', ['user_id' => Auth::user()->id]) }}"><i class="fa fa-btn fa-edit"></i>{{ trans('template_app.edit_profile') }}</a></li>
                                <li role="presentation"><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('template_app.logout') }}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if (Auth::guest())
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
        
            @yield('content')

            </div>
        </div>
    </div>

    @else

    <div class="container-fluid" style="min-height:600px">
        <div class="row">
            <!-- sidebar -->
            <div class="col-xs-1" id="sidebar-nav" role="navigation">
                <ul class="nav nav-stacked sidebar-nav">
                    <li><a href="#" class="collapsed menu-has-submenu" data-toggle="collapse" data-target="#spaces-sub-md-lg"><i class="fa fa-btn fa-cube"></i> {{ trans('template_app.spaces') }} <span class="caret"></span></a>
                        <ul class="nav collapse @if (Route::currentRouteName() == 'spaces_all' || Route::currentRouteName() == 'space_add_select_theme' || Route::currentRouteName() == 'space_add' || Route::currentRouteName() == 'space_edit' || Route::currentRouteName() == 'content_add' || Route::currentRouteName() == 'content_edit') in @endif" id="spaces-sub-md-lg">
                            <li @if (Route::currentRouteName() == 'spaces_all' || Route::currentRouteName() == 'space_edit' || Route::currentRouteName() == 'content_add' || Route::currentRouteName() == 'content_edit') class="active" @endif><a href="{{ route('spaces_all') }}"><i class="fa fa-btn fa-cubes"></i> {{ trans('template_app.all') }}</a></li>
                            <li @if (Route::currentRouteName() == 'space_add_select_theme' || Route::currentRouteName() == 'space_add') class="active" @endif><a href="{{ route('space_add_select_theme') }}"><i class="fa fa-btn fa-pencil"></i> {{ trans('template_app.add_new') }}</a></li>
                        </ul>
                    </li>
                    <li @if (Route::currentRouteName() == 'assets') class="active" @endif><a href="{{ route('assets') }}"><i class="fa fa-btn fa-image"></i> {{ trans('template_app.assets') }}</a></li>
                    <li @if (Route::currentRouteName() == 'themes') class="active" @endif><a href="{{ route('themes') }}"><i class="fa fa-btn fa-paint-brush"></i> {{ trans('template_app.themes') }}</a></li>   
                    <li><a href="#" class="collapsed menu-has-submenu" data-toggle="collapse" data-target="#settings-sub-md-lg"><i class="fa fa-btn fa-cogs"></i> {{ trans('template_app.settings') }} <span class="caret"></span></a>
                      <ul class="nav collapse @if (Route::currentRouteName() == 'general_settings' || Route::currentRouteName() == 'space_settings') in @endif" id="settings-sub-md-lg">
                        <li @if (Route::currentRouteName() == 'general_settings') class="active" @endif><a href="{{ route('general_settings') }}"><i class="fa fa-btn fa-cog"></i> {{ trans('template_app.general') }}</a></li>
                        <li @if (Route::currentRouteName() == 'space_settings') class="active" @endif><a href="{{ route('space_settings') }}"><i class="fa fa-btn fa-cube"></i> {{ trans('template_app.space') }}</a></li>
                      </ul>
                    </li>
                </ul>
            </div> 
            <div id="sidebar-icons-nav" class="col-xs-1" role="navigation">
                <ul class="nav nav-stacked sidebar-nav">
                    <li><a href="#" class="menu-has-submenu" data-toggle="collapse" data-target="#spaces-sub-sm"><i class="fa fa-btn fa-cube"></i><span class="caret"></span></a>
                        <ul class="nav collapse @if (Route::currentRouteName() == 'spaces_all' || Route::currentRouteName() == 'space_add_select_theme' || Route::currentRouteName() == 'space_add' || Route::currentRouteName() == 'space_edit' || Route::currentRouteName() == 'content_add' || Route::currentRouteName() == 'content_edit') in @endif" id="spaces-sub-sm">
                            <li @if (Route::currentRouteName() == 'spaces_all' || Route::currentRouteName() == 'space_edit' || Route::currentRouteName() == 'content_add' || Route::currentRouteName() == 'content_edit') class="active" @endif><a href="{{ route('spaces_all') }}"><i class="fa fa-btn fa-cubes"></i></a></li>
                            <li @if (Route::currentRouteName() == 'space_add_select_theme' || Route::currentRouteName() == 'space_add') class="active" @endif><a href="{{ route('space_add_select_theme') }}"><i class="fa fa-btn fa-pencil"></i></a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('assets') }}"><i class="fa fa-btn fa-image"></i></a></li>
                    <li @if (Route::currentRouteName() == 'themes') class="active" @endif><a href="{{ route('themes') }}"><i class="fa fa-btn fa-paint-brush"></i></a></li>   
                    <li><a href="#" class="menu-has-submenu" data-toggle="collapse" data-target="#settings-sub-sm"><i class="fa fa-btn fa-cogs"></i><span class="caret"></span></a></li>
                        <ul class="nav collapse @if (Route::currentRouteName() == 'general_settings' || Route::currentRouteName() == 'space_settings') in @endif" id="settings-sub-sm">
                            <li @if (Route::currentRouteName() == 'general_settings') class="active" @endif><a href="{{ route('general_settings') }}"><i class="fa fa-btn fa-cog"></i></a></li>
                            <li @if (Route::currentRouteName() == 'space_settings') class="active" @endif><a href="{{ route('space_settings') }}"><i class="fa fa-btn fa-cube"></i></a></li>
                        </ul>
                    </li>
                </ul>
            </div> 
            <div class="col-xs-11">
            @yield('content')
            </div>
        </div>
    </div>
    @endif

    <div class="footer clearfix" style="margin:50px 0 10px 0">
        <div class="text-center">
        Made on Earth <i class="fa fa-globe" aria-hidden="true"></i> 
        </div>
        <div class="pull-right" style="margin: 0 20px 0 0;font-size:12px">
        {{ trans('template_app.version') }} {{ config('app.version') }} 
        </div>
    </div>

    <script>
    window.ideaspace_site_path = '{{ url('/') }}';
    </script>
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="{{ asset('public/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/layouts/app/js/app.js') }}"></script>

    <?php 
    if (isset($js)) {
      foreach ($js as $j) { 
    ?>
    <script src="<?php echo $j; ?>" type="text/javascript"></script>
    <?php 
      }
    } 
    ?>

</body>
</html>
