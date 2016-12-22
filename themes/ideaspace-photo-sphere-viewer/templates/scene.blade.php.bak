@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene>

    @include('theme::assets')

        <a-entity position="0 1.8 5">
            <a-entity
                id="camera" 
                camera="far: 10000; fov: 80; near: 0.5;"
                look-controls>
                <a-entity
                    cursor="fuse: false; maxDistance: 5000;"
                    id="cursor"
                    position="0 0 -3.4"
                    geometry="primitive: ring; radiusOuter: 0.06; radiusInner: 0.02;"
                    material="color: #0080e5; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>

        @if (count($content['images_upload']['data']) > 0) 
        <a-entity data-current-page="1" isvr-photosphere-menu id="photosphere-menu" visible="false">
            @if (count($content['images_upload']['data']) > 3)
            <a-entity isvr-photosphere-menu-navigation id="menu-arrow-up" position="0 1.5 0" visible="false" geometry="primitive: plane; width: 1; height: 0.5" material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 0) 
            <a-image data-image-id="1" isvr-photosphere-menu-thumb id="photosphere-thumb-1" class="img-photosphere-thumb" width="2" height="0.7" position="0 0.8 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 0.8 0" to="0 0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0.8 0.5" to="0 0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-entity 
                position="0 0.8 0.1"
                geometry="primitive: circle; radius: 0.5"
                material="transparent: true; src: #loading"
                id="photosphere-loading-1">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-1">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 1) 
            <a-image data-image-id="2" isvr-photosphere-menu-thumb id="photosphere-thumb-2" class="img-photosphere-thumb" width="2" height="0.7" position="0 0 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 0 0" to="0 0 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0 0.5" to="0 0 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-entity 
                position="0 0 0.1"
                geometry="primitive: circle; radius: 0.5"
                material="transparent: true; src: #loading"
                id="photosphere-loading-2">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-2">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 2) 
            <a-image data-image-id="3" isvr-photosphere-menu-thumb id="photosphere-thumb-3" class="img-photosphere-thumb" width="2" height="0.7" position="0 -0.8 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 -0.8 0" to="0 -0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 -0.8 0.5" to="0 -0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-entity 
                position="0 -0.8 0.1"
                geometry="primitive: circle; radius: 0.5"
                material="transparent: true; src: #loading"
                id="photosphere-loading-3">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-3">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 3) 
            <a-entity isvr-photosphere-menu-navigation="url:{{ $space_url }}/field-data?key=images_upload&chunk-size=3&page=2" id="menu-arrow-down" position="0 -1.5 0" visible="@if (count($content['images_upload']['data']) > 3) true @else false @endif" geometry="primitive: plane; width: 1; height: 0.5" material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
        </a-entity>
        @endif

        <a-entity 
            isvr-init-assets="url:{{ $space_url }}/field-data?key=images_upload&chunk-size=3&page=1"
            geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
            material="shader: flat; side: double; color: #000000"
            scale="-1 1 1"
            rotation="0 -60 0" id="photosphere">
        </a-entity>

        <a-entity 
            position="0 1.8 -4"
            geometry="primitive: circle; radius: 2"
            material="transparent: true; src: #loading"
            id="photosphere-loading">
            <a-animation
                attribute="rotation"
                dur="5000"
                to="0 0 -360"
                easing="linear"
                repeat="indefinite"
                id="photosphere-loading-anim">
            </a-animation>
        </a-entity>

    </a-scene>
@endsection
