<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_images.vr_view') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary edit-image" type="button" data-image-id="{{ $id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_images.edit_image') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <!-- a-frame //-->
            <a-scene embedded scene-floor-grid style="width:100%">

                <a-assets>
                    <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading">
                </a-assets>

                <a-image position="0 1.6 -20" visible="false" load-image="src:{{ $uri }}" width="{{ $width_meter }}" height="{{ $height_meter }}"></a-image>

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

                <a-sky color="#000000"></a-sky>

            </a-scene>      
            <!-- a-frame //-->
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_images.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_images.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_images.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_images.dimensions') }}</strong> {{ $dimensions }} 
            </div>
     
            <div class="form-group">
                <label for="distance">{{ trans('template_asset_library_images.distance_to_image') }}</label>
                <select class="form-control" id="distance">
                    <option>{{ trans('template_asset_library_images.1_meter') }}</option>
                    <option>{{ trans('template_asset_library_images.2_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.3_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.4_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.5_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.7_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.10_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.15_meters') }}</option>
                    <option>{{ trans('template_asset_library_images.20_meters') }}</option>
                </select>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-image-id="{{ $image_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_images.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_images.close') }}</button>

</div><!-- modal-footer //-->


