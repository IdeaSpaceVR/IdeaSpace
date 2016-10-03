
            <ul class="nav nav-tabs asset-library-nav">

                <li role="presentation">
                    <a href="#images" id="images-tab" aria-controls="images" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_images') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/images.js') }}">{{ trans('template_asset_library.images') }}</a>
                </li>
                <li role="presentation">
                    <a href="#photospheres" id="photospheres-tab" aria-controls="photospheres" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_photospheres') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/photospheres.js') }}">{{ trans('template_asset_library.photospheres') }}</a>
                </li>
                <li role="presentation">
                    <a href="#videos" id="videos-tab" aria-controls="videos" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_videos') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/videos.js') }}">{{ trans('template_asset_library.videos') }}</a>
                </li>
                <li role="presentation">
                    <a href="#videospheres" id="videospheres-tab" aria-controls="videospheres" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_videospheres') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/videospheres.js') }}">{{ trans('template_asset_library.videospheres') }}</a>
                </li>
                <li role="presentation">
                    <a href="#models" id="models-tab" aria-controls="models" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_models') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/models.js') }}">{{ trans('template_asset_library.models') }}</a>
                </li>
                <li role="presentation">
                    <a href="#audio" id="audio-tab" aria-controls="audio" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_audio') }}" data-tab-remote-script="{{ asset('public/assets/admin/asset-library/js/audio.js') }}">{{ trans('template_asset_library.audio') }}</a>
                </li>

            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade in active" id="images">@include('admin.asset_library.images')</div>
                <div role="tabpanel" class="tab-pane fade" id="photospheres"></div>
                <div role="tabpanel" class="tab-pane fade" id="videos"></div>
                <div role="tabpanel" class="tab-pane fade" id="videospheres"></div>
                <div role="tabpanel" class="tab-pane fade" id="models"></div>
                <div role="tabpanel" class="tab-pane fade" id="audio"></div>

            </div><!-- tab-content //-->

