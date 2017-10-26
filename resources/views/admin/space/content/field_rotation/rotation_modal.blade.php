<div class="modal fade" id="rotation" tabindex="-1" role="dialog" aria-labelledby="rotation">
    <div class="modal-dialog modal-lg" role="document" style="width:96%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">{{ trans('fieldtype_rotation.set_rotation_for') }}</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8 content-target">

                    @yield('scene-content')

                    </div><!-- col-md-8 //-->

                    <div class="col-md-4">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                {{ trans('fieldtype_rotation.click_and_drag_to_set_rotation') }}

                            </div>
                        </div><!-- panel //-->

                        @yield('scale-sidebar')

                    </div><!-- col-md-4 //-->

                </div><!-- row //-->

            </div>
            <div class="modal-footer">
                <a role="button" class="btn btn-success insert-btn" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('fieldtype_rotation.insert') }}</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fieldtype_rotation.close') }}</button>
            </div>
        </div>
    </div>
</div>
