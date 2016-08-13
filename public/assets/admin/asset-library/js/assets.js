jQuery(document).ready(function($) {


    $('.asset-library-nav a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        currTabTarget = $(e.target).attr('href');

        var remoteUrl = $(this).attr('data-tab-remote');
        if (remoteUrl !== '') {                
            $(currTabTarget).load(remoteUrl);
        } 
    });


    $('button').on('click', function() {

        whichtab = $(this).data('opentab');
        $('.asset-library-nav').find(whichtab).tab('show');
    });


});
