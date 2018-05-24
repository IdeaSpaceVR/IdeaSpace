<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_videospheres.vr_view') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary edit-videosphere" type="button" data-videosphere-id="{{ $id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.edit_videosphere') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <!-- a-frame //-->
            <a-scene embedded style="width:100%">

                <a-assets>
                    <img src="{{ asset('public/assets/admin/asset-library/images/loading.png') }}" id="loading" crossorigin="anonymous">
                    <video id="videosphere" src="{{ $uri }}" autoplay loop="true" crossorigin="anonymous"></video>
                </a-assets>

                <a-sky id="default-sky" color="#000000"></a-sky>

                <a-entity scene-floor-grid id="scene-floor-grid"></a-entity>

                <a-videosphere load-videosphere visible="false" material="side: back"></a-videosphere>

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
                <strong>{{ trans('template_asset_library_videospheres.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_videospheres.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_videospheres.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_videospheres.dimensions') }}</strong> {{ $dimensions }}<br> 
                <strong>{{ trans('template_asset_library_videospheres.duration') }}</strong> {{ $duration }} 
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-videosphere-id="{{ $videosphere_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_videospheres.close') }}</button>

</div><!-- modal-footer //-->


