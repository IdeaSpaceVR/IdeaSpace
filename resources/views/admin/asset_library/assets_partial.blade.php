
            <ul class="nav nav-tabs asset-library-nav">

                <li role="presentation" class="active">
                    <a href="#images" id="images-tab" aria-controls="images" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_images') }}">{{ trans('template_asset_library.images') }}</a>
                </li>
                <li role="presentation">
                    <a href="#photospheres" id="photospheres-tab" aria-controls="photospheres" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_photospheres') }}">{{ trans('template_asset_library.photospheres') }}</a>
                </li>
                <li role="presentation">
                    <a href="#videos" id="videos-tab" aria-controls="videos" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_videos') }}">{{ trans('template_asset_library.videos') }}</a>
                </li>
                <li role="presentation">
                    <a href="#videospheres" id="videospheres-tab" aria-controls="videospheres" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_videospheres') }}">{{ trans('template_asset_library.videospheres') }}</a>
                </li>
                <li role="presentation">
                    <a href="#audio" id="audio-tab" aria-controls="audio" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_audio') }}">{{ trans('template_asset_library.audio') }}</a>
                </li>
                <li role="presentation">
                    <a href="#models" id="models-tab" aria-controls="models" role="tab" data-toggle="tab" data-tab-remote="{{ route('asset_library_models') }}">{{ trans('template_asset_library.models') }}</a>
                </li>

            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade in active" id="images"></div>
                <div role="tabpanel" class="tab-pane fade" id="photospheres"></div>
                <div role="tabpanel" class="tab-pane fade" id="videos"></div>
                <div role="tabpanel" class="tab-pane fade" id="videospheres"></div>
                <div role="tabpanel" class="tab-pane fade" id="audio"></div>
                <div role="tabpanel" class="tab-pane fade" id="models"></div>

            </div><!-- tab-content //-->

