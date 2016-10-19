<i class="fa fa-refresh fa-spin" style="font-size:30px;position:relative;top:60px;left:60px"></i>
<div style="width:300px;height:300px;visibility:hidden">
    <!-- a-frame //-->
    <a-scene embedded>
        <a-assets>
            <a-asset-item id="model-dae" src="{{ $model_dae }}"></a-asset-item>
        </a-assets>

        <a-sky color="#f0f0f0"></a-sky>

        <a-entity id="model" position="0 0 0" collada-model="#model-dae"></a-entity>
    </a-scene>
</div>
