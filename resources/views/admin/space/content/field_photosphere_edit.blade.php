<div id="{{ $field_id }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="" name="{{ $field_id }}" class="photosphere-id">

        <div class="photosphere-add">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#photospheres-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.add_photosphere') }}
            </button>
        </div>

        <div class="photosphere-edit" style="display:none">
            <div class="photosphere-placeholder" style="margin-bottom:10px"></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#photospheres-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.edit_photosphere_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-photosphere-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.remove_photosphere_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == false) @foreach ($form['#fileformat'] as $fileformat) <span class="label label-warning">{{ $fileformat }}</span>@endforeach <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


