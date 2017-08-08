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

    <meta http-equiv="origin-trial" data-feature="WebVR" data-expires="04/11/17" content="{{ $origin_trial_token }}">

    <meta property="og:site_name" content="@yield('title')" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:description" content="@yield('title')" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ \Request::url() }}" />

    <link rel="stylesheet" href="{{ url($theme_dir . '/css/style.css') }}">
    <script src="{{ url($theme_dir . '/js/aframe.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/aframe-extras/aframe-extras.loaders.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/aframe-orbit-controls-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/kframe/aframe-look-at-component.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/aframe-mouse-cursor-component.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-vr-mode.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-model-center.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-hotspot.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-annotation.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-floor-grid.js') }}"></script>
</head>
<body>

@yield('scene')

    <script src="{{ url($theme_dir . '/js/main.js') }}"></script>
</body>
</html>
