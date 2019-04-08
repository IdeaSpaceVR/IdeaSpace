<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> <!-- Fullscreen Landscape on iOS -->

    <meta name="abstract" content="@yield('title')" />
    <meta name="description" content="@yield('title')" />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <meta name="robots" content="follow, index" />

    <meta http-equiv="origin-trial" data-feature="{{ $origin_trial_token_data_feature }}" data-expires="{{ $origin_trial_token_data_expires }}" content="{{ $origin_trial_token }}">

    <meta property="og:site_name" content="@yield('title')" />
    <meta property="og:image:secure_url" content="{{ url($theme_dir . '/screenshot.png') }}" />
    <meta property="og:image" content="{{ url($theme_dir . '/screenshot.png') }}" />
    <meta property="og:description" content="@yield('title')" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ \Request::url() }}" />

		@php
    if (function_exists('embed_fonts')) {
      embed_fonts(true);
    }
    @endphp

    <link rel="stylesheet" href="{{ url($theme_dir . '/css/style.css') }}">
    <script src="{{ url($theme_dir . '/js/aframe-master.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/aframe-star-system-component/aframe-star-system-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/ideaspacevr/isvr-image-trigger.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/aframe-html-shader/aframe-html-shader.min.js') }}"></script>
</head>
<body>

@yield('scene')

</body>
</html>
