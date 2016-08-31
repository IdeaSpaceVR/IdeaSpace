jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) {

        $('.upload-area').addClass('visible');
        $('.upload-area').show();
    }


});

