<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_models.vr_view') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary edit-model" type="button" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_models.edit_model') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <div style="width:100%">

                @if ($is_dae)
                    @include('admin.asset_library.model_dae', ['model_dae' => $uri])
                @elseif ($is_obj_mtl)
                    @include('admin.asset_library.model_obj_mtl', ['model_obj' => $obj_uri, 'model_mtl' => $mtl_uri])
                @elseif ($is_obj)
                    @include('admin.asset_library.model_obj_mtl', ['model_obj' => $obj_uri])
                @elseif ($is_mtl)
                    @include('admin.asset_library.model_obj_mtl', ['model_mtl' => $mtl_uri])
                @elseif ($is_ply)
                    @include('admin.asset_library.model_ply', ['model_ply' => $uri])
                @elseif ($is_gltf)
                    @include('admin.asset_library.model_gltf', ['model_gltf' => $uri])
                @elseif ($is_glb)
                    @include('admin.asset_library.model_glb', ['model_glb' => $uri])
                @endif

            </div>
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_models.model_file_type') }}</strong> {{ $model_file_type }}<br>
                <strong>{{ trans('template_asset_library_models.model_file_size') }}</strong> {{ $model_file_size }}<br>
                <strong>{{ trans('template_asset_library_models.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label for="distance-to-model">{{ trans('template_asset_library_models.distance_to_model') }}</label>
                <select class="form-control" id="distance-to-model">
                    <option value="0.5">{{ trans('template_asset_library_models.0_5_meters') }}</option>
                    <option value="1">{{ trans('template_asset_library_models.1_meter') }}</option>
                    <option value="1.5">{{ trans('template_asset_library_models.1_5_meters') }}</option>
                    <option value="2">{{ trans('template_asset_library_models.2_meters') }}</option>
                    <option value="3">{{ trans('template_asset_library_models.3_meters') }}</option>
                    <option value="4" selected="selected">{{ trans('template_asset_library_models.4_meters') }}</option>
                    <option value="5">{{ trans('template_asset_library_models.5_meters') }}</option>
                    <option value="7">{{ trans('template_asset_library_models.7_meters') }}</option>
                    <option value="10">{{ trans('template_asset_library_models.10_meters') }}</option>
                    <option value="15">{{ trans('template_asset_library_models.15_meters') }}</option>
                    <option value="20">{{ trans('template_asset_library_models.20_meters') }}</option>
                    <option value="30">{{ trans('template_asset_library_models.30_meters') }}</option>
                    <option value="40">{{ trans('template_asset_library_models.40_meters') }}</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label for="user-height">{{ trans('template_asset_library_models.user_height') }}</label>
                <select class="form-control" id="user-height">
                    <option value="0">{{ trans('template_asset_library_models.0_meters') }}</option>
                    <option value="1.6" selected="selected">{{ trans('template_asset_library_models.1_6_meters') }}</option>
                    <option value="2.0">{{ trans('template_asset_library_models.2_meters') }}</option>
                    <option value="3.0">{{ trans('template_asset_library_models.3_meters') }}</option>
                    <option value="4.0">{{ trans('template_asset_library_models.4_meters') }}</option>
                    <option value="5.0">{{ trans('template_asset_library_models.5_meters') }}</option>
                    <option value="6.0">{{ trans('template_asset_library_models.6_meters') }}</option>
                    <option value="7.0">{{ trans('template_asset_library_models.7_meters') }}</option>
                    <option value="8.0">{{ trans('template_asset_library_models.8_meters') }}</option>
                    <option value="9.0">{{ trans('template_asset_library_models.9_meters') }}</option>
                    <option value="10.0">{{ trans('template_asset_library_models.10_meters') }}</option>
                </select>
            </div>

            <div class="form-group" style="margin-top:30px">
                <div class="checkbox">
                    <label style="font-weight:700">
                        <input id="rotate-model" type="checkbox" value="rotate"> 
                        {{ trans('template_asset_library_models.rotate_y') }}
                    </label>
                </div>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_models.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_models.close') }}</button>

</div><!-- modal-footer //-->


