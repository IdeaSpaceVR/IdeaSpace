jQuery(document).ready(function($) {

    $('.theme-btn').click(function() { 

        var self = this;

        $.ajax({
            url: 'themes',
            type: 'post',
            cache: false,
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
            data: {'id': $(self).parent().parent().parent().parent().find('input[type=hidden]').val(), 'status_text': $(self).html() },
            success: function(data) {
                $(self).html(data.status_text);
                if ($(self).parent().parent().find('.installed').css('display') == 'inline') {
                    $(self).parent().parent().find('.installed').hide(); 
                } else {
                    $(self).parent().parent().find('.installed').show(); 
                }
            }
        });    
    });    

});

