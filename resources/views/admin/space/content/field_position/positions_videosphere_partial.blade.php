@extends('admin.space.content.field_position.positions_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%">

    <a-assets>
        <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
        <video id="videosphere" src="{{ $uri }}">
    </a-assets>

    <a-entity id="camera-wrapper" position="0 0 0">
        <a-entity id="camera" camera position="0 1.6 0" look-controls wasd-controls="fly:false">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-entity>
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <!-- rotate to center video //-->
    <a-videosphere load-videosphere visible="false" rotation="0 -90 0"></a-videosphere>

    <a-entity
        position="0 1.6 -4"
        geometry="primitive: circle; radius: 2"
        material="transparent: true; src: #loading"
        id="image-loading">
        <a-animation
            attribute="rotation"
            dur="5000"
            to="0 0 -360"
            easing="linear"
            repeat="indefinite"
            id="image-loading-anim">
        </a-animation>
    </a-entity>

</a-scene>
<!-- a-frame //-->
@endsection
