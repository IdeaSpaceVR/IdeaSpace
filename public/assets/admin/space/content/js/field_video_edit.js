jQuery(document).ready(function($) {

    $('.remove-video-btn').click(function(e) {

        $(e.target).parent().parent().find('.video-id').val('');
        $(e.target).parent().parent().find('.video-add').show();
        $(e.target).parent().parent().find('.video-edit').hide();
    });

});


