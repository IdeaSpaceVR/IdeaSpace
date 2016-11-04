jQuery(document).ready(function($) {

    
    /* for initial active tab */
    $('[data-toggle="tooltip"]').tooltip();


    $('.asset-library-nav a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var currTabTarget = $(e.target).attr('href');
        var remotePageUrl = $(this).attr('data-tab-remote');
        var remoteScriptUrl = $(this).attr('data-tab-remote-script');

        $('.upload-area').removeClass('visible');
        $('.upload-area').hide();

        if (remotePageUrl !== '') {                
            $(currTabTarget).load(remotePageUrl, function() {
                if (remoteScriptUrl !== '') {
                    $('.upload-area .close').click(window.upload_area_close_handler);
                    $.getScript(remoteScriptUrl);
                }
            });
        } 
    });


    $('.form-control-add-file button').on('click', function(e) {

        var whichtab = $(this).attr('data-opentab');
        $('.asset-library-nav').find('.auto-opentab').removeClass('auto-opentab');
        $('.asset-library-nav').find(whichtab).addClass('auto-opentab');
        $('.asset-library-nav').find(whichtab).tab('show');

        /* needed for insert operation */
        window.open_asset_library_ref = $(this).parent().parent();

        /* when opened from space content edit page, allow single file uploads and show upload area */
        /* UPDATE: multiple file uploads needed for 3D model and texture files */
        //$('.upload-area').find('input[type="file"]').removeAttr('multiple');
        $('.upload-area').addClass('visible');
        $('.upload-area').show();
        
        $('.files .insert-link').show();
    });


    var add_new_asset_handler = function() {

        if ($('.upload-area').hasClass('visible')) {
            $('.upload-area').removeClass('visible');
            $('.upload-area').hide();
        } else {
            $('.upload-area').addClass('visible');
            $('.upload-area').show();
        }
    };
    window.add_new_asset_handler = add_new_asset_handler;
    $('#add-new-asset').click(window.add_new_asset_handler);


    var upload_area_close_handler = function() {

        $('.upload-area').removeClass('visible');
        $('.upload-area').hide();
    };
    window.upload_area_close_handler = upload_area_close_handler;
    $('.upload-area .close').click(window.upload_area_close_handler);


});


