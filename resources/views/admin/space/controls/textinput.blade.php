<div class="form-group <?php echo $control['control_id']; ?>">
    <label for="textinput"><?php if (array_has($control, 'label')) { echo $control['label']; } ?></label>
    <input type="text" name="<?php echo $control['control_id']; ?>" class="form-control" placeholder="Insert text" value="<?php echo ((array_has($control, 'data'))?$control['data'][0]['text']:''); ?>">
    <p class="help-block"><?php if (array_has($control, 'description')) { echo $control['description']; } ?></p>
</div> <!-- end: form-group //-->
