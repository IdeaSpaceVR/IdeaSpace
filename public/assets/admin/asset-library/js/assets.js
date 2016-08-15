jQuery(document).ready(function($) {


    $('.asset-library-nav a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var currTabTarget = $(e.target).attr('href');
        var remoteUrl = $(this).attr('data-tab-remote');

        if (remoteUrl !== '') {                
            $(currTabTarget).load(remoteUrl);
        } 
    });


    $('.form-control-add-file button').on('click', function() {

        var whichtab = $(this).data('opentab');
        $('.asset-library-nav').find(whichtab).tab('show');
    });


});
