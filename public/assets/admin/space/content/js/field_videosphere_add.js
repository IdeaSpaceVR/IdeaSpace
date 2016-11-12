jQuery(document).ready(function($) {

    $('.remove-videosphere-btn').click(function(e) {

        $(e.target).parent().parent().find('.videosphere-id').val('');
        $(e.target).parent().parent().find('.videosphere-add').show();
        $(e.target).parent().parent().find('.videosphere-edit').hide();
    });

});


