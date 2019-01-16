<a-rounded
    id="post-link-wrapper-{{ $id }}-{{ $blog_post['post-link-' . $id]['#content-id'] }}"
    position="{{ $position['x'] }} 0 {{ $position['z'] }}"
    look-at="0 0 0"
    color="#FFFFFF"
    width="2"
    height="2"
    top-left-radius="0.06"
    top-right-radius="0.06"
    bottom-left-radius="0.06"
    bottom-right-radius="0.06">
		<a-entity link="href: {{ $blog_post['post-link-' . $id]['#value'] }}; title: @if (isset($blog_post['post-link-text-' . $id])) {{ $blog_post['post-link-text-' . $id]['#value'] }} @endif"></a-entity>
</a-rounded>

