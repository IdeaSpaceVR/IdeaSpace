<div class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center">
    @include('admin.assets.open_asset_library', ['field_id' => $field_id, 'form' => $form])
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
    </div>
    <span class="help-block">{{ $form['#help'] }} @foreach ($form['#fileformat'] as $fileformat) <span class="label label-warning">{{ $fileformat }}</span>@endforeach @if ($form['#required'] == false) <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
</div>


