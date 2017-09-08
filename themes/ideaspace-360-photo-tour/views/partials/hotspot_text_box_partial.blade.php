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
    material="color: #FFFFFF; transparent: true; opacity: 0.5">
    <a-entity
        geometry="primitive: plane; width: 1.74; height: 0.6"
        position="0 0 0.01"
        material="color: {{ $annotation['#content']['background-color']['#value'] }}">
        <a-plane width="1.6" height="0.4" position="0 0 0.02" color="{{ $annotation['#content']['background-color']['#value'] }}">
            <a-text
                value="{{ $annotation['#content']['text']['#value'] }}"
                color="{{ $annotation['#content']['text-color']['#value'] }}"
                anchor="center"
                width="1.6">
            </a-text>
        </a-plane>
    </a-entity>
</a-entity>
