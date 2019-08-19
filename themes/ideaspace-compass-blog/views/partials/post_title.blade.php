<a-entity
		id="post-title-{{ $blog_post['post-title-north']['#content-id'] }}"
		class="post-title"
		data-cid="{{ $blog_post['post-title-north']['#content-id'] }}"
		geometry="primitive: plane; width: 2"
		position="{{ $position['x'] }} 0 {{ $position['z'] }}" 
		rotation="0 -90 0"
		material="shader: html; fps: 1; side: double; target: #post-title-texture-{{ $blog_post['post-title-north']['#content-id'] }}; transparent: true; ratio: width">
		@if ($post_counter > 0)
		<a-entity
				id="navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-up collidable"
				isvr-blog-post-nav-up="id: navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}; cid: {{ $blog_post['post-title-north']['#content-id'] }}"
				geometry="primitive: plane; width: 1; height: 1"
				position="-1.15 0 -0.001" 
				rotation="0 0 0" 
				material="shader: html; fps: 1; side: double; target: #navigation-arrow-up-texture; transparent: true; ratio: width">
		</a-entity>
		@else
		<a-entity
				id="navigation-arrow-up-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-up"
				geometry="primitive: plane; width: 1; height: 1"
				position="-1.15 0 -0.001" 
				rotation="0 0 0" 
				material="shader: html; fps: 1; side: double; target: #navigation-arrow-up-inactive-texture; transparent: true; ratio: width">
		</a-entity>
		@endif
		@if ((count($content['blog-posts']) - 1) > $post_counter)
		<a-entity
				id="navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-down collidable"
				isvr-blog-post-nav-down="id: navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}; cid: {{ $blog_post['post-title-north']['#content-id'] }}; next_page_url: {{ $space_url }}/content/blog-posts?per-page={{ $max_posts }}&page=2; meters: {{ $meters_between_posts }}; posts_per_page: {{ $max_posts }}; total_posts: {{ count($content['blog-posts']) }}; post_counter: {{ $post_counter }}"
				geometry="primitive: plane; width: 1; height: 1"
				position="1.15 0 -0.001" 
				rotation="0 0 0" 
				material="shader: html; fps: 1; side: double; target: #navigation-arrow-down-texture; transparent: true; ratio: width">
		</a-entity>
		@else
		<a-entity
				id="navigation-arrow-down-{{ $blog_post['post-title-north']['#content-id'] }}"
				class="navigation-arrow-down"
				geometry="primitive: plane; width: 1; height: 1"
				position="1.15 0 -0.001" 
				rotation="0 0 0" 
				material="shader: html; fps: 1; side: double; target: #navigation-arrow-down-inactive-texture; transparent: true; ratio: width">
		</a-entity>
		@endif
</a-entity>

