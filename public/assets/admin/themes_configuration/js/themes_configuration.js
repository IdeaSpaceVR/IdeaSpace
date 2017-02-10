jQuery(document).ready(function($) {

    $('.theme-btn').click(function() { 

        var self = this;

        $.ajax({
            url: window.ideaspace_site_path + '/admin/themes',
            type: 'post',
            cache: false,
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
            data: {'id': $(self).parent().parent().parent().parent().find('input[type=hidden]').val(), 'theme_status': $(self).attr('data-theme-status') },
            success: function(data) {
                $(self).html(data.status_text);
                $(self).attr('data-theme-status', data.status);
                if ($(self).parent().parent().find('.installed').css('visibility') == 'visible') {
                    $(self).parent().parent().find('.installed').css('visibility', 'hidden'); 
                } else {
                    $(self).parent().parent().find('.installed').css('visibility', 'visible'); 
                }
            }
        });    
    });    

});

