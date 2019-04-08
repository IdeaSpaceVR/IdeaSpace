@extends('theme::index')

@section('title', $space_title)

@section('scene')

    <a-scene background="color: #000000" loading-screen="dotsColor: #FFFFFF; backgroundColor: #000000">

				<a-assets>
						@foreach ($content['images'] as $image)
						<img id="image-cid-{{ $image['image']['#content-id'] }}" src="{{ $image['image']['#uri']['#value'] }}" crossorigin="anonymous">
						@endforeach
				</a-assets>

				<a-entity star-system="count: 1000; color: #FFFFFF"></a-entity>

				<a-entity 
						id="leftHand" 
						isvr-image-trigger
						windows-motion-controls="hand: left"
						vive-controls="hand: left"
						oculus-touch-controls="hand: left"
						gearvr-controls="hand: left" 
						daydream-controls="hand: left"
						vive-focus-controls="hand: left"
						oculus-go-controls="hand: left">
				</a-entity>
				<a-entity 
						id="rightHand" 
						isvr-image-trigger
						windows-motion-controls="hand: right"
						vive-controls="hand: right"
						oculus-touch-controls="hand: right"
						gearvr-controls="hand: right" 
						daydream-controls="hand: right"
						vive-focus-controls="hand: right"
						oculus-go-controls="hand: right">
				</a-entity>

				<a-entity id="intro"> 
						<a-entity
								id="title"
								position="0 2 -3"
								geometry="primitive: plane; width: 6"
								material="shader: html; target: #title-texture; transparent: true; ratio: width">
						</a-entity>
						<a-entity
								id="description"
								position="0 1.5 -3"
								geometry="primitive: plane; width: 2.8"
								material="shader: html; target: #description-texture; transparent: true; ratio: width">
						</a-entity>
        </a-entity>

				@php
				$counter = 0;
				@endphp

				<a-entity id="images-wrapper" data-image="0" data-images="{{ count($content['images']) }}">

				@foreach ($content['images'] as $image)
						@if ($image['image']['#width'] > $image['image']['#height'])
								<a-image 
										id="image-{{ $counter }}" 
										class="image" 
										src="#image-cid-{{ $image['image']['#content-id'] }}" 
										width="4" 
										height="2" 
										material="transparent: true; opacity: 0.0" 
										animation="property: material.opacity; to: 1.0; startEvents: show-image-{{ $counter }}" 
										position="0 2 -3.1"> 
								</a-image>
						@elseif ($image['image']['#width'] < $image['image']['#height'])
								<a-image 
										id="image-{{ $counter }}" 
										class="image" 
										src="#image-cid-{{ $image['image']['#content-id'] }}" 
										width="2" 
										height="4" 
										material="transparent: true; opacity: 0.0" 
										animation="property: material.opacity; to: 1.0; startEvents: show-image-{{ $counter }}" 
										position="0 2 -3.1"> 
								</a-image>
						@else
								<a-image 
										id="image-{{ $counter }}" 
										class="image" 
										src="#image-cid-{{ $image['image']['#content-id'] }}" 
										width="4" 
										height="4" 
										material="transparent: true; opacity: 0.0" 
										animation="property: material.opacity; to: 1.0; startEvents: show-image-{{ $counter }}" 
										position="0 2 -3.1"> 
								</a-image>
						@endif

						@php
						$counter++;
						@endphp

				@endforeach

				<a-entity>

    </a-scene>

		<div id="title-texture">
		{{ $space_title }}
		</div>

		<div id="description-texture">
		{{ trans('image-slideshow::description.intro_instruction') }}	
		</div>

@endsection
