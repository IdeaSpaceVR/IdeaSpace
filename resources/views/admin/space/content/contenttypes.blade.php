<?php
foreach ($contenttypes as $key => $value) {
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{ $value['label'] }}</h3>
  </div>
  <div class="panel-body">
      <button type="button" class="btn btn-primary space-add-content" data-contenttype-key="{{ $key }}">{{ trans('template_contenttypes.add') }} {{ $value['label'] }}</button>
      <span class="pull-right" style="margin-top:10px">{{ $value['description'] }}</span>
  </div>
</div>

<?php
} /* contenttypes */
?>



