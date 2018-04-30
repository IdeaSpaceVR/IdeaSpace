<a-entity
    class="collidable photosphere-title"
    id="photosphere-title-content-id-{{ $photosphere['title']['#content-id'] }}"
    isvr-photosphere-title-listener
    data-shown="false"
    visible="false"
    position="0 10 -2.1"
    geometry="primitive: plane; width: 1.8; height: 0.66"
    material="color: #FFFFFF; transparent: true; opacity: 0.5">
    <a-entity
        geometry="primitive: plane; width: 1.74; height: 0.6"
        position="0 0 0.01"
        material="color: {{ $photosphere['background-color']['#value'] }}">
        <a-entity
            geometry="primitive: plane; width: 1.6; height: 0.4"
            position="0 0 0.02"
						material="shader: html; target: #photosphere-title-texture-content-id-{{ $photosphere['title']['#content-id'] }}; transparent: false; ratio: width">
            <!-- capture mouseover / mouseout events; enables smooth cursor animation //-->
            <a-entity
                material="opacity: 0"
                geometry="primitive: plane; width: 1.6; height: 0.4"
                position="0 0 0.04">
            </a-entity>
        </a-entity>
    </a-entity>
</a-entity>
