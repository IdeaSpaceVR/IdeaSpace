jQuery(document).ready(function($) {

    $('.remove-audio-btn').click(function(e) {

        $(e.target).parent().parent().find('.audio-id').val('');
        $(e.target).parent().parent().find('.audio-add').show();
        $(e.target).parent().parent().find('.audio-edit').hide();
    });

});


