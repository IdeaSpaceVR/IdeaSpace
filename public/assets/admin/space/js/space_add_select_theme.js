jQuery(document).ready(function($) {

    $('.thumbnail').click(function() { 

        $.ajax({
            url: 'select-theme',
            type: 'post',
            cache: false,
            headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
            data: {'id': $(this).find('input[type=hidden]').val() },
            success: function(data) {
              window.location.href = data.redirect;
            }
        });   

    });   

});

