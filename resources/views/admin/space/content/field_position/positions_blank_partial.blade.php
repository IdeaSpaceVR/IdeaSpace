@extends('admin.space.content.field_position.positions_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%">

		<a-entity id="camera-wrapper" position="0 0 0">
        <a-entity id="camera" camera position="0 1.6 0" look-controls wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-camera>
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection
