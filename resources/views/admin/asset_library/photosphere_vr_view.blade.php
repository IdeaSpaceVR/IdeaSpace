<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_photospheres.vr_view') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary edit-photosphere" type="button" data-photosphere-id="{{ $id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.edit_photosphere') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <!-- a-frame //-->
            <a-scene embedded style="width:100%">

                <a-assets>
                    <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading" crossorigin="anonymous">
                </a-assets>

                <a-sky id="default-sky" color="#000000"></a-sky>

                <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

                <a-sky load-photosphere="src: {{ $uri }}" visible="false" rotation="0 -90 0"></a-sky>

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
                <strong>{{ trans('template_asset_library_photospheres.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_photospheres.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_photospheres.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_photospheres.dimensions') }}</strong> {{ $dimensions }} 
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-photosphere-id="{{ $photosphere_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_photospheres.close') }}</button>

</div><!-- modal-footer //-->


