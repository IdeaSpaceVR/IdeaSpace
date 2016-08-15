<div class="modal fade" id="assets" tabindex="-1" role="dialog" aria-labelledby="assets">
    <div class="modal-dialog modal-lg" role="document" style="width:96%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assets</h4>
            </div>
            <div class="modal-body">

@include('admin.asset_library.assets_partial')

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('template_asset_library.close') }}</button>
            </div>
        </div>
    </div>
</div>
