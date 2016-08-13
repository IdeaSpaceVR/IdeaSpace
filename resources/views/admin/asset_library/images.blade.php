

    <div class="row" style="padding-left:35px">

        <div class="col-md-12">

            <a href="#upload"></a>
            <div id="upload-images" class="upload-images">
                <div class="text">{{ trans('template_asset_library.dragndrop_images') }}</div>
                <div class="text">{{ trans('template_asset_library.or') }}</div>
                <div class="browser">
                    <button type="button" class="btn btn-primary fileinput-button">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        <span class="text">{{ trans('template_asset_library.open_file_browser') }}</span>
                        <input type="file" name="files[]" multiple>
                        <input id="fileuploadtype" type="hidden" name="type" value=" $control['type'] ">
                    </button>
                    <br> $control['upload_max_filesize']  $control['post_max_size'] 
                    <input type="hidden" id="max_filesize_bytes" value=" $control['max_file_size_bytes'] ">
                </div>
            </div>

        </div>

    </div>

