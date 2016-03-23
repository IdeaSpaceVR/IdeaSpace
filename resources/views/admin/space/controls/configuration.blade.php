<?php
foreach ($panels as $key => $panel) {
?>
<div class="panel panel-default">
    <?php if (array_has($panel, 'label')) { ?>
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $panel['label']; ?></h3>
    </div>
    <?php } 
    foreach ($controls as $control) {
        if (array_has($control, 'panel') && array_has($panels, $control['panel'])) {
            if ($control['panel'] === $key) {
                $panel = $panels[$control['panel']];
                ?>
                <div class="panel-body">      
                    <?php switch ($control['type']) { 
                    case App\Theme::TYPE_IMAGES:
                    ?>@include('admin.space.controls.images', ['control' => $control])<?php
                        break;
                    case App\Theme::TYPE_IMAGE:
                        break;
                    case App\Theme::TYPE_TEXTINPUT:
                    ?>@include('admin.space.controls.textinput', ['control' => $control])<?php
                        break;
                    case App\Theme::TYPE_TEXTAREA:
                    ?>@include('admin.space.controls.textarea', ['control' => $control])<?php
                        break;
                    case App\Theme::TYPE_MODEL:

                        break;
                    case App\Theme::TYPE_MODELS:

                        break;
                    case App\Theme::TYPE_AUDIO:

                        break;
                    case App\Theme::TYPE_VIDEO:

                        break;
                    } /* end switch: control type */
                    ?>   
                </div> <!-- end: panel-body //-->
                <?php 
            } /* end if */
        } /* end if */
    } /* end foreach controls */ 
?>
</div> <!-- end: panel //-->
<?php
} /* end: foreach panels */
?>



