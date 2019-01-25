
<a-entity
		id="post-title-{{ $blog_post['post-title-north']['#content-id'] }}"
		data-cid="{{ $blog_post['post-title-north']['#content-id'] }}"
		geometry="primitive: plane; width: 2"
		position="{{ $position['x'] }} 0 {{ $position['z'] }}" 
		look-at="0 0 0"
		material="shader: html; target: #post-title-texture-{{ $blog_post['post-title-north']['#content-id'] }}; transparent: true; ratio: width">
		@if ($post_counter > 0)
		<a-entity
				id="navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-up collidable"
				isvr-navigation-up="cid: {{ $blog_post['post-title-north']['#content-id'] }}"
				isvr-blog-post-nav-up="id: navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}"
				geometry="primitive: plane; width: 2; height: 2"
				position="-1.15 0 -0.001" 
				material="shader: html; target: #navigation-arrow-up-texture; transparent: true; ratio: width">
		</a-entity>
		@else
		<a-entity
				id="navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-up"
				geometry="primitive: plane; width: 2; height: 2"
				position="-1.15 0 -0.001" 
				material="shader: html; target: #navigation-arrow-up-inactive-texture; transparent: true; ratio: width">
		</a-entity>
		@endif
		@if (sizeof($content['blog-posts']) > $post_counter)
		<a-entity
				id="navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-down collidable"
				isvr-navigation-down="cid: {{ $blog_post['post-title-north']['#content-id'] }}"
				isvr-blog-post-nav-down="id: navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}"
				geometry="primitive: plane; width: 2; height: 2"
				position="1.15 0 -0.001" 
				material="shader: html; target: #navigation-arrow-down-texture; transparent: true; ratio: width">
		</a-entity>
		@else
		<a-entity
				id="navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-down"
				geometry="primitive: plane; width: 2; height: 2"
				position="1.15 0 -0.001" 
				material="shader: html; target: #navigation-arrow-down-inactive-texture; transparent: true; ratio: width">
		</a-entity>
		@endif
</a-entity>

