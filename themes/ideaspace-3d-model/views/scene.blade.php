@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene 
        isvr-model-center="{{ ((isset($content['model']) && isset($content['model'][0]['camera-offset']))?$content['model'][0]['camera-offset']['#value']:0) }}" 
        @if (isset($content['model'])) 
            isvr-vr-mode="camera_distance_vr: {{ $content['model'][0]['camera-offset-vr']['#value'] }}" 
        @endif>

        @include('theme::assets')

        @if (isset($content['model']))

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

            <a-ring id="teleport-indicator" color="#FFFFFF" radius-inner="0.48" radius-outer="0.5" rotation="-90 0 0" visible="false"></a-ring>

            <!-- debug log //-->
            <!--a-entity position="-2 1 4" rotation="0 30 0">
                <a-entity log geometry="primitive: plane" material="color:#000"></a-entity>
            </a-entity//-->

            <a-entity id="laser-controls" position="0 0 {{ $content['model'][0]['camera-offset-vr']['#value'] }}">
                <a-entity laser-controls="hand: left" line="color: #FFFFFF" class="laser-controls"></a-entity>
                <a-entity laser-controls="hand: right" line="color: #FFFFFF" class="laser-controls"></a-entity>
            </a-entity>

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
                isvr-teleportation="camera_distance_vr: {{ $content['model'][0]['camera-offset-vr']['#value'] }}"
                visible="false"
                geometry="primitive: circle; radius: 100" 
                material="src: url({{ url($theme_dir . '/images/grid.png') }}); repeat: 100 100"  
                rotation="-90 0 0"
                position="0 0 0">
            </a-entity>


            @php
                $filetype = strtolower($content['model'][0]['model']['#model'][0]['#uri']['#filetype']);
            @endphp

            <a-entity 
                id="model-wrapper" 
                data-vrscale="{{ (isset($content['model'][0]['vrscale'])?$content['model'][0]['vrscale']['#value']:'1 1 1') }}"
                data-vr-model-y-axis="{{ (isset($content['model'][0]['vr-model-y-axis'])?$content['model'][0]['vr-model-y-axis']['#value']:0) }}"> 


            @if ($filetype == \App\Model3D::FILE_EXTENSION_GLTF)

                <a-entity 
                    id="model" 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}"
                    position="0 0 -100" 
                    visible="false" 
                    gltf-model="#model-gltf">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_GLB)

                <a-entity 
                    id="model" 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}"
                    position="0 0 -100" 
                    visible="false" 
                    gltf-model="#model-glb">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_DAE)

                <a-entity 
                    id="model" 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}"
                    position="0 0 -100" 
                    visible="false" 
                    collada-model="#model-dae">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_OBJ || $filetype == \App\Model3D::FILE_EXTENSION_MTL)

                <a-entity 
                    id="model" 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}"
                    position="0 0 -100" 
                    visible="false" 
                    obj-model="obj: #model-obj; mtl: #model-mtl">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>

            @elseif ($filetype == \App\Model3D::FILE_EXTENSION_PLY)

                <a-entity 
                    id="model" 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value'] - 90:'-90') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}"
                    class="ply-model" 
                    /*rotation="-90 0 0"*/ 
                    position="0 0 -100" 
                    visible="false" 
                    ply-model="src: #plyModel">
                    <a-animation id="model-animation" attribute="position" begin="isvr-model-intro" to="0 0 0" dur="2000" easing="ease-out"></a-animation>
                </a-entity>        

            @endif


            @if (isset($content['model'][0]['attach-annotations']))

                <a-entity 
                    rotation="{{ (isset($content['model'][0]['rotation-x'])?$content['model'][0]['rotation-x']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-y'])?$content['model'][0]['rotation-y']['#value']:'0') }} {{ (isset($content['model'][0]['rotation-z'])?$content['model'][0]['rotation-z']['#value']:'0') }}">

                @foreach ($content['model'][0]['attach-annotations']['#positions'] as $annotation)

                    @php 
                    $rand = str_random();
                    @endphp

                    <a-sphere 
                        position="{{ $annotation['#position']['#x'] }} {{ $annotation['#position']['#y'] }} {{ $annotation['#position']['#z'] }}" 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] }} {{ $annotation['#rotation']['#z'] }}" 
                        scale="{{ (isset($content['model'][0]['hotspot-scale'])?$content['model'][0]['hotspot-scale']['#value']:'1 1 1') }}"
                        radius="0.1" 
                        material="transparent: true; opacity: 0" 
                        isvr-hotspot="{{ $annotation['#content-id'] . $rand }}">
                        <a-circle
                            class="hotspot" 
                            material="transparent: true; opacity: 0" 
                            visible="false" 
                            color="{{ $annotation['#content']['background-color']['#value'] }}" 
                            look-at="#camera"
                            radius="0.1">
                            <a-ring 
                                color="#FFFFFF" 
                                position="0 0 0.01" 
                                radius-inner="0.04" 
                                radius-outer="0.08">
                                <a-animation 
                                    class="hotspot-animation" 
                                    attribute="geometry.radiusOuter" 
                                    to="0.06" 
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
                        scale="{{ (isset($content['model'][0]['hotspot-scale'])?$content['model'][0]['hotspot-scale']['#value']:'1 1 1') }}"
                        position="{{ $annotation['#position']['#x'] }} {{ $annotation['#position']['#y'] }} {{ $annotation['#position']['#z'] }}" 
                        rotation="{{ $annotation['#rotation']['#x'] }} {{ $annotation['#rotation']['#y'] }} {{ $annotation['#rotation']['#z'] }}">
                        <!-- border //-->
                        <a-entity 
                            id="annotation-id-{{ $annotation['#content-id'] . $rand }}"
                            class="annotation"
                            isvr-annotation
                            visible="false" 
                            position="0.58 0 0" 
                            geometry="primitive: plane; width: 0.9; height: 0.33" 
                            material="color: #CCCCCC"> 
                            <a-entity 
                                geometry="primitive: plane; width: 0.87; height: 0.3" 
                                position="0 0 0.01" 
                                material="color: {{ $annotation['#content']['background-color']['#value'] }}"> 
                                <!-- text //-->
                                <a-plane width="0.77" height="0.2" position="0 0 0.02" color="{{ $annotation['#content']['background-color']['#value'] }}">
                                    <a-text 
                                        value="{{ (isset($annotation['#content'])?$annotation['#content']['text']['#value']:'') }}" 
                                        color="{{ $annotation['#content']['text-color']['#value'] }}" 
                                        anchor="center" 
                                        width="0.77">
                                    </a-text>
                                </a-plane>
                            </a-entity>
                        </a-entity>
                    </a-entity>

                @endforeach

                </a-entity>

            @endif

            </a-entity><!-- model-wrapper //-->

        @endif

    </a-scene>

@endsection
