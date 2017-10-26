@extends('admin.space.content.field_rotation.rotation_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene embedded style="width:100%">

    <a-assets>
        <a-asset-item id="plyModel" src="{{ $model_ply }}"></a-asset-item>
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

    <!-- x:-90 y:0 z:0 is default rotation for ply models; ply-model class is needed for separating ply models from others //-->
    <a-entity id="rotation-model" class="ply-model" position="0 0 0" rotation="-90 0 0" ply-model="src: #plyModel" @if (isset($scale)) scale="{{ $scale }}" @endif></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection

@section('scale-sidebar')

    @include('admin.space.content.field_rotation.rotation_scale_partial')

@endsection
