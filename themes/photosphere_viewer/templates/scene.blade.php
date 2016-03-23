@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene>

    @include('theme::assets')

        <a-entity position="0 1.8 5">
            <a-entity
                id="camera" 
                camera="far: 10000; fov: 80; near: 0.5;"
                look-controls="enabled: true">
                <a-entity
                    cursor="fuse: false; maxDistance: 500; timeout: 3000;"
                    id="cursor"
                    position="0 0 -3.4"
                    geometry="primitive: ring; radiusOuter: 0.10; radiusInner: 0.05;"
                    material="color: red; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>

        @if (count($content['images_upload']['data']) > 0) 
        <a-entity data-current-page="1" isvr-photosphere-menu id="photosphere-menu" visible="false">
            @if (count($content['images_upload']['data']) > 3)
            <a-entity isvr-photosphere-menu-navigation id="menu-arrow-up" position="0 1.5 0" visible="false">
                <a-plane position="-0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#5b00f4"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#5b00f4"></a-plane>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 0) 
            <a-image data-image-id="1" isvr-photosphere-menu-thumb class="img-photosphere-thumb" src="#img-photosphere-1-thumb" width="2" height="0.7" position="0 0.8 0">
                <a-animation attribute="position" begin="mouseenter" from="0 0.8 0" to="0 0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0.8 0.5" to="0 0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            @endif
            @if (count($content['images_upload']['data']) > 1) 
            <a-image data-image-id="2" isvr-photosphere-menu-thumb class="img-photosphere-thumb" src="#img-photosphere-2-thumb" width="2" height="0.7" position="0 0 0">
                <a-animation attribute="position" begin="mouseenter" from="0 0 0" to="0 0 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0 0.5" to="0 0 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            @endif
            @if (count($content['images_upload']['data']) > 2) 
            <a-image data-image-id="3" isvr-photosphere-menu-thumb class="img-photosphere-thumb" src="#img-photosphere-3-thumb" width="2" height="0.7" position="0 -0.8 0">
                <a-animation attribute="position" begin="mouseenter" from="0 -0.8 0" to="0 -0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 -0.8 0.5" to="0 -0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            @endif
            @if (count($content['images_upload']['data']) > 3) 
            <a-entity isvr-photosphere-menu-navigation="url:{{ $space_url }}/field-data?key=images_upload&chunk-size=3&page=2" id="menu-arrow-down" position="0 -1.5 0" visible="@if (count($content['images_upload']['data']) > 3) true @else false @endif">
                <a-plane position="-0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#5b00f4"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#5b00f4"></a-plane>
            </a-entity>
            @endif
        </a-entity>
        @endif

        <a-entity 
            geometry="primitive:sphere;radius:5000;segmentsWidth:64;segmentsHeight:64"
            material="shader:flat;color:#ffffff;fog:false;@if (count($content['images_upload']['data']) > 0) src:#img-photosphere-1 @endif"
            scale="-1 1 1"
            rotation="0 -60 0" id="photosphere">
        </a-entity>

    </a-scene>
@endsection
