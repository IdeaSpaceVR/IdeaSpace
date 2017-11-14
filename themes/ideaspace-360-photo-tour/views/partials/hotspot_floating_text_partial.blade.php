<a-entity
    data-content-id="{{ $photosphere['hotspot-annotations']['#content-id'] }}"
    data-text-content-id="{{ $annotation['#content-id'] . $rand }}"
    isvr-hotspot-text-listener
    class="hotspot-text hotspot-text-content-id-{{ $annotation['#content-id'] . $rand }}"
    visible="false"
    position="0 {{ (-$annotation['#position']['#y']+1.6) }} 0.01"
    rotation="0 0 0"
    geometry="primitive: plane; width: 1.8; height: 0.66"
    material="transparent: true; opacity: 0">
    <a-entity
        geometry="primitive: plane; width: 1.74; height: 0.6"
        position="0 0 0.01"
        material="transparent: true; opacity: 0">
        <a-entity 
            geometry="primitive: plane; width: 1.6; height: 0.4" 
            position="0 0 0.02" 
            material="transparent: true; opacity: 0">
            <a-text
                value="{{ $annotation['#content']['text']['#value'] }}"
                color="{{ $annotation['#content']['text-color']['#value'] }}"
                anchor="center"
                width="1.6">
            </a-text>
            <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
            <a-entity
                material="opacity: 0"
                geometry="primitive: plane; width: 1.6; height: 0.4"
                position="0 0 0.04">
            </a-entity>
        </a-entity>
    </a-entity>
</a-entity>
