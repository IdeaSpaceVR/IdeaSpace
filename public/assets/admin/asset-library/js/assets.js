jQuery(document).ready(function($) {

    
    /* for initial active tab */
    $('[data-toggle="tooltip"]').tooltip();


    $('.asset-library-nav a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var currTabTarget = $(e.target).attr('href');
        var remotePageUrl = $(this).attr('data-tab-remote');
        var remoteScriptUrl = $(this).attr('data-tab-remote-script');

        if (remotePageUrl !== '') {                
            $(currTabTarget).load(remotePageUrl, function() {
                if (remoteScriptUrl !== '') {
                    $.getScript(remoteScriptUrl);
                }
            });
        } 
    });


    $('.form-control-add-file button').on('click', function() {

        var whichtab = $(this).data('opentab');
        $('.asset-library-nav').find(whichtab).tab('show');
    });


});
