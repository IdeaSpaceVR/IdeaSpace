<div id="{{ str_random(10) }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" @if (isset($form['#content']['#id'])) value="{{ $form['#content']['#id'] }}" @else value="" @endif name="{{ $field_id }}" class="audio-id">

        <div class="audio-add" @if (isset($form['#content']['#value'])) style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#audio-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_audio.add_audio') }}
            </button>
        </div>

        <div class="audio-edit" @if (!isset($form['#content']['#value'])) style="display:none" @endif>
            <div class="audio-placeholder" style="margin-bottom:10px"><audio class="center-block" controls="controls"><source src="@if (isset($form['#content']['#value'])) {{ $form['#content']['#value'] }} @endif" type="audio/mpeg"></audio></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#audio-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_audio.edit_audio_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-audio-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_audio.remove_audio_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @foreach ($form['#file-extension'] as $file_ext) <span class="label label-warning">{{ $file_ext }}</span>@endforeach @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>

