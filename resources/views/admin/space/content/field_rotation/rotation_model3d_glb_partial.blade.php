@extends('admin.space.content.field_rotation.rotation_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene embedded style="width:100%" loading-screen="dotsColor: #0080e5; backgroundColor: #FFFFFF">

    <a-assets>
        <a-asset-item id="model-glb" src="{{ $model_glb }}"></a-asset-item>
    </a-assets>

    <a-entity
        id="rotation-camera"
        camera="fov: 80; zoom: 1;"
        position="0 2 5"
        orbit-controls="
          invertZoom: true;
          autoRotate: false;
          target: #rotation-model;
          enableDamping: true;
          dampingFactor: 0.125;
          rotateSpeed:0.25;
          minDistance:3;
          maxDistance:100;"
        mouse-cursor="">
    </a-entity>

    <a-sky color="#000000"></a-sky>

    <a-entity id="rotation-model" position="0 0 0" gltf-model="#model-glb" @if (isset($scale)) scale="{{ $scale }}" @endif></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection

@section('scale-sidebar')

    @include('admin.space.content.field_rotation.rotation_scale_partial')

@endsection
