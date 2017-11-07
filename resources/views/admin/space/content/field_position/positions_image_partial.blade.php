@extends('admin.space.content.field_position.positions_modal')

@section('isvr_content_title', $isvr_content_title)

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%">

    <a-assets>
        <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
    </a-assets>

    <a-entity id="camera-wrapper" position="0 0 4">
        <a-entity id="camera" camera position="0 1.6 0" look-controls wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-entity>
    </a-entity>

    <a-sky color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <a-image id="vr-view-image" position="0 1.6 -20" visible="false" load-image="src:{{ $uri }}" width="{{ $width_meter }}" height="{{ $height_meter }}"></a-image>

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
