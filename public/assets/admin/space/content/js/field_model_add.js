jQuery(document).ready(function($) {

    $('.remove-model-btn').click(function(e) {

        $(e.target).parent().parent().find('.model-id').val('');
        $(e.target).parent().parent().find('.model-add').show();
        $(e.target).parent().parent().find('.model-edit').hide();
    });

});


