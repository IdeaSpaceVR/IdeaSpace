@extends('admin.space.content.field_position.positions_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%" loading-screen="dotsColor: #0080e5; backgroundColor: #FFFFFF">

    <a-assets>
        <a-asset-item id="plyModel" src="{{ $model_ply }}"></a-asset-item>
				<img src="{{ asset('public/assets/admin/asset-library/images/grid.png') }}" id="grid" crossorigin="anonymous">
    </a-assets>

    <a-entity id="camera-wrapper" position="0 0 4">
        <a-entity id="camera" camera position="0 1.6 0" look-controls wasd-controls="fly:true; acceleration:200">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-entity>
    </a-entity>

		<a-circle
				id="floor"
				visible="true"
				src="#grid"
				repeat="100 100"
				radius="100"
				position="0 0 0"
				rotation="-90 0 0">
		</a-circle>

    <a-sky color="#000000"></a-sky>

    <!--a-entity id="model" class="ply-model" scale="{{ $scale }}" position="0 0 0" rotation="{{ ($rotation_x - 90) }} {{ $rotation_y }} {{ $rotation_z }}" ply-model="src: #plyModel"></a-entity//-->
    <!-- x:-90 y:0 z:0 is default rotation for ply models; ply-model class is needed for separating ply models from others //-->
    <a-entity id="model" class="ply-model" position="0 0 0" rotation="-90 0 0" ply-model="src: #plyModel"></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection
