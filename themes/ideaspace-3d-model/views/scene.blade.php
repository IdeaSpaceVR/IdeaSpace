@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene 
        isvr-model-center="{{ ((isset($content['model']) && isset($content['model'][0]['camera-offset']))?$content['model'][0]['camera-offset']['#value']:0) }}" 
        @if (isset($content['model'])) isvr-vr-mode="camera_distance_vr: {{ $content['model'][0]['camera-offset-vr']['#value'] }}" @endif>

        @include('theme::assets')

        <a-entity id="camera-wrapper" position="0 0 0"> 
            <a-entity
                id="camera" 
                mouse-cursor
                camera="fov: 80; userHeight: 1.6"
                position="0 0 0"
                orbit-controls="
                    autoRotate: false;
                    target: #model;
                    distance: 0; 
                    enableDamping: true;
                    enablePan: false; 
                    enableZoom: false; 
                    dampingFactor: 0.125;
                    rotateSpeed: 0.25;
                    minDistance: 1;
                    maxDistance: 2000">
            </a-entity>
        </a-entity>

        <a-light type="ambient" color="#FFFFFF"></a-light>


        @if (isset($content['model']))

            <a-entity laser-controls="hand: left" /*raycaster="far:5001"*/ line="color: #FFFFFF" class="laser-controls"></a-entity>
            <a-entity laser-controls="hand: right" /*raycaster="far:5001"*/ line="color: #FFFFFF" class="laser-controls"></a-entity>

            <?php 
            if (isset($content['model'][0]['scene-background-color'])) {
                $topColor = str_replace('#', '', $content['model'][0]['scene-background-color']['#value']);
                $topColorX = hexdec(substr($topColor, 0, 2)); 
                $topColorY = hexdec(substr($topColor, 2, 2)); 
                $topColorZ = hexdec(substr($topColor, 4, 2)); 
                $topColor = $topColorX . ' ' . $topColorY . ' ' . $topColorZ;
            } else {
                $topColor = '0 0 0';
            } 
            ?>

            <a-gradient-sky material="shader: gradient; bottomColor: {{ $topColor }}; topColor: 0 0 0;"></a-gradient-sky>

            <a-entity 
                id="floor"
                visible="false"
                geometry="primitive: circle; radius: 100" 
                material="src: url({{ '/' . $theme_dir . '/images/grid.png' }}); repeat: 100 100"  
                rotation="-90 0 0"
                position="0 0 0">
            </a-entity>


            @php
                $filetype = strtolower($content['model'][0]['model']['#model'][0]['#uri']['#filetype']);
            @endphp

            <a-entity 
                id="model-wrapper" 
                data-vrscale="{{ (isset($content['model'][0]['vrscale'])?$content['model'][0]['vrscale']['#value']:'1 1 1') }}"
                data-vrfloorlevel="{{ (isset($content['model'][0]['vrfloorlevel'])?$content['model'][0]['vrfloorlevel']['#value']:0) }}" 
                rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}">


            @if ($filetype == \App\Model3D::FILE_EXTENSION_GLTF)

                <a-entity 
                    id="model" 
                    position="0 0 -100" 
                    visible="false" 
                    gltf-model="#model-gltf">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_GLB)

                <a-entity 
                    id="model" 
                    position="0 0 -100" 
                    visible="false" 
                    gltf-model="#model-glb">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_DAE)

                <a-entity 
                    id="model" 
                    position="0 0 -100" 
                    visible="false" 
                    collada-model="#model-dae">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_OBJ || $filetype == \App\Model3D::FILE_EXTENSION_MTL)

                <a-entity 
                    id="model" 
                    position="0 0 -100" 
                    visible="false" 
                    obj-model="obj: #model-obj; mtl: #model-mtl">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_PLY)

                <a-entity 
                    id="model" 
                    class="ply-model" 
                    rotation="-90 0 0" 
                    position="0 0 -100" 
                    visible="false" 
                    ply-model="src: #plyModel">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>        

            @endif


            @if (isset($content['model'][0]['attach-annotations']))

                @foreach ($content['model'][0]['attach-annotations']['#positions'] as $annotation)

                    @php 
                    $rand = str_random();
                    @endphp

                    <a-sphere 
                        position="{{ $annotation['#position']['#x'] }} {{ $annotation['#position']['#y'] }} {{ $annotation['#position']['#z'] }}" 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] }} {{ $annotation['#rotation']['#z'] }}" 
                        radius="0.2" 
                        material="transparent: true; opacity: 0" 
                        isvr-hotspot="{{ $annotation['#content-id'] . $rand }}">
                        <a-circle
                            class="hotspot" 
                            visible="false" 
                            color="{{ $annotation['#content']['background-color']['#value'] }}" 
                            look-at="#camera"
                            radius="0.2">
                            <a-ring 
                                color="#FFFFFF" 
                                position="0 0 0.01" 
                                radius-inner="0.05" 
                                radius-outer="0.13">
                                <a-animation 
                                    class="hotspot-animation" 
                                    attribute="geometry.radiusOuter" 
                                    to="0.15" 
                                    dur="1300" 
                                    direction="alternate" 
                                    repeat="indefinite" 
                                    easing="linear">
                                </a-animation>
                            </a-ring>
                        </a-circle>
                    </a-sphere>

                    <a-entity 
                        look-at="#camera"
                        scale="2 2 2"
                        position="{{ $annotation['#position']['#x'] }} {{ $annotation['#position']['#y'] }} {{ $annotation['#position']['#z'] }}" 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] }} {{ $annotation['#rotation']['#z'] }}">
                        <!-- border //-->
                        <a-entity 
                            id="annotation-id-{{ $annotation['#content-id'] . $rand }}"
                            class="annotation"
                            isvr-annotation
                            visible="false" 
                            position="1.05 0 0" 
                            geometry="primitive: plane; width: 1.8; height: 0.66" 
                            material="color: #CCCCCC"> 
                            <a-entity 
                                geometry="primitive: plane; width: 1.77; height: 0.6" 
                                position="0 0 0.01" 
                                material="color: {{ $annotation['#content']['background-color']['#value'] }}"> 
                                <!-- text //-->
                                <a-plane width="1.6" height="0.4" position="0 0 0.02" color="{{ $annotation['#content']['background-color']['#value'] }}">
                                    <a-text 
                                        value="{{ (isset($annotation['#content'])?$annotation['#content']['text']['#value']:'') }}" 
                                        color="{{ $annotation['#content']['text-color']['#value'] }}" 
                                        anchor="center" 
                                        width="1.6">
                                    </a-text>
                                </a-plane>
                            </a-entity>
                        </a-entity>
                    </a-entity>

                @endforeach

            @endif

            </a-entity>

        @endif

    </a-scene>

@endsection
