<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_models.edit_model') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary vr-view" type="button" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span> {{ trans('template_asset_library_models.vr_view') }}</button></h2>
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
                <label for="caption">{{ trans('template_asset_library_models.caption') }}</label>
                <textarea class="form-control" rows="3" id="caption">{{ $caption }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label for="description">{{ trans('template_asset_library_models.description') }}</label>
                <textarea class="form-control" rows="3" id="description">{{ $description }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label for="scale">{{ trans('template_asset_library_models.scale') }}</label>
                <select class="form-control" id="scale" autocomplete="off">
                    <option value="0.01 0.01 0.01" @if ($scale == '0.01 0.01 0.01') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_1') }}</option>
                    <option value="0.02 0.02 0.02" @if ($scale == '0.02 0.02 0.02') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_2') }}</option>
                    <option value="0.03 0.03 0.03" @if ($scale == '0.03 0.03 0.03') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_3') }}</option>
                    <option value="0.04 0.04 0.04" @if ($scale == '0.04 0.04 0.04') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_4') }}</option>
                    <option value="0.05 0.05 0.05" @if ($scale == '0.05 0.05 0.05') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_5') }}</option>
                    <option value="0.06 0.06 0.06" @if ($scale == '0.06 0.06 0.06') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_6') }}</option>
                    <option value="0.07 0.07 0.07" @if ($scale == '0.07 0.07 0.07') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_7') }}</option>
                    <option value="0.08 0.08 0.08" @if ($scale == '0.08 0.08 0.08') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_8') }}</option>
                    <option value="0.09 0.09 0.09" @if ($scale == '0.09 0.09 0.09') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_0_9') }}</option>
                    <option value="0.1 0.1 0.1" @if ($scale == '0.1 0.1 0.1') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_1') }}</option>
                    <option value="0.2 0.2 0.2" @if ($scale == '0.2 0.2 0.2') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_2') }}</option>
                    <option value="0.3 0.3 0.3" @if ($scale == '0.3 0.3 0.3') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_3') }}</option>
                    <option value="0.4 0.4 0.4" @if ($scale == '0.4 0.4 0.4') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_4') }}</option>
                    <option value="0.5 0.5 0.5" @if ($scale == '0.5 0.5 0.5') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_5') }}</option>
                    <option value="0.6 0.6 0.6" @if ($scale == '0.6 0.6 0.6') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_6') }}</option>
                    <option value="0.7 0.7 0.7" @if ($scale == '0.7 0.7 0.7') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_7') }}</option>
                    <option value="0.8 0.8 0.8" @if ($scale == '0.8 0.8 0.8') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_8') }}</option>
                    <option value="0.9 0.9 0.9" @if ($scale == '0.9 0.9 0.9') selected="selected" @endif>{{ trans('template_asset_library_models.scale_0_9') }}</option>
                    <option value="1.0 1.0 1.0" @if ($scale == '1.0 1.0 1.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_0') }}</option>
                    <option value="1.1 1.1 1.1" @if ($scale == '1.1 1.1 1.1') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_1') }}</option>
                    <option value="1.2 1.2 1.2" @if ($scale == '1.2 1.2 1.2') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_2') }}</option>
                    <option value="1.3 1.3 1.3" @if ($scale == '1.3 1.3 1.3') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_3') }}</option>
                    <option value="1.4 1.4 1.4" @if ($scale == '1.4 1.4 1.4') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_4') }}</option>
                    <option value="1.5 1.5 1.5" @if ($scale == '1.5 1.5 1.5') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_5') }}</option>
                    <option value="1.6 1.6 1.6" @if ($scale == '1.6 1.6 1.6') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_6') }}</option>
                    <option value="1.7 1.7 1.7" @if ($scale == '1.7 1.7 1.7') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_7') }}</option>
                    <option value="1.8 1.8 1.8" @if ($scale == '1.8 1.8 1.8') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_8') }}</option>
                    <option value="1.9 1.9 1.9" @if ($scale == '1.9 1.9 1.9') selected="selected" @endif>{{ trans('template_asset_library_models.scale_1_9') }}</option>
                    <option value="2.0 2.0 2.0" @if ($scale == '2.0 2.0 2.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_2_0') }}</option>
                    <option value="3.0 3.0 3.0" @if ($scale == '3.0 3.0 3.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_3_0') }}</option>
                    <option value="4.0 4.0 4.0" @if ($scale == '4.0 4.0 4.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_4_0') }}</option>
                    <option value="5.0 5.0 5.0" @if ($scale == '5.0 5.0 5.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_5_0') }}</option>
                    <option value="10.0 10.0 10.0" @if ($scale == '10.0 10.0 10.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_10_0') }}</option>
                    <option value="15.0 15.0 15.0" @if ($scale == '15.0 15.0 15.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_15_0') }}</option>
                    <option value="20.0 20.0 20.0" @if ($scale == '20.0 20.0 20.0') selected="selected" @endif>{{ trans('template_asset_library_models.scale_20_0') }}</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label for="rotation-x">{{ trans('template_asset_library_models.rotate_x') }}</label>
                <select class="form-control" id="rotation-x" autocomplete="off">
                    @for ($i = 0; $i <= 360; $i++)
                    <option value="{{ $i }}" @if ($rotation_x == $i) selected="selected" @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label for="rotation-y">{{ trans('template_asset_library_models.rotate_y') }}</label>
                <select class="form-control" id="rotation-y" autocomplete="off">
                    @for ($i = 0; $i <= 360; $i++)
                    <option value="{{ $i }}" @if ($rotation_y == $i) selected="selected" @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label for="rotation-z">{{ trans('template_asset_library_models.rotate_z') }}</label>
                <select class="form-control" id="rotation-z" autocomplete="off">
                    @for ($i = 0; $i <= 360; $i++)
                    <option value="{{ $i }}" @if ($rotation_z == $i) selected="selected" @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <a class="delete-link" data-dismiss="modal" data-model-id="{{ $id }}">{{ trans('template_asset_library_models.delete_permanently') }}</a>
    <button type="button" class="btn btn-default save-btn" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_asset_library_models.save') }}</button>
    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_models.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_models.close') }}</button>

</div><!-- modal-footer //-->


