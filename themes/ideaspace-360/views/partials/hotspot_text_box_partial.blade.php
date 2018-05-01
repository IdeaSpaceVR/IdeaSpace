<a-entity
    data-content-id="{{ $photosphere['attach-annotations']['#content-id'] }}"
    data-text-content-id="{{ $annotation['#content-id'] . $rand }}"
    isvr-hotspot-text-listener
    class="collidable hotspot-text hotspot-text-content-id-{{ $annotation['#content-id'] . $rand }}"
    visible="false"
    position="0 10 -2.1"
    rotation="0 0 0"
    geometry="primitive: plane; width: 1.8; height: 0.66"
    material="color: #FFFFFF; transparent: true; opacity: 0.5">
    <a-entity
        geometry="primitive: plane; width: 1.74; height: 0.6"
        position="0 0 0.01"
        material="color: {{ $annotation['#content']['background-color']['#value'] }}">
        <a-plane 
            width="1.6" 
            height="0.4" 
            position="0 0 0.02" 
						material="shader: html; target: #annotation-text-texture-content-id-{{ $annotation['#content-id'] }}; transparent: false; ratio: width">
            <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
            <a-entity
                material="opacity: 0"
                geometry="primitive: plane; width: 1.6; height: 0.4"
                position="0 0 0.04">
            </a-entity>
        </a-plane>
    </a-entity>
</a-entity>
