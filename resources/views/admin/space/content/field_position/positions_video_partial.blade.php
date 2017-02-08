<!-- a-frame //-->
<a-scene reset-camera embedded style="width:100%">

    <a-assets>
        <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
        <video id="video" src="{{ $uri }}">
    </a-assets>

    <a-entity id="camera" position="0 0 4">
        <a-camera wasd-controls="fly:true">

            @include('admin.space.content.field_position.positions_model3d_reticle_partial')

        </a-camera>
    </a-entity>

    <a-sky id="default-sky" color="#000000"></a-sky>

    <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

    <a-video id="vr-view-video" load-video width="8" height="4" position="0 2 -20" visible="false"></a-video>

    <a-entity
        position="0 1.6 -4"
        geometry="primitive: circle; radius: 2"
        material="transparent: true; src: #loading"
        id="image-loading">
        <a-animation
            attribute="rotation"
            dur="5000"
            to="0 0 -360"
            easing="linear"
            repeat="indefinite"
            id="image-loading-anim">
        </a-animation>
    </a-entity>

</a-scene>
<!-- a-frame //-->
