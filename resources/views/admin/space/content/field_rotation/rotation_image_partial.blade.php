@extends('admin.space.content.field_rotation.rotation_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene embedded style="width:100%">

    <a-assets>
        <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
    </a-assets>

    <a-entity
        id="rotation-camera"
        camera="fov: 80; zoom: 1;"
        position="0 2 5"
        orbit-controls="
          invertZoom: true;
          autoRotate: false;
          target: #rotation-image;
          enableDamping: true;
          dampingFactor: 0.125;
          rotateSpeed:0.25;
          minDistance:3;
          maxDistance:100;"
        mouse-cursor="">
    </a-entity>

    <a-sky color="#000000"></a-sky>

    <a-image id="rotation-image" position="0 1.6 -20" visible="false" load-image="src:{{ $uri }}" width="{{ $width_meter }}" height="{{ $height_meter }}"></a-image>

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
