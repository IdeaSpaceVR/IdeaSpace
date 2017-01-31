jQuery(document).ready(function($) {

    $('.remove-position-btn').click(function(e) {

        $(e.target).parent().parent().find('.position-id').val('');
        $(e.target).parent().parent().find('.position-add').show();
        $(e.target).parent().parent().find('.position-edit').hide();
    });


    /* click on positions button and get file id of subject, if it exists */
    var positions_add_edit_click_handler = function(e) {

        var space_id = $(e.target).attr('data-space-id');
        var contenttype_name = $(e.target).attr('data-contenttype-name');

        var subject_type = $(e.target).attr('data-subject-field-type');
        var subject_name = $(e.target).attr('data-subject-field-name');

        var subject_id = '';
        subject_id = $('input[name="' + subject_name + '"]').val();

        $('#positions .modal-body .content-target').load(window.ideaspace_site_path + '/admin/space/' + space_id + '/edit/' + contenttype_name + '/positions/subject/' + subject_type + '/' + subject_id, function() {

            /* set height dynamically, because of mobile */
            $('#positions .modal-body a-scene').css('max-height', '600px');
            $('#positions .modal-body a-scene').css('height', $(window).height() * 0.6);

            $('#positions').on('shown.bs.modal', function() {
                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            });

            $('#positions').modal('show');
        });

    };
    $('.add-edit-positions-btn').unbind('click');
    $('.add-edit-positions-btn').click(positions_add_edit_click_handler);


});


