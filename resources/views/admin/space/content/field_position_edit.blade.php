
@include('admin.space.content.field_position.positions_modal')

<div id="{{ $field_id }}" class="form-group {{ $errors->has($field_id)?'has-error':'' }}">
    <div>
        <label class="control-label large">{{ $form['#label'] }}</label>
    </div>
    <div class="form-control-add-positions text-center {{ $errors->has($field_id)?'has-error':'' }}">

        <input type="hidden" @if (isset($form['#content']['#id'])) value="{{ $form['#content']['#id'] }}" @else value="" @endif name="{{ $field_id }}" class="positions-id">

        <div class="positions-add" @if (isset($form['#content']['#value'])) style="display:none" @endif>
            <button type="button" class="btn btn-primary btn-lg add-edit-positions-btn" data-space-id="{{ $space_id }}" data-contenttype-name="{{ $contenttype_name }}" data-subject-field-type="{{ $form['#field-type'] }}" data-subject-field-name="{{ $form['#field-name'] }}">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('fieldtype_position.add_positions') }} 
            </button>
        </div>

        <div class="positions-edit" @if (!isset($form['#content']['#value'])) style="display:none" @endif>
            <div class="positions-placeholder" style="margin-bottom:10px"><i class="fa fa-crosshairs" aria-hidden="true" style="font-size:60px"></i></div>
            <button type="button" class="btn btn-primary add-edit-positions-btn" data-space-id="{{ $space_id }}" data-contenttype-name="{{ $contenttype_name }}" data-subject-field-type="{{ $form['#field-type'] }}" data-subject-field-name="{{ $form['#field-name'] }}">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{ trans('fieldtype_position.edit_positions') }}
            </button>
            <button type="button" class="btn btn-primary remove-positions-btn">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> {{ trans('fieldtype_position.remove_all_positions') }}
            </button>
        </div>

    </div>
    <span class="info-block">{{ $form['#help'] }} @if ($form['#required'] == true) <span class="label label-danger">{{ trans('template_fields.required') }}</span>@endif</span>
    {!! $errors->has($field_id)?$errors->first($field_id, '<span class="help-block">:message</span>'):'' !!}
</div>


