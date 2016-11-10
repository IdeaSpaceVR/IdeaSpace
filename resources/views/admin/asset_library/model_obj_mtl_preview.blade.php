<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:30px;position:relative;top:60px;left:60px"></i>
<div style="width:300px;height:300px;visibility:hidden">

    <!-- a-frame //-->
    <a-scene reset-camera id="preview-scene" embedded>

        <a-assets>
            <a-asset-item id="preview-model-obj" src="{{ $model_obj }}"></a-asset-item>
            <a-asset-item id="preview-model-mtl" src="{{ $model_mtl }}"></a-asset-item>
        </a-assets>

        <a-entity id="preview-camera">
            <a-camera></a-camera>
        </a-entity>

        <a-sky color="#f0f0f0"></a-sky>

        <a-entity id="preview-model" position="0 0 0" obj-model="obj: #preview-model-obj; mtl: #preview-model-mtl"></a-entity>

    </a-scene>

</div>
