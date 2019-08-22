@extends('theme::index-painter')

@section('title', $space_title)

@section('scene')

		<a-scene 
				@if (isset($content['general-settings'][0]['blog-audio']) && $content['general-settings'][0]['blog-audio']['#value'] == 'piano-0') 
						isvr-scene-painter="sound: {{ url($theme_dir . '/assets/audio/262259__shadydave__snowfall-final.mp3') }}"
				@elseif (isset($content['general-settings'][0]['blog-audio']) && $content['general-settings'][0]['blog-audio']['#value'] == 'birds-0') 
						isvr-scene-painter="sound: {{ url($theme_dir . '/assets/audio/birds-0.mp3') }}"
				@else 
						isvr-scene-painter="sound: none"
				@endif 
				light="defaultLightsEnabled: false" 
				background="color: #000000" 
				loading-screen="dotsColor: #FFFFFF; backgroundColor: #000000"
				@if (isset($content['general-settings'][0]) && $content['general-settings'][0]['antialiasing']['#value'] == 'off') 
						renderer="antialias: false" 
				@else 
						renderer="antialias: true" 
				@endif>

        <a-assets>
            <audio id="audio-click" src="{{ url($theme_dir . '/assets/audio/ui_click0.ogg') }}" response-type="arraybuffer" crossorigin></audio>

						@if (isset($content['general-settings'][0]['blog-icon']))
								<img id="about-image-texture" src="{{ $content['general-settings'][0]['blog-icon']['blog-icon-resized']['#uri']['#value'] }}" crossorigin>
						@endif

						<img id="windrose" width="512" height="512" src="{{ url($theme_dir . '/assets/images/windrose.svg') }}" crossorigin>


						@php painter_assets(); @endphp


				</a-assets>


				@php painter_entities(); @endphp


				<a-entity id="sound-click" sound="src: #audio-click"></a-entity>

				@if (isset($content['general-settings'][0]['sky']) && $content['general-settings'][0]['sky']['#value'] == 'stars') 
						<a-entity star-system="count: 1000; color: @if (isset($content['general-settings'][0]['sky-stars-color'])) {{ $content['general-settings'][0]['sky-stars-color']['#value'] }} @else #000000 @endif"></a-entity>
				@endif

				<a-entity light="type: ambient; color: #FFFFFF"></a-entity>
			

				@php
				/* number of posts to render on page load */
				$max_posts = 3; 
				@endphp

				@if (isset($content['blog-posts']))

						@php
						$meters_between_posts = 20; 

						function getCirclePoints($number_points, $radius) {
							$p = [];
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

						$positions = getCirclePoints(8, 3);
						$post_counter = 0;
						@endphp

						<a-entity 
								position="0 0 0" 
								rotation="0 90 0" 
								id="posts-wrapper" 
								@foreach ($content['blog-posts'] as $blog_post)
										@if ($post_counter < $max_posts)
												animation__nav_up_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 {{ ((($post_counter - 1) * $meters_between_posts)) }} 0; startEvents: nav_up_{{ $blog_post['post-title-north']['#content-id'] }}"
												animation__nav_down_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 {{ (($post_counter * $meters_between_posts) + $meters_between_posts) }} 0; startEvents: nav_down_{{ $blog_post['post-title-north']['#content-id'] }}"
												@php
												$post_counter++;
												@endphp
										@endif
								@endforeach
								class="posts">

						@php
						$post_counter = 0;
						@endphp


						@foreach ($content['blog-posts'] as $blog_post)
								@if ($post_counter < $max_posts)

										<a-entity 
												position="0 -{{ ($post_counter * $meters_between_posts) }} 0" 
												id="post-{{ $blog_post['post-title-north']['#content-id'] }}" 
												class="post post-{{ $post_counter }}" 
												@if ($post_counter == 0) visible="true" @endif>

												@include('theme::partials.post_title', ['position' => $positions[0], 'post_counter' => $post_counter])

												@if (isset($blog_post['post-painter']['#value']))
														@foreach ($blog_post['post-painter']['#value'] as $painting)
																<a-entity class="painting" a-painter-loader="src: {{ url($painting) }}"></a-entity>
														@endforeach
												@endif

												@if ($blog_post['post-display-north-east']['#value'] != 'none')
														@if ($blog_post['post-display-north-east']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[1], 'rotation_y' => -135, 'id' => 'north-east', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-north-east']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[1], 'rotation_y' => -135, 'id' => 'north-east'])
														@elseif ($blog_post['post-display-north-east']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[1], 'rotation_y' => -135, 'id' => 'north-east', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-east']['#value'] != 'none')
														@if ($blog_post['post-display-east']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[2], 'rotation_y' => 180, 'id' => 'east', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-east']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[2], 'rotation_y' => 180, 'id' => 'east'])
														@elseif ($blog_post['post-display-east']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[2], 'rotation_y' => 180, 'id' => 'east', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-south-east']['#value'] != 'none')
														@if ($blog_post['post-display-south-east']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[3], 'rotation_y' => 135, 'id' => 'south-east', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-south-east']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[3], 'rotation_y' => 135, 'id' => 'south-east'])
														@elseif ($blog_post['post-display-south-east']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[3], 'rotation_y' => 135, 'id' => 'south-east', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-south']['#value'] != 'none')
														@if ($blog_post['post-display-south']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[4], 'rotation_y' => 90, 'id' => 'south', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-south']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[4], 'rotation_y' => 90, 'id' => 'south'])
														@elseif ($blog_post['post-display-south']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[4], 'rotation_y' => 90, 'id' => 'south', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-south-west']['#value'] != 'none')
														@if ($blog_post['post-display-south-west']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[5], 'rotation_y' => 45, 'id' => 'south-west', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-south-west']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[5], 'rotation_y' => 45, 'id' => 'south-west'])
														@elseif ($blog_post['post-display-south-west']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[5], 'rotation_y' => 45, 'id' => 'south-west', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-west']['#value'] != 'none')
														@if ($blog_post['post-display-west']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[6], 'rotation_y' => 0, 'id' => 'west', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-west']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[6], 'rotation_y' => 0, 'id' => 'west'])
														@elseif ($blog_post['post-display-west']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[6], 'rotation_y' => 0, 'id' => 'west', 'field_painter' => 'true'])
														@endif
												@endif

												@if ($blog_post['post-display-north-west']['#value'] != 'none')
														@if ($blog_post['post-display-north-west']['#value'] == 'text')
																@include('theme::partials.layout_text', ['position' => $positions[7], 'rotation_y' => -45, 'id' => 'north-west', 'field_painter' => 'true'])
														@elseif ($blog_post['post-display-north-west']['#value'] == 'image')
																@include('theme::partials.layout_image', ['position' => $positions[7], 'rotation_y' => -45, 'id' => 'north-west'])
														@elseif ($blog_post['post-display-north-west']['#value'] == 'link')
																@include('theme::partials.layout_link', ['position' => $positions[7], 'rotation_y' => -45, 'id' => 'north-west', 'field_painter' => 'true'])
														@endif
												@endif

										</a-entity>

										@php
										$post_counter++;
										@endphp

								@endif
						@endforeach

						</a-entity>

				@endif

				
				<a-entity 
						id="dashboard-wrapper"
						position="0 0 0" 
						rotation="0 90 0"> 

						<a-circle
								id="windrose-wrapper" 
								position="0 -3 0" 
								segments="64" 
								radius="1.2" 
								color="@if (isset($content['general-settings'][0]['about-blog-background-color'])) {{ $content['general-settings'][0]['about-blog-background-color']['#value'] }} @else #FFFFFF @endif" 
								rotation="-90 0 0">	
								<a-image 
										src="#windrose" 
										width="2" 
										height="2" 
										rotation="0 0 -90" 
										position="0 0 0.001">
								</a-image>
						</a-circle>	


						<a-entity 
								id="blog-post-rotate-left" 
								class="blog-post-rotate collidable"
								visible="false"
								isvr-blog-post-rotation="dir: left"
								position="1.5 -1 -0.5"
								rotation="-30 -90 0"
								geometry="primitive: plane; width: 0.5"
								material="shader: html; target: #blog-post-rotate-left-texture; transparent: true; ratio: width">
						</a-entity>
						<a-entity 
								id="blog-post-rotate-right" 
								class="blog-post-rotate collidable"
								visible="false"
								isvr-blog-post-rotation="dir: right"
								position="1.5 -1 0.5"
								rotation="-30 -90 0"
								geometry="primitive: plane; width: 0.5"
								material="shader: html; target: #blog-post-rotate-right-texture; transparent: true; ratio: width">
						</a-entity>
						@if (isset($content['general-settings'][0]['blog-icon']) || isset($content['general-settings'][0]['blog-about']))
						<a-entity 
								id="about-link" 
								class="collidable"
								isvr-about-link
								position="1.5 -1 0"
								rotation="-30 -90 0"
								geometry="primitive: plane; width: 0.5"
								material="shader: html; target: #about-link-texture; transparent: true; ratio: width">
						</a-entity>
						<a-rounded
								id="about-wrapper"
								class="collidable"
								position="{{ ($positions[0]['x'] - 0.001) }} -10 {{ $positions[0]['z'] }}"
								rotation="0 -90 0"
								color="{{ $content['general-settings'][0]['about-blog-background-color']['#value'] }}"
								width="3"
								height="3"
								animation__show_about="property: position; dur: 1000; easing: easeInOutElastic; to: {{ ($positions[0]['x'] - 0.001) }} 0 {{ $positions[0]['z'] }}; startEvents: show-about"
								animation__hide_about="property: position; dur: 1000; to: {{ ($positions[0]['x'] - 0.001) }} -10 {{ $positions[0]['z'] }}; startEvents: hide-about"
								visible="false"
								top-left-radius="0.06"
								top-right-radius="0.06"
								bottom-left-radius="0.06"
								bottom-right-radius="0.06">
								<a-circle id="about-image" radius="0.3" src="#about-image-texture"></a-circle>
								<a-entity
										id="about"
										geometry="primitive: plane; width: 2.8"
										position="0 0 0.001"
										material="shader: html; target: #about-texture; transparent: true; ratio: width">
								</a-entity>
						</a-rounded>
						@endif


						<a-entity 
								id="ideaspacevr" 
								class="collidable"
								position="1.5 -1.25 0"
								rotation="-30 -90 0"
								geometry="primitive: plane; width: 1.2"
								material="shader: html; target: #ideaspacevr-texture; transparent: true; ratio: width">
						</a-entity>

				</a-entity>




				<!--a-entity log geometry="primitive: plane" material="color: #111" text="color: lightgreen" position="0 0 -1.5"></a-entity//-->

		</a-scene>

		<div class="cover">
    </div>

    @if (isset($content['blog-posts']))

		<div id="textures">

				<div id="navigation-arrow-up-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#ffffff;font-size:150pt;"></i>
				</div>
				<div id="navigation-arrow-up-hover-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#0080e5;font-size:150pt;"></i>
				</div>
				<div id="navigation-arrow-down-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#ffffff;font-size:150pt;"></i>
				</div>
				<div id="navigation-arrow-down-hover-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#0080e5;font-size:150pt;"></i>
				</div>
				<div id="navigation-arrow-up-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#3a3a3a;font-size:150pt;"></i>
				</div>
				<div id="navigation-arrow-down-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#3a3a3a;font-size:150pt;"></i>
				</div>


				<div id="blog-post-rotate-left-texture" class="blog-post-rotate-texture">
						<i class="far fa-arrow-alt-circle-left" style="color:#FFFFFF;font-size:150pt;"></i>
				</div>
				<div id="blog-post-rotate-left-hover-texture" class="blog-post-rotate-texture">
						<i class="far fa-arrow-alt-circle-left" style="color:#0080e5;font-size:150pt;"></i>
				</div>
				<div id="blog-post-rotate-right-texture" class="blog-post-rotate-texture">
						<i class="far fa-arrow-alt-circle-right" style="color:#FFFFFF;font-size:150pt;"></i>
				</div>
				<div id="blog-post-rotate-right-hover-texture" class="blog-post-rotate-texture">
						<i class="far fa-arrow-alt-circle-right" style="color:#0080e5;font-size:150pt;"></i>
				</div>


				<div id="about-link-texture" class="about-link-texture">
						<i class="far fa-user-circle" style="color:#FFFFFF;font-size:150pt;"></i>
				</div>
				<div id="about-link-hover-texture" class="about-link-texture">
						<i class="far fa-user-circle" style="color:#0080e5;font-size:150pt;"></i>
				</div>


				<div id="ideaspacevr-texture">
				{{ $space_title }}
				</div>


				@if (isset($content['general-settings'][0]['blog-icon']) || isset($content['general-settings'][0]['blog-about']))
						<div id="about-texture">
								@if (isset($content['general-settings'][0]['blog-about']))
										<div style="margin-left:17px;padding-top:80px">
												{!! $content['general-settings'][0]['blog-about']['#value'] !!}
										</div>
								@endif
						</div>
				@endif


				@php
				$post_counter = 0;
				@endphp
        @foreach ($content['blog-posts'] as $blog_post)
						@if ($post_counter < $max_posts)
								@php
								$cid = $blog_post['post-title-north']['#content-id'];
								@endphp

								<div id="post-title-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-title-texture">
										{!! $blog_post['post-title-north']['#value'] !!} 
										<p>&nbsp;</p>
								</div>

								@include('theme::partials.text_image_link_texture', ['id' => 'north-east', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'east', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'south-east', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'south', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'south-west', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'west', 'cid' => $cid])
								@include('theme::partials.text_image_link_texture', ['id' => 'north-west', 'cid' => $cid])

								@php
								$post_counter++;
								@endphp

        		@endif
        @endforeach

		</div><!-- textures //-->

    <script>
		/* global */
		var positions = {!! json_encode($positions) !!};
		var prev_post_counter = 1;
		var posts_loaded = [];

    (function() {
        /* DOM is loaded */
				ready(function() {
        		/* DOM content is loaded */
						@include('theme::partials.texture_rerender_script')

						@include('theme::partials.wrapper_border_script', ['id' => 'north-east'])
						@include('theme::partials.wrapper_border_script', ['id' => 'east'])
						@include('theme::partials.wrapper_border_script', ['id' => 'south-east'])
						@include('theme::partials.wrapper_border_script', ['id' => 'south'])
						@include('theme::partials.wrapper_border_script', ['id' => 'south-west'])
						@include('theme::partials.wrapper_border_script', ['id' => 'west'])
						@include('theme::partials.wrapper_border_script', ['id' => 'north-west'])

						@if (isset($content['general-settings'][0]['blog-icon']) || isset($content['general-settings'][0]['blog-about']))
								@include('theme::partials.wrapper_about_border_script')
						@endif

						/* workaround for iframe */
						var t = setTimeout(function() {
								var text_elems = document.querySelectorAll('.post-text');						
								for (var j = 0; j < text_elems.length; j++) {
										text_elems[j].components.material.shader.__render();						
								}
								var link_elems = document.querySelectorAll('.post-link');						
								for (var j = 0; j < link_elems.length; j++) {
										link_elems[j].components.material.shader.__render();						
								}
								var rotate_elems = document.querySelectorAll('.blog-post-rotate');
								for (var j = 0; j < rotate_elems.length; j++) {
										rotate_elems[j].components.material.shader.__render();						
								}
								var title = document.querySelectorAll('.post-title');
								for (var j = 0; j < title.length; j++) {
										title[j].components.material.shader.__render();						
								}
								var nav_arrow_up = document.querySelectorAll('.navigation-arrow-up');
								for (var j = 0; j < nav_arrow_up.length; j++) {
										nav_arrow_up[j].components.material.shader.__render();						
								}
								var nav_arrow_down = document.querySelectorAll('.navigation-arrow-down');
								for (var j = 0; j < nav_arrow_down.length; j++) {
										nav_arrow_down[j].components.material.shader.__render();						
								}
								var about_elem = document.querySelector('#about-link');
								about_elem.components.material.shader.__render();						
								var about_elem2 = document.querySelector('#about');
								about_elem2.components.material.shader.__render();						
								var isvr_elem = document.querySelector('#ideaspacevr');
								isvr_elem.components.material.shader.__render();						

								clearTimeout(t);
						}, 5000);
				});
    })();
    </script>

    @endif

@endsection
