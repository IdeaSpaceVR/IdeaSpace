@extends('admin.space.content.field_position.positions_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%">

    <a-entity id="camera" position="0 0 4">
        <a-camera wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_reticle_partial')

        </a-camera>
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection
