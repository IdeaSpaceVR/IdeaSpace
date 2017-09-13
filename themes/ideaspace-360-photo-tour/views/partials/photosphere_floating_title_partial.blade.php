<a-entity
    class="photosphere-title photosphere-title-target-content-id-{{ $photosphere_reference['#content']['title']['#content-id'] }}-content-id-{{ $photosphere['photo-sphere']['#content-id'] }}"
    isvr-photosphere-title-listener
    visible="false"
    position="0 10 -2.1"
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
                value="{{ $photosphere_reference['#content']['title']['#value'] }}"
                color="{{ $photosphere_reference['#content']['text-color']['#value'] }}"
                anchor="center"
                width="1.6">
            </a-text>
        </a-entity>
    </a-entity>
</a-entity>
