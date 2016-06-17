@extends('theme::index')

@section('title', $space_title)

@section('scene')

    @include('theme::assets')

{{ $content }}

@endsection
