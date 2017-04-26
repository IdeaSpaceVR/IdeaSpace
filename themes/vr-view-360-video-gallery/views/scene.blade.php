@extends('theme::index')

@section('title', $space_title)

@section('scene')

<div class="title"><h1>{{ $space_title }}</h1></div>

<div id="vrview"></div>

@if (isset($content['video-spheres']) && count($content['video-spheres']) > 0)

<ul class="carousel">

@foreach ($content['video-spheres'] as $videosphere) 

    <li>
        <a href="#{{ $videosphere['video-sphere']['#content-id'] }}">
          <img src="{{ $videosphere['video-sphere-preview']['image-thumbnail']['#uri']['#value'] }}">
          <small>{{ $videosphere['video-sphere-title']['#value'] }}</small>
        </a>
    </li>

@endforeach

</ul>


<script>
space_url = '{{ $space_url }}/content/video-spheres';
blank_img_url = '{{ url($theme_dir . '/images/blank.png') }}';
</script>

<script src="{{ url($theme_dir . '/js/index.js') }}"></script>

@endif

@endsection
