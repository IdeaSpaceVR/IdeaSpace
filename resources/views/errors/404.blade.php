<!DOCTYPE html>
<html>
<head>
    <title>IdeaSpaceVR</title>

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

    <script src="{{ asset('public/aframe/' . config('app.aframe_lib')) }}"></script>
    <script src="{{ asset('public/aframe-animation-component/aframe-animation-component.min.js') }}"></script>
</head>
<body style="background-color:#000000">

  <a-scene>

    <a-assets>
      <img src="{{ asset('public/assets/error/images/tunnel.png') }}" id="tunnel" crossorigin>
    </a-assets>

    <a-entity position="0 0 0">
			<a-entity camera look-controls id="tunnelcam" animation="property: position; easing: linear; dur: 2000; to: 0 0 -2000; autoplay: true">
			</a-entity>
    </a-entity>

    <a-sky color="#000"></a-sky>

    <a-entity id="tunnelgeom" geometry="primitive: cylinder; height: 2000; radius: 40; open-ended: true" position="0 0 -1000" rotation="-90 0 0" material="side: double; src: #tunnel; "></a-entity>

    <a-text font="{{ asset('public/aframe/fonts/Roboto-msdf.json') }}" value="404 Not Found" width="30" align="center" position="0 0 -2005"></a-text>
    <a-text font="{{ asset('public/aframe/fonts/Roboto-msdf.json') }}" id="back" visible="false" value="404 Not Found" width="30" align="center" position="0 0 -1995" rotation="0 180 0"></a-text>

  </a-scene>

  <script>
	(function() {
		/* DOM is loaded */
		document.querySelector('#tunnelcam').addEventListener('animationcomplete', function() {
			document.querySelector('#tunnelgeom').setAttribute('visible', false);
			document.querySelector('#back').setAttribute('visible', true);
		});
	})();
  </script>

</body>
</html>
