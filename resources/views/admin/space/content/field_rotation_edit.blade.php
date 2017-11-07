<div id="{{ str_random(10) }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-rotation text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" value="{{ $content_id }}" class="content-id">
        <input type="hidden" value="{{ $field_id }}" class="content-key">
        <input type="hidden" @if (isset($form['#content']['#value']) && $form['#content']['#value'] != '') value="{{ $form['#content']['#value'] }}" @else value="" @endif name="{{ $field_id }}" class="rotation-info">

        <div class="rotation-add" @if (isset($form['#content']['#value']) && $form['#content']['#value'] != '') style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg add-rotation-btn add-edit-rotation-btn" data-space-id="{{ $space_id }}" data-contenttype-name="{{ $contenttype_name }}" data-subject-field-type="{{ $form['#field-type'] }}" data-subject-field-name="{{ $form['#field-name'] }}" data-subject-field-label="{{ $form['#field-label'] }}">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('fieldtype_rotation.set_rotation_for') }} {{ $form['#field-label'] }} 
            </button>
        </div>

        <div class="rotation-edit" @if (isset($form['#content']['#value']) && $form['#content']['#value'] == '') style="display:none" @endif>
            <div class="rotation-placeholder" style="margin-bottom:10px"><i class="fa fa-repeat" aria-hidden="true" style="font-size:60px"></i></div>
            <button type="button" class="btn btn-primary add-edit-rotation-btn" data-space-id="{{ $space_id }}" data-contenttype-name="{{ $contenttype_name }}" data-subject-field-type="{{ $form['#field-type'] }}" data-subject-field-name="{{ $form['#field-name'] }}" data-subject-field-label="{{ $form['#field-label'] }}">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('fieldtype_rotation.change_rotation_for') }} {{ $form['#field-label'] }}
            </button>
            <button type="button" class="btn btn-primary remove-rotation-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('fieldtype_rotation.remove_rotation') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


