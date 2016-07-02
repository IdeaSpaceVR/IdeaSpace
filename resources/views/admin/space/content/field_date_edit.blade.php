<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <label class="control-label large">{{ $form['#label'] }}</label>
    <div class="form-control-date {{ $errors->has($field_id)?'has-error':'' }}">
    {!! Form::date($field_id, \Carbon\Carbon::now(), array('class'=>'form-control input-lg')) !!}
    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == false) <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>
