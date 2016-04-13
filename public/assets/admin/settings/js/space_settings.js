jQuery(document).ready(function($) {

    $('input[name="front-page-display"]').click(function() {
        if ($('input[name="front-page-display"]:checked').val() == 'one-space') {
            $('select[name="space"]').removeAttr('disabled');
        } else {
            $('select[name="space"]').attr('disabled', true);
        }
    });
});
