
    <div class="row upload-area" style="display:none">

        <div class="col-md-12">

            <a href="#upload"></a>
            <button type="button" style="margin-right:7px;font-size:30px" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="upload">
                <div style="margin-top:20px" class="text">{{ trans('template_asset_library_images.dragndrop_images') }}</div>
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
            <p class="help-block">{{ trans('template_asset_library_images.nearest_power_of_two') }}</p>

        </div><!-- col-md-12 //-->

    </div><!-- row //-->

    <div class="files" data-file-counter="{{ ((count($images)>0)?count($images):0) }}">
           
        <ul class="list"> 
        <?php 
        $i = 0; 
        foreach ($images as $image) { 
        ?>
            <li class="list-item">

                <div id="file-{{ $i }}" class="wrapper" data-image-id="{{ $image['id'] }}">

                    <img class="img-thumbnail img-responsive" src="{{ $image['uri'] }}">

                    <div class="menu" style="text-align:center;margin-top:5px;display:none">
                        <a href="#" class="view-in-vr">{{ trans('template_asset_library_images.view_in_vr') }}</a> | <a href="#" class="edit">{{ trans('template_asset_library_images.edit') }}</a> <span class="insert-link" style="display:none">| <a href="#" class="insert">{{ trans('template_asset_library_images.insert') }}</a></span>
                    </div>

                </div>

            </li>
        <?php 
        $i++; 
        } 
        ?>
        </ul>

    </div><!-- files //-->


