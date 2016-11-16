<div id="{{ $field_id }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-file text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="@if (isset($form['#content']['#id'])) {{ $form['#content']['#id'] }} @endif" name="{{ $field_id }}" class="image-id">

        <div class="image-add" @if (isset($form['#content']['#value'])) style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#images-tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_images.add_image') }}
            </button>
        </div>

        <div class="image-edit" @if (!isset($form['#content']['#value'])) style="display:none" @endif>
            <div class="image-placeholder" style="margin-bottom:10px"><img src="@if (isset($form['#content']['#value'])) {{ $form['#content']['#value'] }} @endif" class="img-responsive center-block"></div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assets" data-opentab="#images-tab">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('template_asset_library_images.edit_image_btn') }}
            </button>
            <button type="button" class="btn btn-primary remove-image-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('template_asset_library_images.remove_image_btn') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @foreach ($form['#fileformat'] as $fileformat) <span class="label label-warning">{{ $fileformat }}</span>@endforeach @if ($form['#required'] == false) <span class="label label-success">{{ trans('template_fields.optional') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


