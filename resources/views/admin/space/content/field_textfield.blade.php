<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
<label class="large">{{ $form['#label'] }}</label>
@if ($form['#contentformat'] == App\Content\FieldTypeTextfield::CONTENTFORMAT_TEXT)
{!! Form::text($field_id, '', array('class'=>'form-control input-lg', 'placeholder'=> $form['#description'], 'maxlength' => $form['#maxlength'])) !!}
@elseif ($form['#contentformat'] == App\Content\FieldTypeTextfield::CONTENTFORMAT_HTML_TEXT)
<div name="{{ $field_id }}"></div>
@endif
{!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
<span class="help-block">{{ $form['#help'] }} @if ($form['#maxlength'] != App\Content\FieldTypeTextfield::DEFAULT_MAXLENGTH) <span class="label label-warning">{{ trans('template_fields.max') }} {{ $form['#maxlength'] }} {{ trans('template_fields.characters') }}</span> @endif @if ($form['#required'] == false) <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
</div>


