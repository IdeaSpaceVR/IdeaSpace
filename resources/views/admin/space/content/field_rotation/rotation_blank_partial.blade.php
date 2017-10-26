@extends('admin.space.content.field_rotation.rotation_modal')

@section('scene-content')
<!-- a-frame //-->
<a-scene embedded style="width:100%">

    <a-camera id="rotation-camera"></a-camera>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

</a-scene>
<!-- a-frame //-->
@endsection
