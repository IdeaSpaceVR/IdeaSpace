<?php
foreach ($contenttypes as $key => $value) {
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">@if (!is_null($theme_key)) {{ trans($theme_key . '::' . $value['label']) }} @else {{ $value['label'] }} @endif @if ($value['max_values'] != \App\Theme::INFINITE) <span style="font-size:14px;color:#999">({{ trans('template_contentlist.max') }} {{ $value['max_values'] }}) @endif</h3>
  </div>
  <div class="panel-body">
      <button type="button" class="btn btn-primary space-add-content" data-contenttype-key="{{ $key }}" @if ($value['max_values'] != \App\Theme::INFINITE && isset($value['content']) && $value['max_values'] <= count($value['content'])) disabled="disabled" @endif>{{ trans('template_contenttypes.add') }} @if (!is_null($theme_key)) {{ trans($theme_key . '::' . $value['label']) }} @else {{ $value['label'] }} @endif</button>
      <span class="pull-right" style="margin-top:10px">@if (!is_null($theme_key)) {!! trans($theme_key . '::' . $value['description']) !!} @else {!! $value['description'] !!} @endif @if ($value['max_values'] > 1 || $value['max_values'] == \App\Theme::INFINITE) {{ trans('template_contenttypes.drag_n_drop') }} @endif</span>
  </div>
</div>

<?php
} /* contenttypes */
?>



