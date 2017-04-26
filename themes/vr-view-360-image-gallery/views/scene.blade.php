@extends('theme::index')

@section('title', $space_title)

@section('scene')

<div class="title"><h1>{{ $space_title }}</h1></div>

<div id="vrview"></div>

@if (isset($content['photo-spheres']) && count($content['photo-spheres']) > 0)

<ul class="carousel">

@foreach ($content['photo-spheres'] as $photosphere) 

    <li>
        <a href="#{{ $photosphere['photo-sphere']['#content-id'] }}">
          @if (isset($photosphere['photo-sphere-preview']))
          <img src="{{ $photosphere['photo-sphere-preview']['image-thumbnail']['#uri']['#value'] }}">
          @else
          <img src="{{ $photosphere['photo-sphere']['photosphere-thumbnail']['#uri']['#value'] }}">
          @endif
          <small>{{ $photosphere['photo-sphere-title']['#value'] }}</small>
        </a>
    </li>

@endforeach

</ul>


<script>
space_url = '{{ $space_url }}/content/photo-spheres';
blank_img_url = '{{ url($theme_dir . '/images/blank.png') }}';
</script>

<script src="{{ url($theme_dir . '/js/index.js') }}"></script>

@endif

@endsection
