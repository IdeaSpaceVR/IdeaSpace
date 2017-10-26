jQuery(document).ready(function($) {

    /* click on rotation button */
    var rotation_add_edit_click_handler = function(e) {

        /* needed for insert operation */
        window.open_fieldtype_rotation_ref = $(this).parent().parent();

        var space_id = $(e.target).attr('data-space-id');
        var contenttype_name = $(e.target).attr('data-contenttype-name');

        var subject_type = $(e.target).attr('data-subject-field-type');
        var subject_name = $(e.target).attr('data-subject-field-name');
        var subject_label = $(e.target).attr('data-subject-field-label');

        var subject_id = '';
        subject_id = $('input[name="' + subject_name + '"]').val();


        $('#rotation-target').load(window.ideaspace_site_path + '/admin/space/' + space_id + '/edit/' + contenttype_name + '/rotation/subject/' + subject_type + '/' + subject_id, function() {

            /* set height dynamically, because of mobile */
            $('#rotation .modal-body a-scene').css('max-height', '700px');
            $('#rotation .modal-body a-scene').css('height', $(window).height() * 0.7);

            $('#rotation .modal-title').text($('#rotation .modal-title').text() + ' ' + subject_label);

            $('#rotation').on('shown.bs.modal', function() {

                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);

                if (window.open_fieldtype_rotation_ref.find('.rotation-info').val() != '') {

                    if (subject_type == 'videosphere' || subject_type == 'photosphere') {

                        /* photosphere: set camera rotation */
                        /* videosphere: set camera rotation */
                        var rotation_subject = document.querySelector('#rotation-camera');
                        rotation_subject.setAttribute('rotation', jQuery.parseJSON(window.open_fieldtype_rotation_ref.find('.rotation-info').val()));

                    } else if (subject_type == 'model3d' || subject_type == 'image' || subject_type == 'video') {

                        /* set camera position (!) */
                        var rotation_subject = document.querySelector('#rotation-camera');

                        /* does component exist */
                        if (rotation_subject.getAttribute('orbit-controls') !== null) {
                            rotation_subject.setAttribute('orbit-controls', 'rotateTo', jQuery.parseJSON(window.open_fieldtype_rotation_ref.find('.rotation-info').val()));
                        }

                    }

                } 


                var rotation_scale_handler = function() {

                    if (subject_type == 'model3d') {

                        var subject = document.querySelector('#rotation-model');
                        subject.setAttribute('scale', $(this).val() + ' ' + $(this).val() + ' ' + $(this).val());

                    } else if (subject_type == 'image') {

                        var subject = document.querySelector('#rotation-image');
                        subject.setAttribute('scale', $(this).val() + ' ' + $(this).val() + ' ' + $(this).val());

                    } else if (subject_type == 'video') {

                        var subject = document.querySelector('#rotation-video');
                        subject.setAttribute('scale', $(this).val() + ' ' + $(this).val() + ' ' + $(this).val());
                    }
                }
                $('#rotation-target').unbind('change');
                $('#rotation-target').on('change', '.scale', rotation_scale_handler);
    
            });

            $('#rotation').modal('show');

        });

    };
    $('.add-edit-rotation-btn').unbind('click');
    $('.add-edit-rotation-btn').click(rotation_add_edit_click_handler);


    var rotation_insert_click_handler = function() {

        var field_type = window.open_fieldtype_rotation_ref.find('.add-edit-rotation-btn').attr('data-subject-field-type');

        if (field_type == 'videosphere' || field_type == 'photosphere') {

            /* photosphere: get camera rotation */
            /* videosphere: get camera rotation */
            var info = JSON.stringify(document.querySelector('#rotation-camera').getAttribute('rotation'));

        } else if (field_type == 'model3d' || field_type == 'image' || field_type == 'video') {

            /* get camera position (!) */
            var info = JSON.stringify(document.querySelector('#rotation-camera').getAttribute('position'));
        }

        window.open_fieldtype_rotation_ref.find('.rotation-info').val(info);

        if (window.open_fieldtype_rotation_ref.find('.rotation-add').css('display') != 'none') {
            window.open_fieldtype_rotation_ref.find('.rotation-add').hide();
            window.open_fieldtype_rotation_ref.find('.rotation-edit').show();
        }

//$(this).attr('href', '#' + window.open_fieldtype_positions_ref.parent().attr('id'));
    };
    $('#rotation-target').on('click', '.insert-btn', rotation_insert_click_handler);


    var rotation_remove_click_handler = function(e) {

        $(this).parent().parent().find('.rotation-info').val('');
        $(this).parent().parent().find('.rotation-add').show();
        $(this).parent().parent().find('.rotation-edit').hide();
    };
    window.rotation_remove_click_handler = rotation_remove_click_handler;
    $('.form-control-add-rotation .rotation-edit .remove-rotation-btn').click(window.rotation_remove_click_handler);          

    
});


