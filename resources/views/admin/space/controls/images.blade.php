<div class="form-group <?php echo $control['control_id']; ?>">
    <label for="upload-image-files"><?php if (array_has($control, 'label')) { echo $control['label']; } ?></label>

        <div id="upload-image-files" class="upload-image-files">
            <div class="text">Drag &amp; Drop Images Here</div>
            <div class="text">or</div>
            <div class="browser">
                <button type="button" class="btn btn-primary fileinput-button">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    <span class="text">Click to open File Browser</span>
                    <input type="file" name="files[]" multiple>
                    <input id="fileuploadtype" type="hidden" name="type" value="{{ $control['type'] }}">
                </button>
                <br>{!! $control['upload_max_filesize'] !!} {!! $control['post_max_size'] !!}<input type="hidden" id="max_filesize_bytes" value="{!! $control['max_file_size_bytes'] !!}">
            </div>
        </div>
        <p class="help-block"><?php if (array_has($control, 'description')) { echo $control['description']; } ?></p>

        <div id="image-files" class="image-files" <?php echo ((array_has($control, 'data'))?'file-counter="'.count($control['data']).'"':''); ?>>
        <?php 
        if (array_has($control, 'data')) { 
            $i = 0;
            foreach ($control['data'] as $image_data) {
        ?>
        <div class="image-file" id="image-file-<?php echo $i; ?>"><input name="<?php echo $control['control_id']; ?>[]" type="hidden" value="<?php echo $image_data['file_id']; ?>"><table><tr><td><span class="image"><img class="img-responsive" width="400" src="<?php echo $image_data['uri']; ?>"></span></td><td style="padding: 0 0 0 10px"><button type="button" class="btn btn-danger image-file-delete" aria-label="Delete" id="#image-file-delete-<?php echo $image_data['file_id']; ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="font-size:12px"></span> <?php echo $image_data['delete_text']; ?></button></td></tr></table></div>
        <?php 
            $i++;
            } 
        } 
        ?>
        </div>

</div> <!-- end: form-group //-->
