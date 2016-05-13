@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene>

    @include('theme::assets')

        <a-entity id="camera-wrapper" position="0 0 10000">
            <a-entity
                id="camera" 
                camera="far: 40000; fov: 80; near: 0.5;"
                look-controls>
                <a-entity
                    cursor="fuse: false; maxDistance: 35000;"
                    id="cursor"
                    position="0 0 -3.4"
                    material="color:#FFFFFF"
                    geometry="primitive: sphere; radius: 0.03;"
                    visible="false">
                </a-entity>
            </a-entity>

            <!-- background photo sphere //-->
            <a-entity 
                isvr-init-assets="url:{{ $space_url }}/field-data?key=images_upload&chunk-size=3&page=1"
                position="0 0 0"
                geometry="primitive: sphere; radius: 35000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; color: #000000"
                scale="-1 1 1">
            </a-entity>

            @if (count($content['images_upload']['data']) > 0) 
                <a-animation attribute="position" dur="4000" begin="in-sphere-1" to="-11000 0 -20000"></a-animation>
                <a-animation attribute="position" dur="4000" begin="out-sphere-1" from="-11000 0 -20000" to="0 0 10000"></a-animation>
            @endif
            @if (count($content['images_upload']['data']) > 1) 
                <a-animation attribute="position" dur="4000" begin="in-sphere-2" to="0 0 -20000"></a-animation>
                <a-animation attribute="position" dur="4000" begin="out-sphere-2" from="0 0 -20000" to="0 0 10000"></a-animation>
            @endif
            @if (count($content['images_upload']['data']) > 2) 
                <a-animation attribute="position" dur="4000" begin="in-sphere-3" to="11000 0 -20000"></a-animation>
                <a-animation attribute="position" dur="4000" begin="out-sphere-3" from="11000 0 -20000" to="0 0 10000"></a-animation>
            @endif
        </a-entity>


        @if (count($content['images_upload']['data']) > 0) 
            @if (count($content['images_upload']['data']) > 3)
            <!-- navigation photo sphere //-->
            <a-entity 
                isvr-nav-cursor
                visible="false"
                position="-22000 0 -20000"
                geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; side: double; color: #0080e5; src: #nav-sphere"
                rotation="0 -60 0" 
                id="nav-left-sphere">
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 0) 
            <!-- photo sphere //-->
            <a-entity 
                isvr-cursor
                position="-11000 0 -20000"
                geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; side: double; color: #ffffff; src: #loading-sphere"
                rotation="0 -60 0" 
                data-default-rotation="0 -60 0"
                class="sphere"
                id="sphere-1">
                <a-animation 
                    attribute="rotation"
                    dur="5000"
                    to="-360 -60 0"
                    easing="linear"
                    repeat="indefinite"
                    id="loading-anim-1">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 1) 
            <!-- photo sphere //-->
            <a-entity 
                isvr-cursor
                position="0 0 -20000"
                geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; side: double; color: #ffffff; src: #loading-sphere"
                rotation="0 -80 0" 
                data-default-rotation="0 -80 0"
                class="sphere"
                id="sphere-2">
                <a-animation 
                    attribute="rotation"
                    dur="5000"
                    to="-360 -80 0"
                    easing="linear"
                    repeat="indefinite"
                    id="loading-anim-2">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 2) 
            <!-- photo sphere //-->
            <a-entity 
                isvr-cursor
                position="11000 0 -20000"
                geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; side: double; color: #ffffff; src: #loading-sphere"
                rotation="0 -100 0" 
                data-default-rotation="0 -100 0"
                class="sphere"
                id="sphere-3">
                <a-animation 
                    attribute="rotation"
                    dur="5000"
                    to="-360 -100 0"
                    easing="linear"
                    repeat="indefinite"
                    id="loading-anim-3">
                </a-animation>
            </a-entity>
            @endif
            @if (count($content['images_upload']['data']) > 3) 
            <!-- navigation photo sphere //-->
            <a-entity 
                isvr-nav-cursor="url:{{ $space_url }}/field-data?key=images_upload&chunk-size=3&page=2"
                visible="@if (count($content['images_upload']['data']) > 3) true @else false @endif"
                position="22000 0 -20000"
                geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
                material="shader: flat; side: double; color: #0080e5; src: #nav-sphere"
                rotation="180 -120 0" 
                id="nav-right-sphere">
            </a-entity>
            @endif
        @endif

    </a-scene>

@endsection
