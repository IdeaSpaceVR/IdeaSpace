jQuery(document).ready(function($) {

    /* touch */
    $('.space-title a.title').click(function(e) {
        e.preventDefault();
        $('.space-title a').parent().parent().find('.space-actions').hide();
        $(this).parent().parent().find('.space-actions').show();
    });

    $('.space-title').hover(function() {
        $(this).find('.space-actions').show();
    }, function() {
        $(this).find('.space-actions').hide();
    });

});

