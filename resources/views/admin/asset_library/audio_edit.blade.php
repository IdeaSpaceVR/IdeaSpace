<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title">{{ trans('template_asset_library_audio.edit_audio') }}</h2>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-8">

            <div>
                <audio class="center-block" style="width:100%;margin-bottom:50px" controls="controls">
                    <source src="{{ $uri }}" type="audio/mpeg">
                </audio>
            </div>
      
        </div><!-- col-md-8 //-->

        <div class="col-md-4">

            <div class="well"> 
                <strong>{{ trans('template_asset_library_audio.file_type') }}</strong> {{ $file_type }}<br>
                <strong>{{ trans('template_asset_library_audio.uploaded_on') }}</strong> {{ $uploaded_on }}<br>
                <strong>{{ trans('template_asset_library_audio.file_size') }}</strong> {{ $file_size }}<br>
                <strong>{{ trans('template_asset_library_audio.duration') }}</strong> {{ $duration }} 
            </div>
     
            <div class="form-group">
                <label for="caption">{{ trans('template_asset_library_audio.caption') }}</label>
                <textarea class="form-control" rows="3" id="caption">{{ $caption }}</textarea>
                <span class="help-block">{{ trans('template_asset_library_audio.caption_help') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('template_asset_library_audio.description') }}</label>
                <textarea class="form-control" rows="3" id="description">{{ $description }}</textarea>
            </div>

      </div><!-- col-md-4 //-->
    </div>

</div><!-- modal-body //-->

<div class="modal-footer">

    <a class="delete-link" data-dismiss="modal" data-audio-id="{{ $audio_id }}">{{ trans('template_asset_library_audio.delete_permanently') }}</a>
    <button type="button" class="btn btn-default save-btn" data-audio-id="{{ $audio_id }}"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('template_asset_library_audio.save') }}</button>
    <button type="button" class="btn btn-default insert-btn" data-dismiss="modal" style="display:none" data-audio-id="{{ $audio_id }}"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('template_asset_library_audio.insert') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library_audio.close') }}</button>

</div><!-- modal-footer //-->


