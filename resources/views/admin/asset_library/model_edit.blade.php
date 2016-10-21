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
                @endif

            </div>
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_models.model_file_type') }}</strong> {{ $model_file_type }}<br>
                <strong>{{ trans('template_asset_library_models.model_file_size') }}</strong> {{ $model_file_size }}<br>
                <strong>{{ trans('template_asset_library_models.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
            </div>

            <div class="form-group">
                <label for="caption">{{ trans('template_asset_library_models.caption') }}</label>
                <textarea class="form-control" rows="3" id="caption">{{ $caption }}</textarea>
            </div>

            <div class="form-group">
                <label for="description">{{ trans('template_asset_library_models.description') }}</label>
                <textarea class="form-control" rows="3" id="description">{{ $description }}</textarea>
            </div>

            <div class="form-group">
                <label for="scale">{{ trans('template_asset_library_models.scale') }}</label>
                <input class="form-control" type="number" id="scale" min="0.01" max="10">
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <a class="delete-link" data-dismiss="modal" data-model-id="{{ $id }}">{{ trans('template_asset_library_models.delete_permanently') }}</a>
    <button type="button" class="btn btn-default save-btn" data-image-id="{{ $id }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_asset_library_models.save') }}</button>
    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-model-id="{{ $id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_models.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_models.close') }}</button>

</div><!-- modal-footer //-->


