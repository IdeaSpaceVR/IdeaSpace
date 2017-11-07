<div id="{{ str_random(10) }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="{{ old($field_id . '__image_id') }}" name="{{ $field_id }}" class="image-id">

        <div class="image-add" @if (old($field_id . '__image_id') !== null) style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#images-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_images.add_image') }}
            </button>
        </div>

        <div class="image-edit" @if (old($field_id . '__image_id') === null) style="display:none" @endif>
            <div class="image-placeholder" style="margin-bottom:10px"><img src="{{ old($field_id . '__image_src') }}" class="img-responsive center-block"></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#images-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_images.edit_image_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-image-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_images.remove_image_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @foreach ($form['#file-extension'] as $file_ext) <span class="label label-warning">{{ $file_ext }}</span>@endforeach @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


