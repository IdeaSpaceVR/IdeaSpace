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
    @if (isset($content['photo-spheres']) && count($content['photo-spheres']) > 0)
    <meta property="og:image:secure_url" content="{{ $content['photo-spheres'][0]['photo-sphere']['#uri']['#value'] }}" />
    <meta property="og:image" content="{{ $content['photo-spheres'][0]['photo-sphere']['#uri']['#value'] }}" />
    @endif
    <meta property="og:description" content="@yield('title')" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ \Request::url() }}" />

    <link rel="stylesheet" href="{{ url($theme_dir . '/css/style.css') }}">
    <script src="{{ url($theme_dir . '/js/aframe.min.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-init-assets-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-thumb-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-menu-navigation-component.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-hotspot-wrapper-listener.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-hotspot-text-listener.js') }}"></script>
    <script src="{{ url($theme_dir . '/js/isvr-photosphere-title-listener.js') }}"></script>
</head>
<body>

    <div class="outer" id="intro">
        <div class="middle">
            <div class="inner">
                <div class="title">@yield('title')</div>
                <div class="start">
                    <button id="start-btn" href="#">Start</button>
                </div>
                <div class="instructions">
                    <div class="instruction"><strong>Mobile VR:</strong><br> Press button to view menu. A photo sphere containing hotspots renders a cursor. Press button to activate a hotspot.</div>
                    <div class="instruction"><strong>Desktop VR (seated):</strong><br> Press space on keyboard to view menu. Mouse click to select photo sphere. A photo sphere containing hotspots renders a cursor. Hover the cursor over a hotspot and click to activate a hotspot. </div>
                </div>
            </div>
        </div>
    </div>

@yield('scene')

    <script src="{{ url($theme_dir . '/js/main.js') }}"></script>
</body>
</html>
