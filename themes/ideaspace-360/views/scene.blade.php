@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene isvr-scene renderer="antialias: true" background="color: #000000" loading-screen="dotsColor: #FFFFFF; backgroundColor: #000000">

    @include('theme::assets')


				<!--a-entity log geometry="primitive: plane" material="color: #111" text="color: lightgreen" position="0 1.6 -3"></a-entity//-->


        <a-entity id="camera-wrapper" position="0 1.6 0">
            <a-entity
                id="camera" 
                camera
                look-controls>
                <a-entity
                    cursor="fuse: false; rayOrigin: mouse"
                    id="cursor"
                    raycaster="objects: .collidable; far:5000"
                    position="0 0 -1.9"
                    geometry="primitive: circle; radius: 0.02;"
                    material="color: #FFFFFF; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>

        <a-entity laser-controls="hand: left" raycaster="objects: .collidable; far:5000" line="color: #FFFFFF" class="laser-controls" visible="false"></a-entity>
        <a-entity laser-controls="hand: right" raycaster="objects: .collidable; far:5000" line="color: #FFFFFF" class="laser-controls" visible="false"></a-entity>

				<a-light type="ambient" color="#FFFFFF"></a-light>


        @if (isset($content['photo-spheres']) && count($content['photo-spheres']) > 0) 

        <a-entity 
						data-current-page="1" 
						isvr-photosphere-menu 
						id="photosphere-menu" 
						visible="false">
            @if (count($content['photo-spheres']) > 3)
            <a-entity 
								isvr-photosphere-menu-navigation 
								id="menu-arrow-up" 
								class="collidable" 
								position="0 1.5 0" 
								visible="false" 
								geometry="primitive: plane; width: 1; height: 0.5" 
								material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
            @if (count($content['photo-spheres']) > 0) 
            <a-plane
								isvr-photosphere-menu-thumb="id: #photosphere-thumb-1" 
								class="collidable" 
								width="2" 
								height="0.7" 
								visible="false" 
								position="0 0.8 0.501"> 
            </a-plane>
            <a-image 
								data-image-id="1" 
								data-content-id="{{ $content['photo-spheres'][0]['photo-sphere']['#content-id'] }}" 
								id="photosphere-thumb-1" 
								class="img-photosphere-thumb" 
								width="2" 
								height="0.7" 
								position="0 0.8 0" 
								animation__mouseenter="property: position; from: 0 0.8 0; to: 0 0.8 0.5; dur: 400; startEvents: trigger-mouseenter" 
								animation__mouseleave="property: position; from: 0 0.8 0.5; to: 0 0.8 0; dur: 400; startEvents: trigger-mouseleave" 
								animation__fade="property: material.opacity; to: 1; startEvents: fade" 
								visible="false">
            </a-image>
            <a-ring 
								position="0 0.8 0.1" 
								color="#0080e5" 
								radius-inner="0.0625" 
								radius-outer="0.125" 
								theta-length="310" 
								animation__rotation="property: rotation; to: 0 0 -360; dur: 5000; easing: linear; loop: true; autoplay: true; startEvents: photosphere-loading-anim-1; pauseEvents: stop-photosphere-loading-anim-1" 
								id="photosphere-loading-1">
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 1) 
            <a-plane
								isvr-photosphere-menu-thumb="id: #photosphere-thumb-2" 
								class="collidable" 
								width="2" 
								height="0.7" 
								visible="false" 
								position="0 0 0.501"> 
            </a-plane>
            <a-image 
								data-image-id="2" 
								data-content-id="{{ $content['photo-spheres'][1]['photo-sphere']['#content-id'] }}" 
								id="photosphere-thumb-2" 
								class="img-photosphere-thumb" 
								width="2" 
								height="0.7" 
								position="0 0 0" 
								animation__mouseenter="property: position; from: 0 0 0; to: 0 0 0.5; dur: 400; startEvents: trigger-mouseenter" 
								animation__mouseleave="property: position; from: 0 0 0.5; to: 0 0 0; dur: 400; startEvents: trigger-mouseleave" 
								animation__fade="property: material.opacity; to: 1; startEvents: fade" 
								visible="false">
            </a-image>
            <a-ring 
								position="0 0 0.1" 
								color="#0080e5" 
								radius-inner="0.0625" 
								radius-outer="0.125" 
								theta-length="310" 
								animation__rotation="property: rotation; to: 0 0 -360; dur: 5000; easing: linear; loop: true; autoplay: true; startEvents: photosphere-loading-anim-2; pauseEvents: stop-photosphere-loading-anim-2" 
								id="photosphere-loading-2">
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 2) 
            <a-plane
								isvr-photosphere-menu-thumb="id: #photosphere-thumb-3" 
								class="collidable" 
								width="2" 
								height="0.7" 
								visible="false" 
								position="0 -0.8 0.501"> 
            </a-plane>
            <a-image 
								data-image-id="3" 
								data-content-id="{{ $content['photo-spheres'][2]['photo-sphere']['#content-id'] }}" 
								id="photosphere-thumb-3" 
								class="img-photosphere-thumb" 
								width="2" 
								height="0.7" 
								position="0 -0.8 0" 
								animation__mouseenter="property: position; from: 0 -0.8 0; to: 0 -0.8 0.5; dur: 400; startEvents: trigger-mouseenter" 
								animation__mouseleave="property: position; from: 0 -0.8 0.5; to: 0 -0.8 0; dur: 400; startEvents: trigger-mouseleave" 
								animation__fade="property: material.opacity; to: 1; startEvents: fade" 
								visible="false">
            </a-image>
            <a-ring 
								position="0 -0.8 0.1" 
								color="#0080e5" 
								radius-inner="0.0625" 
								radius-outer="0.125" 
								theta-length="310" 
								animation__rotation="property: rotation; to: 0 0 -360; dur: 5000; easing: linear; loop: true; autoplay: true; startEvents: photosphere-loading-anim-3; pauseEvents: stop-photosphere-loading-anim-3" 
								id="photosphere-loading-3">
            </a-ring>
            @endif
            @if (count($content['photo-spheres']) > 3) 
            <a-entity 
								isvr-photosphere-menu-navigation="url:{{ $space_url }}/content/photo-spheres?per-page=3&page=2" 
								id="menu-arrow-down" 
								class="collidable" 
								position="0 -1.5 0" 
								visible="@if (count($content['photo-spheres']) > 3) true @else false @endif" 
								geometry="primitive: plane; width: 1; height: 0.5" 
								material="transparent: true; opacity: 0">
                <a-plane position="-0.07 0 0" rotation="0 0 45" width="0.10" height="0.3" color="#0080e5"></a-plane>
                <a-plane position="0.07 0 0" rotation="0 0 -45" width="0.10" height="0.3" color="#0080e5"></a-plane>
            </a-entity>
            @endif
        </a-entity><!-- photosphere menu //-->


        <a-sky
						class="collidable"
						rotation="0 -90 0"
            isvr-init-assets="url:{{ $space_url }}/content/photo-spheres?per-page=3&page=1"
            animation__fadeout="property: material.color; from: #FFFFFF; to: #000000; dur: 500; startEvents: photosphere-fade-out"
            animation__fadein="property: material.color; from: #000000; to: #FFFFFF; dur: 500; startEvents: photosphere-fade-in"
						id="photosphere">
        </a-sky>


        @foreach ($content['photo-spheres'] as $photosphere)

            @if (trim($photosphere['title']['#value']) != '')

            		@include('theme::partials.photosphere_title_box_partial')

            @endif


            @if (isset($photosphere['attach-annotations']))
                @foreach ($photosphere['attach-annotations']['#positions'] as $annotation)

                    @php 
                    $rand = str_random();
                    @endphp

                    <a-entity 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] }} {{ $annotation['#rotation']['#z'] }}">
                        <a-circle 
                            class="collidable hotspot hotspot-content-id-{{ $photosphere['attach-annotations']['#content-id'] }}" 
                            data-content-id="{{ $photosphere['attach-annotations']['#content-id'] }}" 
                            data-text-content-id="{{ $annotation['#content-id'] . $rand }}"
                            isvr-hotspot-wrapper-listener
                            material="transparent: false; opacity: 0"
                            position="0 1.6 -2.1" 
                            radius="0.4" 
                            scale="0.5 0.5 0.5" 
                            visible="false">
                            <a-circle 
                                color="{{ $annotation['#content']['background-color']['#value'] }}" 
                                material="transparent: false; opacity: 0.6"
                                radius="0.2" 
                                position="0 0 0.01"> 
                                <a-ring
                                    color="#FFFFFF"
                                    position="0 0 0.02"
                                    animation="property: geometry.radiusOuter; to: 0.15; dur: 1300; loop: true; easing: linear; dir: alternate"
                                    radius-inner="0.05"
                                    radius-outer="0.13">
                                    <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
                                    <a-circle
                                        material="opacity: 0"
                                        position="0 0 0.04"
                                        radius="0.4">
                                    </a-circle>
                                    <a-circle
                                        color="{{ $annotation['#content']['background-color']['#value'] }}"
                                        radius="0.05"
                                        position="0 0 0.03">
                                    </a-circle>
                                </a-ring>
                            </a-circle>
                        </a-circle>

                        @include('theme::partials.hotspot_text_box_partial')

                    </a-entity>

                @endforeach

            @endif

        @endforeach

        @endif


        <a-entity
            id="intro-0"
            class="collidable"
            visible="true"
            position="0 1.6 -2.1"
            geometry="primitive: plane; width: 1.8; height: 1"
            material="color: #FFFFFF; transparent: true; opacity: 0.5">
            <a-entity
                geometry="primitive: plane; width: 1.74; height: 0.94"
                position="0 0 0.01"
                material="color: #606060">
                <a-entity 
                    geometry="primitive: plane; width: 1.6; height: 0.4"
                    position="0 0.2 0.02" 
										material="shader: html; target: #space-title-texture; transparent: false; ratio: width">
                </a-entity>
                <a-ring 
                    position="0 -0.2 0.03" 
                    color="#000000" 
                    radius-inner="0.108" 
                    radius-outer="0.145" 
                    id="photosphere-loading-background">
                </a-ring>
                <a-ring 
                    position="0 -0.2 0.04" 
                    color="#0080e5" 
                    radius-inner="0.105" 
                    radius-outer="0.145" 
                    theta-length="120" 
                    animation="property: rotation; dur: 1000; to: 0 0 -360; easing: linear; loop: true; autoplay: true; pauseEvents: stop-photosphere-loading-anim" 
                    id="photosphere-loading">
                </a-ring>

                <a-entity 
                    id="photosphere-start-btn"
                    visible="false">
                    <a-circle
                    		id="photosphere-start-btn-circle"
                        position="0 -0.2 0.03" 
                        radius="0.125" 
                        animation="property: geometry.radius; to: 0.140; dur: 1300; dir: alternate; loop: true; easing: linear; pauseEvents: stop-photosphere-start-btn-anim"
                        color="#0080e5">
                    </a-circle>
                    <a-text
                        position="0.717 -0.194 0.04" 
                        value="Start"
                        color="#FFFFFF"
                        anchor="center"
                        width="1.6">
                    </a-text>
                    <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
                    <a-entity
                        material="opacity: 0"
                        geometry="primitive: plane; width: 1.5; height: 0.7"
                        position="0 0 0.09">
                    </a-entity>
                </a-entity>
            </a-entity>
        </a-entity><!-- intro-0 //-->

    </a-scene>


		<div class="cover">
    </div>


    <div id="space-title-texture" style="color:#FFFFFF;background-color:#606060">
    {!! $space_title !!}
    </div>


		@if (isset($content['photo-spheres']))
        @foreach ($content['photo-spheres'] as $photosphere)
            @if (trim($photosphere['title']['#value']) != '')
                <div id="photosphere-title-texture-content-id-{{ $photosphere['photo-sphere']['#content-id'] }}" class="photosphere-title-texture" style="background-color:{{ $photosphere['background-color']['#value'] }}; color:{{ $photosphere['text-color']['#value'] }}">
                {!! $photosphere['title']['#value'] !!}
                </div>
            @endif
        @endforeach
    @endif


    @if (isset($content['annotations']))
        @foreach ($content['annotations'] as $annotation)
            <div id="annotation-text-texture-content-id-{{ $annotation['text']['#content-id'] }}" class="annotation-text-texture" style="background-color:{{ $annotation['background-color']['#value'] }}; color:{{ $annotation['text-color']['#value'] }}">
            {!! nl2br($annotation['text']['#value']) !!}
            </div>
        @endforeach
    @endif

@endsection


