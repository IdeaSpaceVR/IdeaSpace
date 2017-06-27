<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:30px;position:relative;top:60px;left:60px"></i>
<div style="width:300px;height:300px;visibility:hidden">

    <!-- a-frame //-->
    <a-scene reset-camera id="preview-scene" embedded>

        <a-assets>
            <a-asset-item id="preview-model-gltf" src="{{ $model_gltf }}"></a-asset-item>
        </a-assets>

        <a-entity id="preview-camera">
            <a-camera></a-camera>
        </a-entity>

        <a-sky color="#f0f0f0"></a-sky>

        <a-entity id="preview-model" position="0 0 0" gltf-model="#preview-model-gltf"></a-entity>

    </a-scene>

</div>
