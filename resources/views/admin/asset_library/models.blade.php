
    <div class="row upload-area" style="display:none">

        <div class="col-md-12">

            <a href="#upload"></a>
            <button type="button" style="margin-right:7px;font-size:30px" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="upload">
                <div style="margin-top:20px" class="text">{{ trans('template_asset_library_models.dragndrop_models') }}</div>
                <div class="text">{{ trans('template_asset_library.or') }}</div>
                <div style="margin-bottom:20px" class="browser">
                    <button type="button" class="btn btn-primary fileinput-button">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        <span class="text">{{ trans('template_asset_library.open_file_browser') }}</span>
                        <input type="file" name="files[]" multiple>
                    </button>
                    <div style="margin-top:15px">
                    @if ($upload_max_filesize != '')
                        {{ $upload_max_filesize }}
                    @endif
                    -
                    @if ($post_max_size != '')
                        {{ $post_max_size }}
                    @endif
                    <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="cursor:pointer;font-size:18px" data-toggle="tooltip" data-placement="right" title="{{ $upload_max_filesize_tooltip }}"></span>
                    </div>
                    <input type="hidden" id="max_filesize_bytes" value="{{ $max_filesize_bytes }}">
                </div>
            </div><!-- upload //-->
            <div class="alert alert-info" role="alert">{{ trans('template_asset_library_models.supported_model_formats') }}</div>

        </div><!-- col-md-12 //-->

    </div><!-- row //-->

    <div class="files" data-file-counter="{{ ((count($models)>0)?count($models):0) }}">

        @if (count($models) == 0)
            <div class="no-content">
                {{ trans('template_asset_library_models.no_models') }}
            </div>
        @endif

        <ul class="list">
        <?php
        $i = 0;
        foreach ($models as $model) {
        ?>
            <li class="list-item">

                <div id="file-{{ $i }}" class="wrapper" data-model-id="{{ $model['id'] }}">
       
                    <div>
                        <img class="img-thumbnail img-responsive edit" src="{{ $model['uri'] }}" data-model-id="{{ $model['id'] }}">
                    </div> 

                    <div class="menu" style="text-align:center;margin-top:5px;display:none">
                        <a href="#" class="vr-view" data-model-id="{{ $model['id'] }}">{{ trans('template_asset_library_models.vr_view') }}</a> | <a href="#" class="edit" data-model-id="{{ $model['id'] }}">{{ trans('template_asset_library_models.edit') }}</a> <span class="insert-link" style="display:none">| <a href="#" class="insert" data-model-id="{{ $model['id'] }}">{{ trans('template_asset_library_models.insert') }}</a></span>
                    </div>

                </div>

            </li>
        <?php
        $i++;
        }
        ?>
        </ul>

    </div><!-- files //-->

