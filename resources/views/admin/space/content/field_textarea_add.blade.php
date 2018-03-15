<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <label class="control-label large">{{ $form['#label'] }}</label>
    @if ($form['#contentformat'] == App\Content\FieldTypeTextarea::CONTENTFORMAT_TEXT)
        {!! Form::textarea($field_id, '', array('class'=>'form-control input-lg', 'placeholder'=> $form['#description'], 'rows' => $form['#rows'], 'maxlength' => $form['#maxlength'])) !!}
    @elseif ($form['#contentformat'] == App\Content\FieldTypeTextarea::CONTENTFORMAT_HTML_TEXT)
        {!! Form::textarea($field_id, '', array('class'=>'form-control input-lg field-type-textarea', 'placeholder'=> $form['#description'], 'rows' => $form['#rows'], 'maxlength' => $form['#maxlength'])) !!}
    @endif
    <span class="info-block">{{ $form['#help'] }} @if ($form['#maxlength'] != App\Content\FieldTypeTextarea::DEFAULT_MAXLENGTH) <span class="label label-warning">{{ trans('template_fields.max') }} {{ $form['#maxlength'] }} {{ trans('template_fields.characters') }}</span> @endif <span class="label label-warning">@if ($form['#contentformat'] == App\Content\FieldTypeTextarea::CONTENTFORMAT_HTML_TEXT) {{ trans('template_fields.formatted_text') }}@else{{ trans('template_fields.plain_text') }}@endif</span> @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


