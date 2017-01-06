<!-- a-frame //-->
<a-scene reset-camera embedded>

    <a-assets>
        <a-asset-item id="plyModel" src="{{ $model_ply }}"></a-asset-item>
    </a-assets>

    <a-entity id="camera" position="0 1.6 4">
        <a-camera></a-camera>
    </a-entity>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <a-sky color="#000000"></a-sky>

    <!-- x:-90 y:0 z:0 is default rotation for ply models; ply-model class is needed for separating ply models from others //-->
    <a-entity id="model" class="ply-model" scale="{{ $scale }}" position="0 0 0" rotation="{{ ($rotation_x - 90) }} {{ $rotation_y }} {{ $rotation_z }}" ply-model="src: #plyModel">
        <a-animation
            begin="start-rotation-y"
            end="stop-rotation-y"
            attribute="rotation"
            dur="8000"
            to="{{ ($rotation_x - 90) }} -360 {{ $rotation_z }}"
            easing="linear"
            repeat="indefinite">
        </a-animation>
    </a-entity>

</a-scene>
