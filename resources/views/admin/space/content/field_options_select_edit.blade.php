<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <label class="control-label large">@if (!is_null($theme['theme-key'])) {{ trans($theme['theme-key'] . '::' . $form['#label']) }} @else {{ $form['#label'] }} @endif</label>
    <div class="form-control-options-select {{ $errors->has($field_id)?'has-error':'' }}">
		@php
		if (!is_null($theme['theme-key'])) {
				foreach ($form['#options'] as $key => $value) {
						if ($key != '__isvr_options-select-default') {
								$form['#options'][$key] = trans($theme['theme-key'] . '::' . $value);
						}
				}
		}
		@endphp
    {!! Form::select($field_id, $form['#options'], $form['#content']['#value'], array('class' => 'form-control input-lg')) !!}
    </div>
    <span class="info-block">@if (!is_null($theme['theme-key'])) {!! trans($theme['theme-key'] . '::' . $form['#help']) !!} @else {!! $form['#help'] !!} @endif @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>
