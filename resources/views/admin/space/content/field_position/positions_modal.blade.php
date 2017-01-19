<div class="modal fade" id="positions" tabindex="-1" role="dialog" aria-labelledby="positions">
    <div class="modal-dialog modal-lg" role="document" style="width:96%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">{{ trans('fieldtype_position.add_edit_positions') }}</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8 content-target">

                        @if ($form['#field-type'] == '' && $form['#field-name'] == '')

                            @include('admin.space.content.field_position.positions_blank_partial')

                        @endif

                    </div><!-- col-md-8 //-->

                    <div class="col-md-4">

                        <div class="well">
                        </div>

                    </div><!-- col-md-4 //-->

                </div><!-- row //-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fieldtype_position.close') }}</button>
            </div>
        </div>
    </div>
</div>
