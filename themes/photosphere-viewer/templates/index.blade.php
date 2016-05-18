<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> <!-- Fullscreen Landscape on iOS -->

    <meta name="abstract" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <meta name="robots" content="follow, index" />

    <meta property="og:site_name" content="" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:description" content="" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />

    <link rel="stylesheet" href="{{ url($theme_dir . '/css/style.css') }}">
    <script src="{{ url($theme_dir . '/js/aframe.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-init-assets-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-thumb-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-navigation-component.js') }}"></script>
</head>
<body>

@yield('scene')

</body>
</html>
