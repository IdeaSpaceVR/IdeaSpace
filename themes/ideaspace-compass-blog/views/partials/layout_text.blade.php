<a-rounded
    id="post-text-wrapper-{{ $id }}-{{ $blog_post['post-text-' . $id]['#content-id'] }}"
    position="{{ $position['x'] }} 0 {{ $position['z'] }}"
    color="{{ $blog_post['post-text-image-background-color-' . $id]['#value'] }}"
    look-at="0 0 0"
    width="2"
    height="3"
    top-left-radius="0.06"
    top-right-radius="0.06"
    bottom-left-radius="0.06"
    bottom-right-radius="0.06">
    <a-entity
        id="post-text-{{ $id }}-{{ $blog_post['post-text-' . $id]['#content-id'] }}"
        geometry="primitive: plane; width: 1.8"
        position="0 0 0.001"
        material="shader: html; target: #post-text-{{ $id }}-texture-{{ $blog_post['post-text-' . $id]['#content-id'] }}; transparent: true; ratio: width">
    </a-entity>
</a-rounded>
