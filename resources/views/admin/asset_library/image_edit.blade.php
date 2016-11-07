<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_images.edit_image') }} <button style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary vr-view" type="button" data-image-id="{{ $id }}"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span> {{ trans('template_asset_library_images.vr_view') }}</button></h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">
      
            <img class="img-responsive center-block target-image" src="{{ $uri }}">
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_images.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_images.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_images.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_images.dimensions') }}</strong> {{ $dimensions }} 
            </div>
     
            <div class="form-group">
                <label for="caption">{{ trans('template_asset_library_images.caption') }}</label>
                <textarea class="form-control" rows="3" id="caption">{{ $caption }}</textarea>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('template_asset_library_images.description') }}</label>
                <textarea class="form-control" rows="3" id="description">{{ $description }}</textarea>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <a class="delete-link" data-dismiss="modal" data-image-id="{{ $image_id }}">{{ trans('template_asset_library_images.delete_permanently') }}</a>
    <button type="button" class="btn btn-default save-btn" data-image-id="{{ $image_id }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_asset_library_images.save') }}</button>
    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-image-id="{{ $image_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_images.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_images.close') }}</button>

</div><!-- modal-footer //-->


