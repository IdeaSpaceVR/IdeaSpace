@php
$rotation_y = 0; /* 10 */
$position_z = 0; /* 0.09 */
@endphp
<a-entity 
		id="{{ $id }}" 
		position="{{ $position }}" 
		visible="{{ $visible }}">

		@if ($count == ($start_counter + 6))

		<!-- center, left //-->
		<a-entity
				position="-1.15 0 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter]['space-link-external']['#value']) && trim($content['space-links'][$start_counter]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center //-->
		<a-entity
				position="0 0 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 1]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter + 1]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
                    class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 1]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 1]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 1]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center, right //-->
		<a-entity
				position="1.15 0 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 2]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 2)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 2]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 2]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 2]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, center //-->
		<a-entity
				position="0 0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 3]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 3)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 3]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 3]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 3]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, center //-->
		<a-entity
				position="0 -0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 4]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 4)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 4]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 4]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 4]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, left //-->
		<a-entity
				position="-1.15 0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 5]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 5)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 5]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 5]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 5]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>

		@elseif ($count == ($start_counter + 7))

		<!-- center, left //-->
		<a-entity
				position="-1.15 0 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter]['space-link-external']['#value']) && trim($content['space-links'][$start_counter]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center //-->
		<a-entity
				position="0 0 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 1]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter + 1]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 1]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 1]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 1]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center, right //-->
		<a-entity
				position="1.15 0 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 2]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 2)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 2]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 2]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 2]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, center //-->
		<a-entity
				position="0 0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 3]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 3)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 3]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 3]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 3]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, center //-->
		<a-entity
				position="0 -0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 4]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 4)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 4]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 4]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 4]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, left //-->
		<a-entity
				position="-1.15 0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 5]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 5)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 5]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 5]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 5]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, right //-->
		<a-entity
				position="1.15 0.65 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 6]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 6)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 6]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 6]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 6]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>

		@elseif ($count == ($start_counter + 8))

		<!-- center, left //-->
		<a-entity
				position="-1.15 0 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter]['space-link-external']['#value']) && trim($content['space-links'][$start_counter]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center //-->
		<a-entity
				position="0 0 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 1]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter + 1]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 1]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 1]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 1]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center, right //-->
		<a-entity
				position="1.15 0 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 2]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 2)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 2]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 2]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 2]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, center //-->
		<a-entity
				position="0 0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 3]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 3)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 3]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 3]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 3]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, center //-->
		<a-entity
				position="0 -0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 4]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 4)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 4]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 4]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 4]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, left //-->
		<a-entity
				position="-1.15 0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 5]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 5)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 5]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 5]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 5]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, right //-->
		<a-entity
				position="1.15 0.65 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 6]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 6)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 6]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 6]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 6]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, left //-->
		<a-entity
				position="-1.15 -0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 7]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 7]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 7)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 7]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 7]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 7]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 7]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 7]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 7]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 7]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>

		@elseif ($count == ($start_counter + 9))

		<!-- center, left //-->
		<a-entity
				position="-1.15 0 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter]['space-link-external']['#value']) && trim($content['space-links'][$start_counter]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center //-->
		<a-entity
				position="0 0 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 1]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][$start_counter + 1]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 1]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 1]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 1]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 1]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- center, right //-->
		<a-entity
				position="1.15 0 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 2]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 2)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 2]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 2]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 2]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 2]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, center //-->
		<a-entity
				position="0 0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 3]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 3)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 3]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 3]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 3]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 3]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, center //-->
		<a-entity
				position="0 -0.65 0"
				rotation="0 0 0">
				 <a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 4]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 4)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 4]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 4]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 4]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 4]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, left //-->
		<a-entity
				position="-1.15 0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 5]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 5)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 5]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 5]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 5]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 5]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st top row, right //-->
		<a-entity
				position="1.15 0.65 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 6]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 6)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 6]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 6]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 6]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 6]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, left //-->
		<a-entity
				position="-1.15 -0.65 {{ $position_z }}"
				rotation="0 {{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 7]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 7]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 7)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 7]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 7]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 7]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 7]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 7]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 7]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 7]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>
		<!-- 1st bottom row, right //-->
		<a-entity
				position="1.15 -0.65 {{ $position_z }}"
				rotation="0 -{{ $rotation_y }} 0">
				<a-rounded
            position="0 0 0.0001"
            width="1.05"
            height="0.55"
            color="{{ $content['space-links'][$start_counter + 8]['space-link-background-color']['#value'] }}"
            top-left-radius="0.04"
            top-right-radius="0.04"
            bottom-left-radius="0.04"
            bottom-right-radius="0.04"
            animation__enter="property: position; dur: 500; to: 0 0 0.1; easing: easeOutElastic; startEvents:isvr_mouseenter"
            animation__leave="property: position; dur: 200; from: 0 0 0.1; to: 0 0 0.0001; startEvents:isvr_mouseleave">
            @if (isset($content['space-links'][$start_counter + 8]['space-link-image']))
            <a-entity
                position="0 0 0.0001"
                geometry="primitive: plane; width: 1; height: 0.5"
                material="shader: flat; src: #space-link-image-texture-{{ $content['space-links'][($start_counter + 8)]['space-link-image']['#content-id'] }}">
            </a-entity>
            @endif
            <a-entity
                geometry="primitive: plane; width: 1; height: 0.5"
                position="0 0 0.0002"
								@if (isset($content['space-links'][$start_counter + 8]['space-link-image']))
                		class="title"
                    visible="true"
                    animation__titlein="property: position; dur: 500; to: 0 0 0.07; easing: easeOutElastic; startEvents:isvr_titlein"
                    animation__titleout="property: position; dur: 500; from: 0 0 0.07; to: 0 0 0.0002; easing: easeOutElastic; startEvents:isvr_titleout"
                @endif
                material="shader: html; target: #space-link-title-texture-cid-{{ $content['space-links'][$start_counter + 8]['space-link-title']['#content-id'] }}; transparent: true; ratio: width">
            </a-entity>
            <a-entity
                class="collidable wrapper"
								@if (isset($content['space-links'][$start_counter + 8]['space-link-reference']['#space-uri']))
                		link="href: {{ $content['space-links'][$start_counter + 8]['space-link-reference']['#space-uri'] }}; visualAspectEnabled: false"
								@elseif (isset($content['space-links'][$start_counter + 8]['space-link-external']['#value']) && trim($content['space-links'][$start_counter + 8]['space-link-external']['#value']) != '')
                		link="href: {{ $content['space-links'][$start_counter + 8]['space-link-external']['#value'] }}; visualAspectEnabled: false"
								@endif
                material="opacity: 0"
                geometry="primitive: plane; width: 1.05; height: 0.55"
                position="0 0 0.0003">
            </a-entity>
        </a-rounded>
		</a-entity>

		@endif

</a-entity>
