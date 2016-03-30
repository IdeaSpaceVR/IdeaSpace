@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene>

    @include('theme::assets')

        <a-entity id="camera-wrapper" position="0 1.8 5">
            <a-entity
                id="camera" 
                camera="far: 10000; fov: 80; near: 0.5;"
                look-controls="enabled: true">
                <a-entity
                    cursor="fuse: false; maxDistance: 10; timeout: 3000;"
                    id="cursor"
                    position="0 0 -2"
                    material="color:#FFFFFF"
                    geometry="primitive: sphere; radius: 0.03;"
                    visible="false">
                </a-entity>
            </a-entity>
            <a-animation attribute="position" begin="in" to="0 1.8 0" easing="linear" dur="10000"></a-animation>
            <a-animation attribute="position" begin="out" to="0 1.8 5" easing="linear" dur="10000"></a-animation>
        </a-entity>

        <a-entity id="earth-entity" geometry="primitive: sphere; radius: 2" material="side: double; color: #FFFFFF; src: #earth" position="0 1.8 0">
            <a-animation attribute="rotation" to="0 359 0" easing="linear" begin="0" dur="40000" repeat="indefinite"></a-animation>
        </a-entity>
        <a-entity id="text-entity" text="size: 0.08; height: 0.01; text: {{ $content['my_text']['data'][0] }}" material="color: #FFFFFF" position="-0.4 1.8 -1"></a-entity>
        <a-entity geometry="primitive: sphere; radius: 90" material="shader: flat; color: #FFFFFF; src: #stars" scale="-1 1 1"></a-entity>

    </a-scene>

    <script>
    document.querySelector('#earth-entity').addEventListener('stateadded',  function(evt) {

        if (evt.detail.state == 'hovered') {
            document.querySelector('#cursor').setAttribute('visible', true); 
        } 
    });

    document.querySelector('#earth-entity').addEventListener('stateremoved',  function(evt) {

        if (evt.detail.state == 'hovered') {
            document.querySelector('#cursor').setAttribute('visible', false);
        }
    });

    document.querySelector('#earth-entity').addEventListener('click', function() {

        if (document.querySelector('#camera-wrapper').getAttribute('position').z === 5) {
            document.querySelector('#cursor').setAttribute('visible', false);
            document.querySelector('#camera').emit('in');
        } else if (document.querySelector('#camera-wrapper').getAttribute('position').z === 0) {
            document.querySelector('#camera').emit('out');
        }
    });
    </script>
@endsection
