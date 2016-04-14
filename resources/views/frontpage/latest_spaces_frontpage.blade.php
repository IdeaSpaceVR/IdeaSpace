@extends('layouts.frontpage_app')

@section('title', 'IdeaSpace')

@section('content')

<div class="container" style="margin-top:40px;margin-bottom:40px">

    @foreach ($spaces as $space)

        <div class="row" style="margin:40px 0 100px 0">

            <div class="col-sm-8 col-sm-offset-2">
            <h2>{{ $space->title }}</h2>
            {!! space_embed_code(url($space->uri), '100%', '400px') !!}
            </div>

        </div>

    @endforeach

    <nav>
        <ul class="pager">
            <li @if ($spaces->currentPage() == $spaces->firstItem()) class="disabled" @endif><a href="{{ $spaces->previousPageUrl() }}">Previous</a></li>
            <li @if (!$spaces->hasMorePages()) class="disabled" @endif><a href="{{ $spaces->nextPageUrl() }}">Next</a></li>
        </ul>
    </nav>

</div>

@endsection
