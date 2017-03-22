@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene>

    @include('theme::assets')

        <a-entity position="0 1.6 0">
            <a-entity
                id="camera" 
                camera="far: 10000; fov: 80; near: 0.1;"
                look-controls>
                <a-entity
                    cursor="fuse: false;"
                    id="cursor"
                    position="0 0 -2"
                    geometry="primitive: circle; radius: 0.05;"
                    material="color: #0080e5; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>

        @if (isset($content['photo-spheres']) && count($content['photo-spheres']) > 0) 

        <a-entity data-current-page="1" isvr-photosphere-menu id="photosphere-menu" visible="false">
            @if (count($content['photo-spheres']) > 3)
            <a-entity isvr-photosphere-menu-navigation id="menu-arrow-up" position="0 1.5 0" visible="false" geometry="primitive: plane; width: 1; height: 0.5" material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
            @if (count($content['photo-spheres']) > 0) 
            <a-image data-image-id="1" data-content-id="{{ $content['photo-spheres'][0]['photo-sphere']['#content-id'] }}" isvr-photosphere-menu-thumb id="photosphere-thumb-1" class="img-photosphere-thumb" width="2" height="0.7" position="0 0.8 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 0.8 0" to="0 0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0.8 0.5" to="0 0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-ring position="0 0.8 0.1" color="#0080e5" radius-inner="0.125" radius-outer="0.25" theta-length="310" id="photosphere-loading-1">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-1">
                </a-animation>
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 1) 
            <a-image data-image-id="2" data-content-id="{{ $content['photo-spheres'][1]['photo-sphere']['#content-id'] }}" isvr-photosphere-menu-thumb id="photosphere-thumb-2" class="img-photosphere-thumb" width="2" height="0.7" position="0 0 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 0 0" to="0 0 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 0 0.5" to="0 0 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-ring position="0 0 0.1" color="#0080e5" radius-inner="0.125" radius-outer="0.25" theta-length="310" id="photosphere-loading-2">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-2">
                </a-animation>
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 2) 
            <a-image data-image-id="3" data-content-id="{{ $content['photo-spheres'][2]['photo-sphere']['#content-id'] }}" isvr-photosphere-menu-thumb id="photosphere-thumb-3" class="img-photosphere-thumb" width="2" height="0.7" position="0 -0.8 0" visible="false">
                <a-animation attribute="position" begin="mouseenter" from="0 -0.8 0" to="0 -0.8 0.5" dur="400"></a-animation>
                <a-animation attribute="position" begin="mouseleave" from="0 -0.8 0.5" to="0 -0.8 0" dur="400"></a-animation>
                <a-animation attribute="material.opacity" begin="fade" to="1"></a-animation>
            </a-image>
            <a-ring position="0 -0.8 0.1" color="#0080e5" radius-inner="0.125" radius-outer="0.25" theta-length="310" id="photosphere-loading-3">
                <a-animation
                    attribute="rotation"
                    dur="5000"
                    to="0 0 -360"
                    easing="linear"
                    repeat="indefinite"
                    id="photosphere-loading-anim-3">
                </a-animation>
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 3) 
            <a-entity isvr-photosphere-menu-navigation="url:{{ $space_url }}/content/photo-spheres?per-page=3&page=2" id="menu-arrow-down" position="0 -1.5 0" visible="@if (count($content['photo-spheres']) > 3) true @else false @endif" geometry="primitive: plane; width: 1; height: 0.5" material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
        </a-entity>

        <a-entity
            isvr-init-assets="url:{{ $space_url }}/content/photo-spheres?per-page=3&page=1"
            geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
            material="shader: flat; side: double; color: #000000"
            scale="-1 1 1"
            rotation="0 0 0" id="photosphere">
            <a-animation
                attribute="material.color"
                begin="photosphere-fading"
                dur="300"
                from="#000"
                to="#FFF">
            </a-animation>
        </a-entity>


        @foreach ($content['photo-spheres'] as $photosphere)

            @if (trim($photosphere['title']['#value']) != '')
                <a-entity
                    class="photosphere-title"
                    id="photosphere-title-content-id-{{ $photosphere['title']['#content-id'] }}"
                    isvr-photosphere-title-listener 
                    position="0 0 -1"
                    rotation="0 0 0"
                    geometry="primitive: plane; width: auto; height: auto"
                    material="color: #000; opacity: 0.5"
                    visible="false" 
                    text="color: #FFF; align: center; wrapCount: 30; width: 3; font: {{ asset('/public/aframe/fonts/Roboto-msdf.json') }}; value: {{ $photosphere['title']['#value'] }}">
                </a-entity>
            @endif


            @if (isset($photosphere['attach-text-notes']))
                @foreach ($photosphere['attach-text-notes']['#positions'] as $text_note)

                    @php 
                    $rand = str_random();
                    @endphp

                    <a-sphere class="hotspot-wrapper hotspot-wrapper-content-id-{{ $photosphere['attach-text-notes']['#content-id'] }}" material="color: #FFFFFF; side: double; shader: flat; opacity: 0" radius="0.5" visible="false" position="{{ $text_note['#position']['#x'] }} {{ $text_note['#position']['#y'] }} {{ $text_note['#position']['#z'] }}" rotation="{{ $text_note['#rotation']['#x'] }} {{ $text_note['#rotation']['#y'] }} {{ $text_note['#rotation']['#z'] }}" scale="1 1 1" isvr-hotspot-wrapper-listener data-content-id="{{ $photosphere['attach-text-notes']['#content-id'] }}" data-text-content-id="{{ $text_note['#content-id'] . $rand }}">
                        <a-sphere class="hotspot hotspot-content-id-{{ $photosphere['attach-text-notes']['#content-id'] }}" scale="1 1 1" material="color: #0080e5; side: double; shader: flat; opacity: 0.5" radius="0.1" visible="false">
                            <a-animation
                                attribute="radius"
                                begin="hotspot-intro-{{ $photosphere['attach-text-notes']['#content-id']}}"
                                direction="alternate"
                                dur="300"
                                from="0.1"
                                repeat="1"
                                to="0.01">
                            </a-animation>
                        </a-sphere>
                    </a-sphere>

                    <a-entity
                        class="hotspot-text hotspot-text-content-id-{{ $text_note['#content-id'] . $rand }}"
                        isvr-hotspot-text-listener
                        data-content-id="{{ $photosphere['attach-text-notes']['#content-id'] }}"
                        position="{{ $text_note['#position']['#x'] }} {{ $text_note['#position']['#y'] }} {{ $text_note['#position']['#z'] }}"
                        rotation="{{ $text_note['#rotation']['#x'] }} {{ $text_note['#rotation']['#y'] }} {{ $text_note['#rotation']['#z'] }}"
                        geometry="primitive: plane; width: auto; height: auto"
                        material="color: #000; opacity: 0.5"
                        visible="false" 
                        text="color: #FFF; align: left; wrapCount: 30; width: 3; font: {{ asset('/public/aframe/fonts/Roboto-msdf.json') }}; value: {{ $text_note['#content'][0]['#value'] }}">
                    </a-entity>

                @endforeach

                @endif

            @endforeach

        @endif

        <a-ring position="0 1.6 -4" color="#0080e5" radius-inner="0.25" radius-outer="0.5" theta-length="310" id="photosphere-loading">
            <a-animation
                attribute="rotation"
                dur="5000"
                to="0 0 -360"
                easing="linear"
                repeat="indefinite"
                id="photosphere-loading-anim">
            </a-animation>
        </a-ring>

    </a-scene>
@endsection
