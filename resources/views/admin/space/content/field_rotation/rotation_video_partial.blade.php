@extends('admin.space.content.field_rotation.rotation_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene embedded style="width:100%">

    <a-assets>
        <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
        <video id="video" src="{{ $uri }}">
    </a-assets>

    <a-entity
        id="rotation-camera"
        camera="fov: 80; zoom: 1;"
        position="0 2 5"
        orbit-controls="
          invertZoom: true;
          autoRotate: false;
          target: #rotation-video;
          enableDamping: true;
          dampingFactor: 0.125;
          rotateSpeed:0.25;
          minDistance:3;
          maxDistance:100;"
        mouse-cursor="">
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-video id="rotation-video" load-video width="8" height="4" position="0 2 -20" visible="false"></a-video>

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

@section('scale-sidebar')

    @include('admin.space.content.field_rotation.rotation_scale_partial')

@endsection
