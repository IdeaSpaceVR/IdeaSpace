<div id="{{ $field_id }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="" name="{{ $field_id }}" class="audio-id">

        <div class="audio-add">
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#audio-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_audio.add_audio') }}
            </button>
        </div>

        <div class="audio-edit" style="display:none">
            <div class="audio-placeholder" style="margin-bottom:10px"><audio class="center-block" controls="controls"><source src="" type="audio/mpeg"></audio></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#audio-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_audio.edit_audio_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-audio-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_audio.remove_audio_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == false) @foreach ($form['#fileformat'] as $fileformat) <span class="label label-warning">{{ $fileformat }}</span>@endforeach <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>

@push('field_type_scripts')
    <script src="{{ asset('public/assets/admin/space/content/js/field_audio_add.js') }}" type="text/javascript"></script>
@endpush
