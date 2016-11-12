<div id="{{ $field_id }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="@if (isset($form['#content']['#id'])) {{ $form['#content']['#id'] }} @endif" name="{{ $field_id }}" class="videosphere-id">

        <div class="videosphere-add" @if (isset($form['#content']['#value'])) style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#videospheres-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.add_videosphere') }}
            </button>
        </div>

        <div class="videosphere-edit" @if (!isset($form['#content']['#value'])) style="display:none" @endif>
            <div class="videosphere-placeholder" style="margin-bottom:10px"><video class="edit img-thumbnail center-block" width="300" height="auto" preload="metadata"><source src="@if (isset($form['#content']['#value'])) {{ $form['#content']['#value'] }} @endif" type="video/mp4"></video></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#videospheres-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.edit_videosphere_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-videosphere-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.remove_videosphere_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == false) @foreach ($form['#fileformat'] as $fileformat) <span class="label label-warning">{{ $fileformat }}</span>@endforeach <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>

@push('field_type_scripts')
    <script src="{{ asset('public/assets/admin/space/content/js/field_videosphere_edit.js') }}" type="text/javascript"></script>
@endpush
