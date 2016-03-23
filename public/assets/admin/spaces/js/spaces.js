jQuery(document).ready(function($) {

    $('.space-title').hover(function() {
        $(this).find('.space-actions').show();
    }, function() {
        $(this).find('.space-actions').hide();
    });

});

