<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_videos.vr_view') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary edit-video" type="button" data-video-id="{{ $id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_videos.edit_video') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <!-- a-frame //-->
            <a-scene embedded style="width:100%">

                <a-assets>
                    <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading" crossorigin="anonymous">
                    <video id="video" src="{{ $uri }}" crossorigin="anonymous"></video>
                </a-assets>

                <a-sky id="default-sky" color="#000000"></a-sky>

                <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

                <a-video id="vr-view-video" load-video width="8" height="4" position="0 2 -20" visible="false"></a-video>

                <a-entity 
                    position="0 1.6 -4"
                    geometry="primitive: circle; radius: 2"
                    material="transparent: true; src: #loading"
                    id="image-loading">
                    <a-animation
                        attribute="rotation"
                        dur="5000"
                        to="0 0 -360"
                        easing="linear"
                        repeat="indefinite"
                        id="image-loading-anim">
                    </a-animation>
                </a-entity>

            </a-scene>      
            <!-- a-frame //-->
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_videos.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_videos.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_videos.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_videos.dimensions') }}</strong> {{ $dimensions }}<br>
                <strong>{{ trans('template_asset_library_videos.duration') }}</strong> {{ $duration }} 
            </div>

            <div class="form-group">
                <label for="distance-to-video">{{ trans('template_asset_library_videos.distance_to_video') }}</label>
                <select class="form-control" id="distance-to-video">
                    <option value="0.5">{{ trans('template_asset_library_videos.0_5_meters') }}</option>
                    <option value="1">{{ trans('template_asset_library_videos.1_meter') }}</option>
                    <option value="1.5">{{ trans('template_asset_library_videos.1_5_meters') }}</option>
                    <option value="2">{{ trans('template_asset_library_videos.2_meters') }}</option>
                    <option value="3">{{ trans('template_asset_library_videos.3_meters') }}</option>
                    <option value="4" selected="selected">{{ trans('template_asset_library_videos.4_meters') }}</option>
                    <option value="5">{{ trans('template_asset_library_videos.5_meters') }}</option>
                    <option value="7">{{ trans('template_asset_library_videos.7_meters') }}</option>
                    <option value="10">{{ trans('template_asset_library_videos.10_meters') }}</option>
                    <option value="15">{{ trans('template_asset_library_videos.15_meters') }}</option>
                    <option value="20">{{ trans('template_asset_library_videos.20_meters') }}</option>
                </select>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-video-id="{{ $video_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_videos.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_videos.close') }}</button>

</div><!-- modal-footer //-->


