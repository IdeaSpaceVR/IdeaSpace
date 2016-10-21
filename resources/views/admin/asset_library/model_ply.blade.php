<!-- a-frame //-->
<a-scene embedded>

    <a-assets>
        <a-asset-item id="plyModel" src="{{ $model_ply }}"></a-asset-item>
    </a-assets>

    <a-entity id="camera" position="0 0 14">
        <a-camera></a-camera>
    </a-entity>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <a-sky color="#000000"></a-sky>

    <a-entity id="model" position="0 0 0" rotation="-90 0 0" ply-model="src: #plyModel"></a-entity>

</a-scene>
