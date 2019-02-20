@extends('theme::index')

@section('title', $space_title)

@section('scene')

		<a-scene 
				@if (isset($content['general-settings'][0]['blog-audio']) && $content['general-settings'][0]['blog-audio']['#value'] == 'piano-0') 
						isvr-scene="sound: {{ url($theme_dir . '/assets/audio/262259__shadydave__snowfall-final.mp3') }}"
				@elseif (isset($content['general-settings'][0]['blog-audio']) && $content['general-settings'][0]['blog-audio']['#value'] == 'birds-0') 
						isvr-scene="sound: {{ url($theme_dir . '/assets/audio/birds-0.mp3') }}"
				@else 
						isvr-scene="sound: none"
				@endif 
				light="defaultLightsEnabled: false" 
				@if (isset($content['general-settings'][0]) && $content['general-settings'][0]['antialiasing']['#value'] == 'off') 
						antialias="off" 
				@else 
						antialias="on" 
				@endif>

        <a-assets>
            <audio id="audio-click" src="{{ url($theme_dir . '/assets/audio/ui_click0.ogg') }}" response-type="arraybuffer" crossorigin></audio>

						@if (isset($content['general-settings'][0]['blog-icon']))
								<img id="about-image-texture" src="{{ $content['general-settings'][0]['blog-icon']['blog-icon-resized']['#uri']['#value'] }}" crossorigin>
						@endif
				</a-assets>

				<a-entity id="sound-click" sound="src: #audio-click"></a-entity>

				<a-entity light="type: ambient; color: #FFF"></a-entity>
			
				@php
				/* number of posts to render on page load */
				$max_posts = 3; 
				@endphp

				@if (isset($content['blog-posts']))

						@php
						$meters_between_posts = 10;

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
								id="posts-wrapper" 
								@foreach ($content['blog-posts'] as $blog_post)
										@if ($post_counter < $max_posts)
												animation__nav_up_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 {{ ((($post_counter - 1) * $meters_between_posts)) }} 0; startEvents: nav_up_{{ $blog_post['post-title-north']['#content-id'] }}"
												animation__nav_down_{{ $blog_post['post-title-north']['#content-id'] }}="property: position; dur: 1; easing: linear; to: 0 {{ (($post_counter * $meters_between_posts) + 10) }} 0; startEvents: nav_down_{{ $blog_post['post-title-north']['#content-id'] }}"
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

								@endif
						@endforeach

						</a-entity>

				@endif


				@if (isset($content['general-settings'][0]['blog-icon']) || isset($content['general-settings'][0]['blog-about']))
				<a-entity 
						id="about-link" 
						class="collidable"
						isvr-about-link
						position="1.5 -1.5 0"
						look-at="0 0 0"
						position="0 0 0.001"
						geometry="primitive: plane; width: 8"
						material="shader: html; target: #about-link-texture; transparent: true; ratio: width">
				</a-entity>
				<a-rounded
						id="about-wrapper"
						class="collidable"
						position="{{ ($positions[0]['x'] - 0.001) }} -8 {{ $positions[0]['z'] }}"
						rotation="0 -90 0"
						color="{{ $content['general-settings'][0]['about-blog-background-color']['#value'] }}"
						width="3"
						height="3"
						animation__show_about="property: position; dur: 1000; to: {{ ($positions[0]['x'] - 0.001) }} 0 {{ $positions[0]['z'] }}; startEvents: show-about"
						animation__hide_about="property: position; dur: 1000; to: {{ ($positions[0]['x'] - 0.001) }} -8 {{ $positions[0]['z'] }}; startEvents: hide-about"
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


				<a-entity id="camera-wrapper" @if (!is_null($positions)) look-at="-{{ $positions[0]['x'] }} 0 0" @endif>
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


				<a-entity class="laser-controls-wrapper" @if (!is_null($positions)) look-at="-{{ $positions[0]['x'] }} 0 0" @endif>
				</a-entity>

				<!--a-entity log geometry="primitive: plane" material="color: #111" text="color: lightgreen" position="0 0 -1"></a-entity//-->

		</a-scene>

		<div class="cover">
    </div>

    @if (isset($content['blog-posts']))

		<div id="textures">

				<div id="navigation-arrow-up-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#ffffff;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-up-hover-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#0080e5;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-down-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#ffffff;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-down-hover-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#0080e5;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-up-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-up" style="color:#3a3a3a;font-size:50pt;"></i>
				</div>
				<div id="navigation-arrow-down-inactive-texture" class="navigation-arrow-texture">
						<i class="far fa-arrow-alt-circle-down" style="color:#3a3a3a;font-size:50pt;"></i>
				</div>


				<div id="about-link-texture" class="about-link-texture">
						<i class="far fa-user-circle" style="color:#3a3a3a;font-size:50pt;"></i>
				</div>
				<div id="about-link-hover-texture" class="about-link-texture">
						<i class="far fa-user-circle" style="color:#0080e5;font-size:50pt;"></i>
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
								//$d = new DateTime($blog_post['post-date']['#value']);
								//$date_formatted = $d->format('d F Y');
								$cid = $blog_post['post-title-north']['#content-id'];
								@endphp

								<div id="post-title-texture-{{ $cid }}" data-cid="{{ $cid }}" class="post-title-texture">
										{!! $blog_post['post-title-north']['#value'] !!} 
										<p>&nbsp;</p>
										<!--p><span style="font-family: arial, helvetica, sans-serif; font-size: 20pt; color: #ffffff;">@php /*$date_formatted*/ @endphp</span></p//-->
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

				});
    })();
    </script>

    @endif

@endsection
