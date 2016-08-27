jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    if ($('.asset-library-nav').find('#videospheres-tab').hasClass('auto-opentab')) {

        $('.upload-area').addClass('visible');
        $('.upload-area').show();
    }


});

