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

    <script src="{{ asset('public/assets/error/js/aframe.min.js') }}"></script>
    <script src="{{ asset('public/assets/error/js/aframe-text-component.min.js') }}"></script>
</head>
<body style="background-color:#000000">

  <a-scene>

    <a-assets>
      <img src="{{ asset('public/assets/error/images/tunnel.png') }}" id="tunnel">
    </a-assets>

    <a-entity id="tunnelcam" position="0 0 0" camera="far: 10000; fov: 80; near: 0.5;" look-controls="enabled: true">
      <a-animation id="anim0" attribute="position" from="0 0 0" to="0 0 -2000" ease="linear" begin="start" dur="3000"></a-animation>
    </a-entity>

    <a-sky color="#000"></a-sky>

    <a-entity id="tunnelgeom" geometry="primitive: cylinder; height: 2000; radius: 40; open-ended: true" position="0 0 -1000" rotation="-90 0 0" material="side: double; src: #tunnel; "></a-entity>

    <a-entity text="text: 404 Not Found" material="color: #fff" position="-2.3 0 -2005"></a-entity>
    <a-entity id="back" visible="false" rotation="0 180 0" text="text: 404 Not Found" material="color: #fff" position="2.3 0 -1995"></a-entity>

  </a-scene>

  <script>
  document.querySelector('#tunnelcam').emit('start');

  document.querySelector('#anim0').addEventListener('animationend', function() {
    document.querySelector('#tunnelgeom').setAttribute('visible', false);
    document.querySelector('#back').setAttribute('visible', true);
  });

  var restart = function(evt) {
    document.querySelector('#back').setAttribute('visible', false);
    document.querySelector('#tunnelgeom').setAttribute('visible', true);
    document.querySelector('#tunnelcam').setAttribute('position', '0 0 0');
    document.querySelector('#tunnelcam').emit('start');
  }

  var restart_touchevt = function(evt) {
    restart();
  }

  var restart_keyevt = function(evt) {
    /* space */
    if (evt.keyCode == '32') {
      restart();
    }
  }

  window.addEventListener('touchstart', restart_touchevt);
  window.addEventListener('keyup', restart_keyevt);
  </script>

</body>
</html>
