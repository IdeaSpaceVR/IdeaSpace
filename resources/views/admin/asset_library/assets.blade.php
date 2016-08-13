@extends('layouts.app')

@section('title', 'IdeaSpace - Assets')

@section('content')

    <h1 style="padding-left:35px">Assets</h1>

    <div class="row" style="padding-left:35px">

        <div class="col-md-12">

        @include('admin.asset_library.assets_partial')

        </div><!-- col-md-12 //-->

    </div>

@endsection
