jQuery(document).ready(function($) {

    $('.remove-image-btn').click(function(e) {

        $(e.target).parent().parent().find('.image-id').val('');
        $(e.target).parent().parent().find('.image-add').show();
        $(e.target).parent().parent().find('.image-edit').hide();
    });

});


