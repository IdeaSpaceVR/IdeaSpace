<div class="modal fade" id="positions" tabindex="-1" role="dialog" aria-labelledby="positions">
    <div class="modal-dialog modal-lg" role="document" style="width:96%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">{{ trans('fieldtype_position.attach') }} &amp; {{ trans('fieldtype_position.detach') }} {{ $form['#content-label'] }}</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-8 content-target">

                        @if ($form['#field-type'] == '' && $form['#field-name'] == '')

                            @include('admin.space.content.field_position.positions_blank_partial')

                        @endif

                    </div><!-- col-md-8 //-->

                    <div class="col-md-4">

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <div class="form-group" style="margin-bottom:0px">
                                    <label for="content-selector">{{ trans('fieldtype_position.available') }} {{ $form['#content-label'] }}</label>

                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 text-center">
                                            <div class="form-inline">
                                                <select class="form-control" id="content-selector" autocomplete="off" style="min-width:150px;margin-bottom:20px">
                                                    <option value="">{{ trans('fieldtype_position.select') }}</option>
                                                    @foreach ($form['#contents'] as $content)
                                                    <option value="{{ $content->id }}">{{ $content->title }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary" type="button" id="btn-attach" disabled="disabled" style="margin-bottom:20px">{{ trans('fieldtype_position.attach') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom:0">
                                    <label>{{ trans('fieldtype_position.navigation') }}</label>

                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4 text-center">
                                            <button class="btn btn-default" type="button" id="navigation-up">
                                                <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> {{ trans('fieldtype_position.w') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:5px">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-default" type="button" id="navigation-left">
                                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> {{ trans('fieldtype_position.a') }}
                                            </button>
                                            <button class="btn btn-default" type="button" id="navigation-up">
                                                <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 
                                            </button>
                                            <button class="btn btn-default" type="button" id="navigation-right">
                                                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> {{ trans('fieldtype_position.d') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:5px">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-default" type="button" id="navigation-down">
                                                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> {{ trans('fieldtype_position.s') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group" style="margin-bottom:0">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 text-center">
                                            <button class="btn btn-default" type="button" id="navigation-up">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                            <button class="btn btn-default" type="button" id="navigation-up">
                                                {{ trans('fieldtype_position.reset') }} 
                                            </button>
                                            <button class="btn btn-default" type="button" id="navigation-up">
                                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- panel //-->

                        <div class="panel panel-default">

                            <div class="panel-body">

                                <div class="form-group" style="margin-bottom:0">
                                    <label for="content-attached">{{ trans('fieldtype_position.attached') }} {{ $form['#content-label'] }} (<span id="maxnumber">0</span> {{ trans('fieldtype_position.out_of') }} {{ $form['#maxnumber'] }})</label>

                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 text-center">
                                            <div class="form-inline">
                                                <select class="form-control" id="content-attached" autocomplete="off" data-maxnumber="{{ $form['#maxnumber'] }}" data-maxnumber-counter="0" style="min-width:150px;margin-bottom:20px">
                                                    <option value="">{{ trans('fieldtype_position.select') }}</option>
                                                </select>
                                                <button class="btn btn-primary" type="button" id="btn-detach" disabled="disabled" style="margin-bottom:20px">{{ trans('fieldtype_position.detach') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-bottom:0">
                                    <label for="content-scale">{{ trans('fieldtype_position.scale') }}</label>

                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 text-center">
                                            <div class="form-inline">
                                                <select class="form-control" id="content-scale" autocomplete="off" style="min-width:220px" disabled="disabled">
                                                    <option value="0.01">{{ trans('fieldtype_position.scale_0_0_1') }}</option>
                                                    <option value="0.02">{{ trans('fieldtype_position.scale_0_0_2') }}</option>
                                                    <option value="0.03">{{ trans('fieldtype_position.scale_0_0_3') }}</option>
                                                    <option value="0.04">{{ trans('fieldtype_position.scale_0_0_4') }}</option>
                                                    <option value="0.05">{{ trans('fieldtype_position.scale_0_0_5') }}</option>
                                                    <option value="0.06">{{ trans('fieldtype_position.scale_0_0_6') }}</option>
                                                    <option value="0.07">{{ trans('fieldtype_position.scale_0_0_7') }}</option>
                                                    <option value="0.08">{{ trans('fieldtype_position.scale_0_0_8') }}</option>
                                                    <option value="0.09">{{ trans('fieldtype_position.scale_0_0_9') }}</option>
                                                    <option value="0.1">{{ trans('fieldtype_position.scale_0_1') }}</option>
                                                    <option value="0.2">{{ trans('fieldtype_position.scale_0_2') }}</option>
                                                    <option value="0.3">{{ trans('fieldtype_position.scale_0_3') }}</option>
                                                    <option value="0.4">{{ trans('fieldtype_position.scale_0_4') }}</option>
                                                    <option value="0.5">{{ trans('fieldtype_position.scale_0_5') }}</option>
                                                    <option value="0.6">{{ trans('fieldtype_position.scale_0_6') }}</option>
                                                    <option value="0.7">{{ trans('fieldtype_position.scale_0_7') }}</option>
                                                    <option value="0.8">{{ trans('fieldtype_position.scale_0_8') }}</option>
                                                    <option value="0.9">{{ trans('fieldtype_position.scale_0_9') }}</option>
                                                    <option value="1.0" selected="selected">{{ trans('fieldtype_position.scale_1_0') }}</option>
                                                    <option value="1.1">{{ trans('fieldtype_position.scale_1_1') }}</option>
                                                    <option value="1.2">{{ trans('fieldtype_position.scale_1_2') }}</option>
                                                    <option value="1.3">{{ trans('fieldtype_position.scale_1_3') }}</option>
                                                    <option value="1.4">{{ trans('fieldtype_position.scale_1_4') }}</option>
                                                    <option value="1.5">{{ trans('fieldtype_position.scale_1_5') }}</option>
                                                    <option value="1.6">{{ trans('fieldtype_position.scale_1_6') }}</option>
                                                    <option value="1.7">{{ trans('fieldtype_position.scale_1_7') }}</option>
                                                    <option value="1.8">{{ trans('fieldtype_position.scale_1_8') }}</option>
                                                    <option value="1.9">{{ trans('fieldtype_position.scale_1_9') }}</option>
                                                    <option value="2.0">{{ trans('fieldtype_position.scale_2_0') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div><!-- panel //-->

                    </div><!-- col-md-4 //-->

                </div><!-- row //-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fieldtype_position.close') }}</button>
            </div>
        </div>
    </div>
</div>
