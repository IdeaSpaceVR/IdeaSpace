<?php
foreach ($contentlist as $key => $value) {
?>

<a class="anchor" id="{{ $key }}"></a>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{ $value['label'] }} @if ($value['max_values'] != \App\Theme::INFINITE) <span style="font-size:14px;color:#999">({{ trans('template_contentlist.max') }} {{ $value['max_values'] }}) @endif</h3>
  </div>
  <div class="panel-body">

      <button type="button" class="btn btn-primary space-add-content" data-contenttype-key="{{ $key }}" @if ($value['max_values'] != \App\Theme::INFINITE && isset($value['content']) && $value['max_values'] <= count($value['content'])) disabled="disabled" @endif>{{ trans('template_contentlist.add') }} {{ $value['label'] }}</button>

      <span class="pull-right" style="margin-top:10px">{!! $value['description'] !!} @if ($value['max_values'] > 1 || $value['max_values'] == \App\Theme::INFINITE) {{ trans('template_contenttypes.drag_n_drop') }} @endif</span>

        <?php
        if (isset($value['content'])) {
        ?>
        <div class="table-responsive" style="border:none">
            <table style="margin-top:20px" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:5%"></th>
                        <th style="width:5%"></th>
                        <th style="width:70%">{{ trans('template_contentlist.title') }}</th>
                        <th style="width:20%">{{ trans('template_contentlist.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($value['content'] as $content) {
                    ?>
                    <tr>
                        <td class="field-drag">
                         		<i class="fa fa-arrows" aria-hidden="true"></i>
                          	<input type="hidden" name="id" class="id" value="{{ $content['id'] }}">
                          	<input type="hidden" name="weight" class="weight" value="{{ $content['weight'] }}">
                        </td>
												@if (isset($content['preview_image_uri']))
                        <td class="field-preview-image">
														<img src="{{ $content['preview_image_uri'] }}" width="40">
												</td>
												@else
                        <td class="field-preview-image">
														<div style="width:40px; height:40px; border: 1px solid #999999; background-color:#cccccc"></div>	
												</td>
												@endif
                        <td class="field-title">
                            <div style="font-weight:bold;word-wrap:break-word;" class="title">{{ $content['title'] }}</div>
                            <div>
                                <span class="field-actions"><a style="font-size:14px" href="{{ route('content_edit', ['space_id' => $space->id, 'contenttype' => $key, 'content_id' => $content['id']]) }}">{{ trans('template_contentlist.edit') }}</a> <span style="font-size:14px;color:#999999">|</span> <a href="{{ route('content_delete', ['space_id' => $space->id, 'contenttype' => $key, 'content_id' => $content['id']]) }}" style="font-size:14px;color:#c9302c;">{{ trans('template_contentlist.delete') }}</a></span>
                            </div>
                        </td>
                        <td>{{ $content['updated_at'] }}<br>&nbsp;</td>
                    </tr>
                    <?php
                        } /* foreach */
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        } /* isset */
        ?>

  </div>
</div>

<?php
} /* contentlist */
?>
