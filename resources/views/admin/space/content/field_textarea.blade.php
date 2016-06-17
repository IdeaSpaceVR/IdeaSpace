<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
<label class="large">{{ $form['#label'] }}</label>
{!! Form::textarea($field_id, '', array('class'=>'form-control input-lg', 'placeholder'=> $form['#description'], 'rows' => $form['#rows'], 'maxlength' => $form['#maxlength'])) !!}
{!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
<span class="help-block">{{ $form['#help'] }} @if ($form['#maxlength'] != App\Content\FieldTypeTextarea::DEFAULT_MAXLENGTH) <span class="label label-warning">{{ trans('template_fields.max') }} {{ $form['#maxlength'] }} {{ trans('template_fields.characters') }}</span> @endif @if ($form['#required'] == false) <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
</div>


