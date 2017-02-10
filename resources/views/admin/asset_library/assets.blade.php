@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

@include('admin.asset_library.asset_details_modal')

<h1 style="padding-left:35px">{{ trans('template_asset_library.assets') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" type="button" id="add-new-asset">{{ trans('template_asset_library.add_new') }}</button></h1>

<div class="row" style="padding-left:35px">

    <div class="col-md-12">

    @include('admin.asset_library.assets_partial')

    </div><!-- col-md-12 //-->

</div>

@endsection
