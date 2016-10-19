<i class="fa fa-refresh fa-spin" style="font-size:30px;position:relative;top:60px;left:60px"></i>
<div style="width:300px;height:300px;visibility:hidden">
    <!-- a-frame //-->
    <a-scene embedded>
        <a-assets>
            <a-asset-item id="model-ply" src="{{ $model_ply }}"></a-asset-item>
        </a-assets>

        <a-sky color="#f0f0f0"></a-sky>

        <a-entity id="model" position="0 0 0" ply-model="#model-ply"></a-entity>
    </a-scene>
</div>
