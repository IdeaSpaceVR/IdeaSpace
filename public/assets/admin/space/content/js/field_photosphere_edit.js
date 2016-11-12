jQuery(document).ready(function($) {

    $('.remove-photosphere-btn').click(function(e) {

        $(e.target).parent().parent().find('.photosphere-id').val('');
        $(e.target).parent().parent().find('.photosphere-add').show();
        $(e.target).parent().parent().find('.photosphere-edit').hide();
    });

});


