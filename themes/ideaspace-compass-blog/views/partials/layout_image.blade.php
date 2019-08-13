@if (isset($blog_post['post-image-' . $id]['#uri']['#value']))
<a-rounded
    id="post-image-wrapper-{{ $id }}-{{ $blog_post['post-image-' . $id]['#content-id'] }}"
    position="{{ $position['x'] }} 0 {{ $position['z'] }}"
		rotation="0 {{ $rotation_y }} 0"
    color="{{ $blog_post['post-text-image-background-color-' . $id]['#value'] }}"
    width="2"
    height="3"
    top-left-radius="0.06"
    top-right-radius="0.06"
    bottom-left-radius="0.06"
    bottom-right-radius="0.06">
    @if ($blog_post['post-image-' . $id]['#mime-type'] == 'image/gif')
    <a-image
        id="post-image-{{ $id }}-{{ $blog_post['post-image-' . $id]['#content-id'] }}"
        position="0 0 0.001"
        shader="gif"
        src="#post-image-{{ $id }}-texture-{{ $blog_post['post-image-' . $id]['#content-id'] }}"
        @if ($blog_post['post-image-' . $id]['#width'] > $blog_post['post-image-' . $id]['#height'])
        width="1.8"
        height="0.9">
        @elseif ($blog_post['post-image-' . $id]['#width'] < $blog_post['post-image-' . $id]['#height'])
        width="1.8"
        height="3.6">
        @else
        width="1.8"
        height="1.8">
        @endif
    </a-image>
    @else
		<a-image
        id="post-image-{{ $id }}-{{ $blog_post['post-image-' . $id]['#content-id'] }}"
        position="0 0 0.001"
        src="#post-image-{{ $id }}-texture-{{ $blog_post['post-image-' . $id]['#content-id'] }}"
        @if ($blog_post['post-image-' . $id]['#width'] > $blog_post['post-image-' . $id]['#height'])
        width="1.8"
        height="0.9">
        @elseif ($blog_post['post-image-' . $id]['#width'] < $blog_post['post-image-' . $id]['#height'])
        width="1.8"
        height="3.6">
        @else
        width="1.8"
        height="1.8">
        @endif
    </a-image>
    @endif
</a-rounded>
@endif

