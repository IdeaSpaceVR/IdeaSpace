@if ($blog_post['post-display-' . $id]['#value'] == 'text')

		<div id="post-text-{{ $id }}-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-{{ $id }}-texture post-text-texture" style="background-color:{{ $blog_post['post-text-image-background-color-' . $id]['#value'] }}">
		{!! $blog_post['post-text-' . $id]['#value'] !!}
		</div>

@elseif ($blog_post['post-display-' . $id]['#value'] == 'link')

		<div id="post-link-{{ $id }}-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-link-{{ $id }}-texture post-link-texture" style="background-color:{{ $blog_post['post-text-image-background-color-' . $id]['#value'] }}">
		@if (isset($blog_post['post-link-text-' . $id]['#value']) && trim($blog_post['post-link-text-' . $id]['#value']) != '')
				{!! $blog_post['post-link-text-' . $id]['#value'] !!}
		@elseif (isset($blog_post['post-link-' . $id]['#value']) && trim($blog_post['post-link-' . $id]['#value']) != '')
				{!! $blog_post['post-link-' . $id]['#value'] !!}
		@endif
		</div>
		<div id="post-link-{{ $id }}-texture-{{ $cid }}-active" data-cid="{{ $cid }}" class="post-link-{{ $id }}-texture post-link-texture" style="color:#0080e5; background-color:{{ $blog_post['post-text-image-background-color-' . $id]['#value'] }}">
		@if (isset($blog_post['post-link-text-' . $id]['#value']) && trim($blog_post['post-link-text-' . $id]['#value']) != '')
				{!! $blog_post['post-link-text-' . $id]['#value'] !!}
		@elseif (isset($blog_post['post-link-' . $id]['#value']) && trim($blog_post['post-link-' . $id]['#value']) != '')
				{!! $blog_post['post-link-' . $id]['#value'] !!}
		@endif
		</div>

@elseif ($blog_post['post-display-' . $id]['#value'] == 'image' && isset($blog_post['post-image-' . $id]['#uri']['#value']))

		<img id="post-image-{{ $id }}-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-{{ $id }}-texture post-image-texture" src="{{ $blog_post['post-image-' . $id]['#uri']['#value'] }}" crossorigin>

@endif
