@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene isvr-scene>

    @include('theme::assets')

        <a-entity position="0 0 0">
            <a-entity
                id="camera" 
                camera="far: 10000; fov: 80; near: 0.1; userHeight: 1.6"
                look-controls>
                <a-entity
                    cursor="fuse: false; rayOrigin: mouse"
                    raycaster="far:5001" /* needed for touch click events on #photosphere */
                    id="cursor"
                    position="0 0 -1.9"
                    geometry="primitive: circle; radius: 0.02;"
                    material="color: #FFFFFF; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>

        <a-entity laser-controls="hand: left" raycaster="far:5001" line="color: #FFFFFF" class="laser-controls"></a-entity>
        <a-entity laser-controls="hand: right" raycaster="far:5001" line="color: #FFFFFF" class="laser-controls"></a-entity>

        <!-- debug log //-->
        <!--a-entity position="-2 2 -2.3" rotation="0 30 0">
            <a-entity log geometry="primitive: plane" material="color:#000"></a-entity>
        </a-entity//-->


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
            <a-ring position="0 0.8 0.1" color="#0080e5" radius-inner="0.0625" radius-outer="0.125" theta-length="310" id="photosphere-loading-1">
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
            <a-ring position="0 0 0.1" color="#0080e5" radius-inner="0.0625" radius-outer="0.125" theta-length="310" id="photosphere-loading-2">
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
            <a-ring position="0 -0.8 0.1" color="#0080e5" radius-inner="0.0625" radius-outer="0.125" theta-length="310" id="photosphere-loading-3">
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
        </a-entity><!-- photosphere menu //-->


        <a-entity
            isvr-init-assets="url:{{ $space_url }}/content/photo-spheres?per-page=3&page=1"
            geometry="primitive: sphere; radius: 5000; segmentsWidth: 64; segmentsHeight: 64"
            material="shader: flat; side: double; color: #FFFFFF"
            scale="-1 1 1"
            rotation="0 -90 0" id="photosphere">
            <a-animation
                attribute="material.color"
                begin="photosphere-fade-out"
                dur="500"
                from="#FFFFFF"
                to="#000000">
            </a-animation>
            <a-animation
                attribute="material.color"
                begin="photosphere-fade-in"
                dur="500"
                from="#000000"
                to="#FFFFFF">
            </a-animation>
        </a-entity>

        <a-light type="ambient" color="#FFFFFF"></a-light>


        @foreach ($content['photo-spheres'] as $photosphere)

            @if (trim($photosphere['title']['#value']) != '')

                @if ($photosphere['text-styling']['#value'] == 'text-boxes') 

                    @include('theme::partials.photosphere_title_box_partial')

                @elseif ($photosphere['text-styling']['#value'] == 'floating-text') 

                    @include('theme::partials.photosphere_floating_title_partial')

                @endif

            @endif


            @if (isset($photosphere['attach-annotations']))
                @foreach ($photosphere['attach-annotations']['#positions'] as $annotation)

                    @php 
                    $rand = str_random();
                    @endphp

                    <!-- workaround: rotation - 180, otherwise annotations are positioned wrong //-->
                    <a-entity 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] - 180 }} {{ $annotation['#rotation']['#z'] }}">
                        <a-circle 
                            class="hotspot hotspot-content-id-{{ $photosphere['attach-annotations']['#content-id'] }}" 
                            data-content-id="{{ $photosphere['attach-annotations']['#content-id'] }}" 
                            data-text-content-id="{{ $annotation['#content-id'] . $rand }}"
                            isvr-hotspot-wrapper-listener
                            material="transparent: false; opacity: 0"
                            position="0 1.6 2.1" 
                            radius="0.4" 
                            scale="0.5 0.5 0.5" 
                            visible="false"
                            look-at="#camera">
                            <a-circle 
                                color="{{ $annotation['#content']['background-color']['#value'] }}" 
                                material="transparent: false; opacity: 0.6"
                                radius="0.2" 
                                position="0 0 0.01"> 
                                <a-ring
                                    color="#FFFFFF"
                                    position="0 0 0.02"
                                    radius-inner="0.05"
                                    radius-outer="0.13">
                                    <a-animation
                                        attribute="geometry.radiusOuter"
                                        to="0.15"
                                        dur="1300"
                                        direction="alternate"
                                        repeat="indefinite"
                                        easing="linear">
                                    </a-animation>
                                    <a-circle
                                        color="{{ $annotation['#content']['background-color']['#value'] }}"
                                        radius="0.05"
                                        position="0 0 0.03">
                                    </a-circle>
                                </a-ring>
                            </a-circle>
                        </a-circle>

                        <!-- hotspot text //-->
                        @if ($photosphere['text-styling']['#value'] == 'text-boxes')

                            @include('theme::partials.hotspot_text_box_partial')

                        @elseif ($photosphere['text-styling']['#value'] == 'floating-text')

                            @include('theme::partials.hotspot_floating_text_partial')

                        @endif
                        <!-- hotspot text //-->

                    </a-entity>

                @endforeach

            @endif

        @endforeach

        @endif


        <a-entity
            id="intro-0"
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
                    material="color: #606060">
                    <a-text
                        value="{{ $space_title }}"
                        color="#FFFFFF"
                        anchor="center"
                        width="1.6">
                    </a-text>
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
                    id="photosphere-loading">
                    <a-animation
                        attribute="rotation"
                        dur="1000"
                        to="0 0 -360"
                        easing="linear"
                        repeat="indefinite"
                        id="photosphere-loading-anim">
                    </a-animation>
                </a-ring>

                <a-entity 
                    id="photosphere-start-btn"
                    visible="false">
                    <a-circle
                        position="0 -0.2 0.03" 
                        radius="0.125" 
                        color="#0080e5">
                        <a-animation
                            attribute="geometry.radius"
                            to="0.140"
                            dur="1300"
                            direction="alternate"
                            repeat="indefinite"
                            easing="linear">
                        </a-animation>
                    </a-circle>
                    <a-text
                        position="0.717 -0.194 0.04" 
                        value="Start"
                        color="#FFFFFF"
                        anchor="center"
                        width="1.6">
                    </a-text>
                </a-entity>
            </a-entity>
        </a-entity><!-- intro-0 //-->

        <a-entity
            id="no-hmd-intro"
            visible="false"
            position="0 0.85 -2.1"
            geometry="primitive: plane; width: 1.8; height: 0.46"
            material="color: #FFFFFF; transparent: true; opacity: 0.5">
            <a-entity
                geometry="primitive: plane; width: 1.74; height: 0.4"
                position="0 0 0.01"
                material="color: #606060">
                <a-entity 
                    geometry="primitive: plane; width: 1.6; height: 0.35"
                    position="0 0.01 0.02" 
                    material="color: #606060">
                    <a-text
                        value="No headset connected. Click and drag to look around. Position cursor and click to select items. Press space bar on a PC or touch click on a mobile device to select photo spheres."
                        color="#FFFFFF"
                        anchor="center"
                        width="1.6">
                    </a-text>
                </a-entity>
            </a-entity>
        </a-entity><!-- no-hmd-intro //-->

    </a-scene>
@endsection
