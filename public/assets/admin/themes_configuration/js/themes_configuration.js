jQuery(document).ready(function($) {

    $('.theme-btn').click(function() { 

        var self = this;

        $.ajax({
            url: 'themes',
            type: 'post',
            cache: false,
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
            data: {'id': $(this).parent().parent().parent().parent().find('input[type=hidden]').val(), 'status_text': $(this).html() },
            success: function(data) {
                $(self).html(data.status_text);
            }
        });    
    });    

});

