@extends('theme::index')

@section('title', $space_title)

@section('scene')

		<a-scene debug isvr-scene light="defaultLightsEnabled: false" @if (isset($content['general-settings'][0]) && $content['general-settings'][0]['antialiasing']['#value'] == 'on') antialias="true" @endif>

        <a-assets>
						@if (isset($content['blog-posts']))
								@foreach ($content['blog-posts'] as $blog_post)
										@php
										$cid = $blog_post['post-title-north']['#content-id'];
										@endphp
            				@if ($blog_post['post-display-north-east']['#value'] == 'image')
                    		<img id="post-image-north-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-north-east-texture" src="{{ $blog_post['post-image-north-east']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-east']['#value'] == 'image')
                    		<img id="post-image-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-east-texture" src="{{ $blog_post['post-image-east']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-south-east']['#value'] == 'image')
                    		<img id="post-image-south-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-south-east-texture" src="{{ $blog_post['post-image-south-east']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-south']['#value'] == 'image')
                    		<img id="post-image-south-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-south-texture" src="{{ $blog_post['post-image-south']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-south-west']['#value'] == 'image')
                    		<img id="post-image-south-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-south-west-texture" src="{{ $blog_post['post-image-south-west']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-west']['#value'] == 'image')
                    		<img id="post-image-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-west-texture" src="{{ $blog_post['post-image-west']['#uri']['#value'] }}" crossorigin>
                 		@endif
            				@if ($blog_post['post-display-north-west']['#value'] == 'image')
                    		<img id="post-image-north-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-image-north-west-texture" src="{{ $blog_post['post-image-north-west']['#uri']['#value'] }}" crossorigin>
                 		@endif
								@endforeach
						@endif
            <audio id="audio-click" src="{{ url($theme_dir . '/assets/audio/ui_click0.ogg') }}" response-type="arraybuffer" crossorigin></audio>

				</a-assets>


				<a-entity light="type: ambient; color: #FFF"></a-entity>
			
				@php
				$points = null;
				@endphp

				@if (isset($content['blog-posts']))

						@php
						$meters_between_posts = 10;

						function getCirclePoints($number_points) {
							$p = [];
							$radius = 3;
							$center = ['x' => 0, 'z' => 0];
    					$slice = 2 * pi() / $number_points;
    					for ($i = 0; $i < $number_points; $i++) {
        				$angle = $slice * $i;
        				$newX = intval($center['x'] + $radius * cos($angle));
        				$newZ = intval($center['z'] + $radius * sin($angle));
        				$p[] = ['x' => $newX, 'z' => $newZ];
    					}
							return $p;
						}

						$positions = getCirclePoints(8);
						$post_counter = 0;
						@endphp

						<a-entity 
								position="0 0 0" 
								id="posts-wrapper" 
								@foreach ($content['blog-posts'] as $blog_post)
										animation__nav_up_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 -{{ (($post_counter * $meters_between_posts) - 10) }} 0; startEvents: nav_up_{{ $blog_post['post-title-north']['#content-id'] }}"
										animation__nav_down_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 {{ (($post_counter * $meters_between_posts) + 10) }} 0; startEvents: nav_down_{{ $blog_post['post-title-north']['#content-id'] }}"
										@php
										$post_counter++;
										@endphp
								@endforeach
								class="posts">

						@php
						$post_counter = 0;
						@endphp


						@foreach ($content['blog-posts'] as $blog_post)

								<a-entity 
										position="0 -{{ ($post_counter * $meters_between_posts) }} 0" 
										id="post-{{ $blog_post['post-title-north']['#content-id'] }}" 
										class="post post-{{ $post_counter }} collidable" 
										@if ($post_counter == 0) visible="true" @endif>

										@include('theme::partials.post_title', ['position' => $positions[0], 'post_counter' => $post_counter])

										@if ($blog_post['post-display-north-east']['#value'] != 'none')
												@if ($blog_post['post-display-north-east']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[1], 'id' => 'north-east'])
												@elseif ($blog_post['post-display-north-east']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[1], 'id' => 'north-east'])
												@elseif ($blog_post['post-display-north-east']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[1], 'id' => 'north-east'])
												@endif
										@endif

										@if ($blog_post['post-display-east']['#value'] != 'none')
												@if ($blog_post['post-display-east']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[2], 'id' => 'east'])
												@elseif ($blog_post['post-display-east']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[2], 'id' => 'east'])
												@elseif ($blog_post['post-display-east']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[2], 'id' => 'east'])
												@endif
										@endif

										@if ($blog_post['post-display-south-east']['#value'] != 'none')
												@if ($blog_post['post-display-south-east']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[3], 'id' => 'south-east'])
												@elseif ($blog_post['post-display-south-east']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[3], 'id' => 'south-east'])
												@elseif ($blog_post['post-display-south-east']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[3], 'id' => 'south-east'])
												@endif
										@endif

										@if ($blog_post['post-display-south']['#value'] != 'none')
												@if ($blog_post['post-display-south']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[4], 'id' => 'south'])
												@elseif ($blog_post['post-display-south']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[4], 'id' => 'south'])
												@elseif ($blog_post['post-display-south']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[4], 'id' => 'south'])
												@endif
										@endif

										@if ($blog_post['post-display-south-west']['#value'] != 'none')
												@if ($blog_post['post-display-south-west']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[5], 'id' => 'south-west'])
												@elseif ($blog_post['post-display-south-west']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[5], 'id' => 'south-west'])
												@elseif ($blog_post['post-display-south-west']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[5], 'id' => 'south-west'])
												@endif
										@endif

										@if ($blog_post['post-display-west']['#value'] != 'none')
												@if ($blog_post['post-display-west']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[6], 'id' => 'west'])
												@elseif ($blog_post['post-display-west']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[6], 'id' => 'west'])
												@elseif ($blog_post['post-display-west']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[6], 'id' => 'west'])
												@endif
										@endif

										@if ($blog_post['post-display-north-west']['#value'] != 'none')
												@if ($blog_post['post-display-north-west']['#value'] == 'text')
														@include('theme::partials.layout_text', ['position' => $positions[7], 'id' => 'north-west'])
												@elseif ($blog_post['post-display-north-west']['#value'] == 'image')
														@include('theme::partials.layout_image', ['position' => $positions[7], 'id' => 'north-west'])
												@elseif ($blog_post['post-display-north-west']['#value'] == 'link')
														@include('theme::partials.layout_link', ['position' => $positions[7], 'id' => 'north-west'])
												@endif
										@endif

								</a-entity>

								@php
								$post_counter++;
								@endphp

						@endforeach

						</a-entity>

				@endif


				<a-entity id="camera-wrapper" @if (!is_null($points)) look-at="-{{ $points[0]['x'] }} 0 0" @endif>
						<a-entity camera look-controls>
								<a-entity
                    cursor="fuse: false; rayOrigin: mouse"
                    raycaster="objects: .collidable"
                    id="cursor"
                    position="0 0 -1.9"
                    visible="false">
                </a-entity>
						</a-entity>
				</a-entity>


				<a-entity class="laser-controls-wrapper" @if (!is_null($points)) look-at="-{{ $points[0]['x'] }} 0 0" @endif>
				</a-entity>


