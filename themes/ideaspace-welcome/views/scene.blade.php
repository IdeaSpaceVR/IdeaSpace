@extends('theme::index')

@section('title', $space_title)

@section('scene')

@php
$menu_block_margin = 10;
$menu_animation_duration = 500;
$menu_block_nav_inactive_color = (isset($content['general-settings'][0]['navigation-inactive-color'])?$content['general-settings'][0]['navigation-inactive-color']['#value']:"#999999");
$menu_block_nav_active_color = (isset($content['general-settings'][0]['navigation-active-color'])?$content['general-settings'][0]['navigation-active-color']['#value']:"#0080E5");
@endphp

		<a-scene isvr-scene @if (isset($content['general-settings'][0]) && $content['general-settings'][0]['antialiasing']['#value'] == 'on') antialias="true" @endif>

				<a-assets>
						@if (isset($content['space-links']))
								@foreach ($content['space-links'] as $space_link)
										@if (isset($space_link['space-link-image']))
												<img src="{{ $space_link['space-link-image']['space-link-image-resized']['#uri']['#value'] }}" id="space-link-image-texture-{{ $space_link['space-link-image']['#content-id'] }}" crossorigin>
										@endif
								@endforeach
						@endif
						<audio id="audio-click" src="{{ url($theme_dir . '/assets/audio/ui_click0.ogg') }}" response-type="arraybuffer" crossorigin></audio>
 				</a-assets>


				<a-entity id="sound-click" sound="src: #audio-click"></a-entity>

			
				@if (isset($content['general-settings'][0]['environment']))

						@if ($content['general-settings'][0]['environment']['#value'] == 'environment-hills')

								<a-entity environment="groundTexture: {{ $content['general-settings'][0]['environment-ground-texture']['#value'] }}; groundYScale: 20; groundColor: {{ $content['general-settings'][0]['environment-ground-color']['#value'] }}"></a-entity>

						@elseif ($content['general-settings'][0]['environment']['#value'] == 'environment-mountains')

								<a-entity environment="groundTexture: {{ $content['general-settings'][0]['environment-ground-texture']['#value'] }}; groundYScale: 40; groundColor: {{ $content['general-settings'][0]['environment-ground-color']['#value'] }}"></a-entity>

						@elseif ($content['general-settings'][0]['environment']['#value'] == 'environment-trees')

								<a-entity environment="groundTexture: {{ $content['general-settings'][0]['environment-ground-texture']['#value'] }}; skyType: atmosphere; preset: forest; groundColor: {{ $content['general-settings'][0]['environment-ground-color']['#value'] }}"></a-entity>

						@elseif ($content['general-settings'][0]['environment']['#value'] == 'environment-arches')

								<a-entity environment="groundTexture: {{ $content['general-settings'][0]['environment-ground-texture']['#value'] }}; preset: arches; groundColor: {{ $content['general-settings'][0]['environment-ground-color']['#value'] }}"></a-entity>

						@elseif ($content['general-settings'][0]['environment']['#value'] == 'environment-tron')

								<a-entity environment="preset: tron; dressing: none; groundColor: {{ $content['general-settings'][0]['environment-ground-color']['#value'] }}"></a-entity>

						@elseif ($content['general-settings'][0]['environment']['#value'] == 'background-color')

								<a-sky color="{{ $content['general-settings'][0]['background-color']['#value'] }}"></a-sky>

						@endif

	
						@if (isset($content['general-settings'][0]['a-painter-painting-url']['#value']))
								<a-entity position="0 0 0" a-painter-loader="src: {{ trim($content['general-settings'][0]['a-painter-painting-url']['#value']) }}"></a-entity>
						@endif


				@endif


				<a-entity id="camera-wrapper" position="0 1.6 0">
            <a-entity
                id="camera"
                camera="far: 10000; fov: 80; near: 0.1"
                look-controls>
                <a-entity
                    cursor="fuse: false; rayOrigin: mouse"
                    raycaster="objects: .collidable"
                    id="cursor"
                    position="0 0 -1.9"
                    geometry="primitive: circle; radius: 0.02;"
                    material="color: #FFFFFF; shader: flat;"
                    visible="false">
                </a-entity>
            </a-entity>
        </a-entity>


				@if (isset($content['space-links']))
				<a-entity id="menu-wrapper" position="0 1.6 -2.3">	


						@if (isset($content['general-settings'][0]['logo']))
						<a-entity
            		position="0 1.4 0"
                scale="0.5 0.5"
										@if ($content['general-settings'][0]['logo-aspect-ratio']['#value'] == '4-3')
												geometry="primitive: plane; width: 1; height: 0.75"
										@elseif ($content['general-settings'][0]['logo-aspect-ratio']['#value'] == '3-4')
												geometry="primitive: plane; width: 0.75; height: 1"
										@elseif ($content['general-settings'][0]['logo-aspect-ratio']['#value'] == '16-9')
												geometry="primitive: plane; width: 1; height: 0.5625"
										@elseif ($content['general-settings'][0]['logo-aspect-ratio']['#value'] == '9-16')
												geometry="primitive: plane; width: 0.5625; height: 1"
										@elseif ($content['general-settings'][0]['logo-aspect-ratio']['#value'] == '1-1')
												geometry="primitive: plane; width: 1; height: 1"
										@endif
										material="shader: flat; src: url({{ $content['general-settings'][0]['logo']['logo-image-resized']['#uri']['#value'] }})">
						</a-entity>
						@elseif (isset($content['general-settings'][0]['space-title']))
						<a-entity
								id="top-title"
								geometry="primitive: plane; width: 4; height: 0.5"
								position="0 1.4 0"
								material="shader: html; target: #space-title-texture; transparent: true; ratio: width">
						</a-entity>
						@endif



						@if (count($content['space-links']) > 0 && count($content['space-links']) <= 5)

								@include('theme::partials.5_items_layout_partial', 
										['id' => 'menu-block-0', 'start_counter' => 0, 'count' => count($content['space-links']), 'position' => '0 0 0', 'visible' => 'true'])



						@elseif (count($content['space-links']) > 5 && count($content['space-links']) <= 9)

								@include('theme::partials.9_items_layout_partial', 
										['id' => 'menu-block-0', 'start_counter' => 0, 'count' => count($content['space-links']), 'position' => '0 0 0', 'visible' => 'true'])



						@elseif (count($content['space-links']) > 9 && count($content['space-links']) <= 14)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.5_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => count($content['space-links']), 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 2])



						@elseif (count($content['space-links']) > 14 && count($content['space-links']) <= 18)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => count($content['space-links']), 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 2])



						@elseif (count($content['space-links']) > 18 && count($content['space-links']) <= 23)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										animation__from_0_to_2="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_0_to_2"
										animation__from_2_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: 0 0 0; startEvents:from_2_to_0"
										animation__from_1_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_1_to_2"
										animation__from_2_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_2_to_1"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => 18, 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.5_items_layout_partial', 
												['id' => 'menu-block-2', 'start_counter' => 18, 'count' => count($content['space-links']), 'position' => ($menu_block_margin * 2) . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 3])



						@elseif (count($content['space-links']) > 23 && count($content['space-links']) <= 27)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										animation__from_0_to_2="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_0_to_2"
										animation__from_2_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: 0 0 0; startEvents:from_2_to_0"
										animation__from_1_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_1_to_2"
										animation__from_2_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_2_to_1"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => 18, 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-2', 'start_counter' => 18, 'count' => count($content['space-links']), 'position' => ($menu_block_margin * 2) . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 3])



						@elseif (count($content['space-links']) > 27 && count($content['space-links']) <= 32)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										animation__from_0_to_2="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_0_to_2"
										animation__from_2_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: 0 0 0; startEvents:from_2_to_0"
										animation__from_0_to_3="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_0_to_3"
										animation__from_3_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: 0 0 0; startEvents:from_3_to_0"
										animation__from_1_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_1_to_2"
										animation__from_2_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_2_to_1"
										animation__from_1_to_3="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_1_to_3"
										animation__from_3_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_3_to_1"
										animation__from_2_to_3="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_2_to_3"
										animation__from_3_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_3_to_2"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => 18, 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-2', 'start_counter' => 18, 'count' => 27, 'position' => ($menu_block_margin * 2) . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.5_items_layout_partial', 
												['id' => 'menu-block-3', 'start_counter' => 27, 'count' => count($content['space-links']), 'position' => ($menu_block_margin * 3) . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 4])



						@elseif (count($content['space-links']) > 32 && count($content['space-links']) <= 36)

								<a-entity
										animation__from_0_to_1="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_0_to_1"
										animation__from_1_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: 0 0 0; startEvents:from_1_to_0"
										animation__from_0_to_2="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_0_to_2"
										animation__from_2_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: 0 0 0; startEvents:from_2_to_0"
										animation__from_0_to_3="property: position; dur: {{ $menu_animation_duration }}; from: 0 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_0_to_3"
										animation__from_3_to_0="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: 0 0 0; startEvents:from_3_to_0"
										animation__from_1_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_1_to_2"
										animation__from_2_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_2_to_1"
										animation__from_1_to_3="property: position; dur: {{ $menu_animation_duration }}; from: -{{ $menu_block_margin }} 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_1_to_3"
										animation__from_3_to_1="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: -{{ $menu_block_margin }} 0 0; startEvents:from_3_to_1"
										animation__from_2_to_3="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 2) }} 0 0; to: -{{ ($menu_block_margin * 3) }} 0 0; startEvents:from_2_to_3"
										animation__from_3_to_2="property: position; dur: {{ $menu_animation_duration }}; from: -{{ ($menu_block_margin * 3) }} 0 0; to: -{{ ($menu_block_margin * 2) }} 0 0; startEvents:from_3_to_2"
										position="0 0 0"
										id="item-wrapper">

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-0', 'start_counter' => 0, 'count' => 9, 'position' => '0 0 0', 'visible' => 'true'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-1', 'start_counter' => 9, 'count' => 18, 'position' => $menu_block_margin . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-2', 'start_counter' => 18, 'count' => 27, 'position' => ($menu_block_margin * 2) . ' 0 0', 'visible' => 'false'])

										@include('theme::partials.9_items_layout_partial', 
												['id' => 'menu-block-3', 'start_counter' => 27, 'count' => count($content['space-links']), 'position' => ($menu_block_margin * 3) . ' 0 0', 'visible' => 'false'])

								</a-entity><!-- animation-wrapper //-->

								@include('theme::partials.menu_navigation_element', ['number_elements' => 4])

						@endif

				</a-entity>	
				@endif

    </a-scene>


		<div class="cover">
    </div>


		@if (isset($content['general-settings'][0]['space-title']))
    <div id="space-title-texture"> 
    {!! $content['general-settings'][0]['space-title']['#value'] !!}
    </div>
		@endif


    @if (isset($content['space-links']))
        @foreach ($content['space-links'] as $space_link)
        		<div id="space-link-title-texture-cid-{{ $space_link['space-link-title']['#content-id'] }}" class="space-link-title-texture">
            {!! $space_link['space-link-title']['#value'] !!}
        		</div>
        @endforeach
    @endif


    <script>
    (function() {
        /* DOM is loaded */
    })();
    </script>

@endsection
