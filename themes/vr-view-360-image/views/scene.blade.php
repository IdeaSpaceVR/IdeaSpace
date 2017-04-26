@extends('theme::index')

@section('title', $space_title)

@section('scene')

<div id="vrview"></div>

<script>
space_url = '{{ $space_url }}/content/photo-spheres';
blank_img_url = '{{ url($theme_dir . '/images/blank.png') }}';
</script>

<script src="{{ url($theme_dir . '/js/index.js') }}"></script>

@endsection
