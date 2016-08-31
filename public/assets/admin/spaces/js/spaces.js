jQuery(document).ready(function($) {

    /* touch */
    $('.space-title .title').click(function(e) {
        $('.space-title .title').parent().parent().find('.space-actions').hide();
        $(this).parent().parent().find('.space-actions').show();
    });

    $('.space-title').hover(function() {
        $(this).find('.space-actions').show();
    }, function() {
        $(this).find('.space-actions').hide();
    });

});

