@extends('admin.space.content.field_position.positions_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%" loading-screen="dotsColor: #0080e5; backgroundColor: #FFFFFF">

		<a-assets>
				<img src="{{ asset('public/assets/admin/asset-library/images/grid.png') }}" id="grid" crossorigin="anonymous">
		</a-assets>

		<a-entity id="camera-wrapper" position="0 0 0">
        <a-entity id="camera" camera position="0 1.6 0" look-controls wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-camera>
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

		<a-circle
				id="floor"
				visible="true"
				src="#grid"
				repeat="100 100"
				radius="100"
				position="0 0 0"
				rotation="-90 0 0">
		</a-circle>

</a-scene>
<!-- a-frame //-->
@endsection
