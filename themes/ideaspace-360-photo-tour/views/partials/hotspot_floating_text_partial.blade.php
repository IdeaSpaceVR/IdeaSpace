<a-entity
    look-at="#camera"
    data-content-id="{{ $photosphere['hotspot-annotations']['#content-id'] }}"
    data-text-content-id="{{ $annotation['#content-id'] . $rand }}"
    isvr-hotspot-text-listener
    class="hotspot-text hotspot-text-content-id-{{ $annotation['#content-id'] . $rand }}"
    visible="false"
    position="0 1.6 -2.1"
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
        </a-entity>
    </a-entity>
</a-entity>
