<!-- a-frame //-->
<a-scene reset-camera embedded>

    <a-assets>
        <a-asset-item id="plyModel" src="{{ $model_ply }}"></a-asset-item>
    </a-assets>

    <a-entity id="camera" position="0 0 4">
        <a-camera wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_model3d_reticle_partial')

        </a-camera>
    </a-entity>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <a-sky color="#000000"></a-sky>

    <!-- x:-90 y:0 z:0 is default rotation for ply models; ply-model class is needed for separating ply models from others //-->
    <a-entity id="model" class="ply-model" scale="{{ $scale }}" position="0 0 0" rotation="{{ ($rotation_x - 90) }} {{ $rotation_y }} {{ $rotation_z }}" ply-model="src: #plyModel"></a-entity>

</a-scene>
