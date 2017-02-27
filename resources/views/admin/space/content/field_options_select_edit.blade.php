<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <label class="control-label large">{{ $form['#label'] }}</label>
    <div class="form-control-options-select {{ $errors->has($field_id)?'has-error':'' }}">
    {!! Form::select($field_id, $form['#options'], $form['#content']['#value'], array('class' => 'form-control input-lg')) !!}
    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>