<a-entity log geometry="primitive: plane" material="color: #111" text="color: lightgreen" position="0 0 -1"></a-entity>


		</a-scene>

		<div class="cover">
    </div>

    @if (isset($content['blog-posts']))

				<div id="navigation-arrow-up-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#ffffff;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-down-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#ffffff;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-up-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#3a3a3a;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-down-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#3a3a3a;font-size:50pt;"></i>
				</div>

        @foreach ($content['blog-posts'] as $blog_post)
						@php
						//$d = new DateTime($blog_post['post-date']['#value']);
						//$date_formatted = $d->format('d F Y');
						$cid = $blog_post['post-title-north']['#content-id'];
						@endphp

						<div id="post-title-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-title-texture">
								{!! $blog_post['post-title-north']['#value'] !!}
								<p><span style="font-family: arial, helvetica, sans-serif; font-size: 20pt; color: #ffffff;">{!! /*$date_formatted*/ !!}</span></p>
						</div>

            @if ($blog_post['post-display-north-east']['#value'] == 'text')
                <div id="post-text-north-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-north-east-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-north-east']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-east']['#value'] == 'text')
                <div id="post-text-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-display-east-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-east']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-south-east']['#value'] == 'text')
                <div id="post-text-south-east-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-south-east-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-south-east']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-south']['#value'] == 'text')
                <div id="post-text-south-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-south-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-south']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-south-west']['#value'] == 'text')
                <div id="post-text-south-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-south-west-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-south-west']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-west']['#value'] == 'text')
                <div id="post-text-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-west-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-west']['#value'] !!}
                </div>
            @endif

            @if ($blog_post['post-display-north-west']['#value'] == 'text')
                <div id="post-text-north-west-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-text-north-west-texture" style="background-color:#FFFFFF">
                {!! $blog_post['post-text-north-west']['#value'] !!}
                </div>
            @endif
        @endforeach
    @endif

    <script>
    (function() {
        /* DOM is loaded */
// TODO
				var text_north_east_textures = document.querySelectorAll('.post-text-north-east-texture');
				text_north_east_textures.forEach(function(elem) {
						var text_wrapper_0 = document.getElementById('post-text-wrapper-0-' + elem.dataset.cid);
						var height_meters = (elem.offsetHeight * text_wrapper_0.getAttribute('width')) / elem.offsetWidth;
						text_wrapper_0.setAttribute('height', height_meters);
				});

				var text_1_textures = document.querySelectorAll('.post-text-1-texture');
				text_1_textures.forEach(function(elem) {
						var text_wrapper_1 = document.getElementById('post-text-wrapper-1-' + elem.dataset.cid);
						var height_meters = (elem.offsetHeight * text_wrapper_1.getAttribute('width')) / elem.offsetWidth;
						text_wrapper_1.setAttribute('height', height_meters);
				});

				var text_2_textures = document.querySelectorAll('.post-text-2-texture');
				text_2_textures.forEach(function(elem) {
						var text_wrapper_2 = document.getElementById('post-text-wrapper-2-' + elem.dataset.cid);
						var height_meters = (elem.offsetHeight * text_wrapper_2.getAttribute('width')) / elem.offsetWidth;
						text_wrapper_2.setAttribute('height', height_meters);
				});

// TODO after image is loaded, execute func
setTimeout(function() {
				var image_0_textures = document.querySelectorAll('.post-image-0-texture');
				image_0_textures.forEach(function(elem) {
						var image_wrapper_0 = document.getElementById('post-image-wrapper-0-' + elem.dataset.cid);
						var height_meters = (elem.height * image_wrapper_0.getAttribute('width')) / elem.width;
						image_wrapper_0.setAttribute('height', (height_meters + 0.08));
				});
				var image_1_textures = document.querySelectorAll('.post-image-1-texture');
				image_1_textures.forEach(function(elem) {
						var image_wrapper_1 = document.getElementById('post-image-wrapper-1-' + elem.dataset.cid);
						var height_meters = (elem.height * image_wrapper_1.getAttribute('width')) / elem.width;
						image_wrapper_1.setAttribute('height', (height_meters + 0.08));
				});
				var image_2_textures = document.querySelectorAll('.post-image-2-texture');
				image_2_textures.forEach(function(elem) {
						var image_wrapper_2 = document.getElementById('post-image-wrapper-2-' + elem.dataset.cid);
						var height_meters = (elem.height * image_wrapper_2.getAttribute('width')) / elem.width;
						image_wrapper_2.setAttribute('height', (height_meters + 0.08));
				});
				var image_3_textures = document.querySelectorAll('.post-image-3-texture');
				image_3_textures.forEach(function(elem) {
						var image_wrapper_3 = document.getElementById('post-image-wrapper-3-' + elem.dataset.cid);
						var height_meters = (elem.height * image_wrapper_3.getAttribute('width')) / elem.width;
						image_wrapper_3.setAttribute('height', (height_meters + 0.08));
				});
}, 3000);
    })();
    </script>

@endsection
