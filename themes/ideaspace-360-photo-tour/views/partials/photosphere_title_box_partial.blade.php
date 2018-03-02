<a-entity
    class="photosphere-title photosphere-title-target-content-id-{{ $photosphere_reference['#content']['title']['#content-id'] }}-content-id-{{ $photosphere['photo-sphere']['#content-id'] }}"
    isvr-photosphere-title-listener
    visible="false"
    position="0 10 -2.1"
    geometry="primitive: plane; width: 1.8; height: 0.36"
    material="color: #FFFFFF; transparent: true; opacity: 0.5">
    <a-entity
        geometry="primitive: plane; width: 1.74; height: 0.30"
        position="0 0 0.01"
        material="color: {{ $photosphere_reference['#content']['background-color']['#value'] }}">
        <a-entity
            geometry="primitive: plane; width: 1.6; height: 0.15"
            position="0 0 0.02"
						material="shader: html; target: #photosphere-title-texture-content-id-{{ $photosphere_reference['#content']['title']['#content-id'] }}; transparent: false; ratio: width">
            <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
            <a-entity
                material="opacity: 0"
                geometry="primitive: plane; width: 1.6; height: 0.15"
                position="0 0 0.03">
            </a-entity>
        </a-entity>
    </a-entity>
</a-entity>
