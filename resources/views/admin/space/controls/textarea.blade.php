<div class="form-group <?php echo $control['control_id']; ?>">
    <label for="textinput"><?php if (array_has($control, 'label')) { echo $control['label']; } ?></label>
    <textarea class="form-control" rows="5" name="<?php echo $control['control_id']; ?>"><?php echo ((array_has($control, 'data'))?$control['data'][0]['text']:''); ?></textarea>
    <p class="help-block"><?php if (array_has($control, 'description')) { echo $control['description']; } ?></p>
</div> <!-- end: form-group //-->
