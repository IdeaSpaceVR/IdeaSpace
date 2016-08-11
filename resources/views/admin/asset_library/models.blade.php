@extends('layouts.app')

@section('title', 'IdeaSpace - Assets')

@section('content')

    <h1 style="padding-left:35px">Assets</h1>

    <div class="row" style="padding-left:35px">

        <div class="col-md-12">

            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="{{ route('asset_library_images') }}">{{ trans('template_asset_library.images') }}</a></li>
                <li role="presentation"><a href="{{ route('asset_library_photospheres') }}">{{ trans('template_asset_library.photospheres') }}</a></li>
                <li role="presentation"><a href="{{ route('asset_library_videos') }}">{{ trans('template_asset_library.videos') }}</a></li>
                <li role="presentation"><a href="{{ route('asset_library_videospheres') }}">{{ trans('template_asset_library.videospheres') }}</a></li>
                <li role="presentation"><a href="{{ route('asset_library_audio') }}">{{ trans('template_asset_library.audio') }}</a></li>
                <li role="presentation"><a href="{{ route('asset_library_models') }}">{{ trans('template_asset_library.models') }}</a></li>
            </ul>

            <a href="#upload"></a>
            <div id="upload-images" class="upload-images">
                <div class="text">{{ trans('template_asset_library.dragndrop_images') }}</div>
                <div class="text">{{ trans('template_asset_library.or') }}</div>
                <div class="browser">
                    <button type="button" class="btn btn-primary fileinput-button">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        <span class="text">{{ trans('template_asset_library.open_file_browser') }}</span>
                        <input type="file" name="files[]" multiple>
                        <input id="fileuploadtype" type="hidden" name="type" value=" $control['type'] ">
                    </button>
                    <br> $control['upload_max_filesize']  $control['post_max_size'] 
                    <input type="hidden" id="max_filesize_bytes" value=" $control['max_file_size_bytes'] ">
                </div>
            </div>

        </div>

    </div>

@endsection
