<div class="modal fade" id="rotation" tabindex="-1" role="dialog" aria-labelledby="rotation">
    <div class="modal-dialog modal-lg" role="document" style="width:96%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">{{ trans('fieldtype_painter.painter') }}</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8 content-target">

										<iframe>
                    @yield('scene-content')
										</iframe>

                    </div><!-- col-md-8 //-->

                    <div class="col-md-4">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                {{ trans('fieldtype_painter.enter_vr_to_paint') }}

                            </div>
                        </div><!-- panel //-->

                    </div><!-- col-md-4 //-->

                </div><!-- row //-->

            </div>
            <div class="modal-footer">
                <a role="button" class="btn btn-success insert-btn" data-dismiss="modal"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('fieldtype_painter.insert') }}</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fieldtype_painter.close') }}</button>
            </div>
        </div>
    </div>
</div>
