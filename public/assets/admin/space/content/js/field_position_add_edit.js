jQuery(document).ready(function($) {

    $('.remove-position-btn').click(function(e) {

        $(e.target).parent().parent().find('.position-id').val('');
        $(e.target).parent().parent().find('.position-add').show();
        $(e.target).parent().parent().find('.position-edit').hide();
    });


    var open_fieldtype_positions_ref = null;


    /* click on positions button and get file id of subject, if it exists */
    var positions_add_edit_click_handler = function(e) {

        /* needed for insert operation */
        open_fieldtype_positions_ref = $(this).parent().parent();

        var space_id = $(e.target).attr('data-space-id');
        var contenttype_name = $(e.target).attr('data-contenttype-name');

        var subject_type = $(e.target).attr('data-subject-field-type');
        var subject_name = $(e.target).attr('data-subject-field-name');
        var subject_label = $(e.target).attr('data-subject-field-label');
        var contenttype_reference_label = $(e.target).attr('data-contenttype-reference-label');
        var maxnumber_total = $(e.target).attr('data-maxnumber-total');

        var subject_id = '';
        subject_id = $('input[name="' + subject_name + '"]').val();


        $('#positions-target').load(window.ideaspace_site_path + '/admin/space/' + space_id + '/edit/' + contenttype_name + '/positions/subject/' + subject_type + '/' + subject_id, function() {

            /* set height dynamically, because of mobile */
            $('#positions .modal-body a-scene').css('max-height', '700px');
            $('#positions .modal-body a-scene').css('height', $(window).height() * 0.7);

            $('#positions').on('shown.bs.modal', function() {

                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            });

            /* set title */
            $('#positions .modal-title').text($('#positions .modal-title').text() + ' ' + subject_label);

            /* set tooltip */
            $('#positions #content-selector-label .glyphicon').attr('title', $('#positions #content-selector-label .glyphicon').attr('title') + ' ' + contenttype_reference_label + '.');
            $('#positions #content-selector-label').text($('#positions #content-selector-label').text() + ' (' + contenttype_reference_label + ').');

            $('[data-toggle="tooltip"]').tooltip();

            /* set maxnumber total */
            $('#positions #maxnumber-total').text(maxnumber_total);
            $('#positions #content-attached').attr('data-maxnumber', maxnumber_total);

            $('#positions #content-selector').unbind('change');
            $('#positions #content-selector').change(positions_content_selector);

            $('#positions #btn-attach').unbind('click');
            $('#positions #btn-attach').click(positions_content_attach);

            $('#positions #btn-detach').unbind('click');
            $('#positions #btn-detach').click(positions_content_detach);

            $('#positions #content-attached').unbind('change');
            $('#positions #content-attached').change(positions_content_attached_selector);

            $('#positions #navigation-center').unbind('click');
            $('#positions #navigation-center').click(positions_navigation_center_click_handler); 

            $('#positions #navigation-up').unbind('mousedown');
            $('#positions #navigation-up').mousedown(positions_navigation_up_mousedown_handler);

            $('#positions #navigation-up').unbind('mouseup');
            $('#positions #navigation-up').mouseup(positions_navigation_up_mouseup_handler);

            $('#positions #navigation-down').unbind('mousedown');
            $('#positions #navigation-down').mousedown(positions_navigation_down_mousedown_handler);

            $('#positions #navigation-down').unbind('mouseup');
            $('#positions #navigation-down').mouseup(positions_navigation_down_mouseup_handler);

            $('#positions #navigation-left').unbind('mousedown');
            $('#positions #navigation-left').mousedown(positions_navigation_left_mousedown_handler);

            $('#positions #navigation-left').unbind('mouseup');
            $('#positions #navigation-left').mouseup(positions_navigation_left_mouseup_handler);

            $('#positions #navigation-right').unbind('mousedown');
            $('#positions #navigation-right').mousedown(positions_navigation_right_mousedown_handler);

            $('#positions #navigation-right').unbind('mouseup');
            $('#positions #navigation-right').mouseup(positions_navigation_right_mouseup_handler);

            $('#positions .insert-btn').unbind('click');
            $('#positions .insert-btn').click(positions_insert_btn_click_handler);

            $('#positions #z-axis-minus').on('click', positions_z_axis_minus_handler); 

            $('#positions #z-axis-reset').on('click', positions_z_axis_reset_handler); 

            $('#positions #z-axis-plus').on('click', positions_z_axis_plus_handler); 


            var scene = document.querySelector('a-scene');
            scene.addEventListener('enter-vr', positions_reset_content_selector);

            var entity = document.querySelector('#camera'); 
            var position = new THREE.Vector3();
            var reticle_text = document.querySelector('#reticle-text');
            scene.addEventListener('loaded', function() {
                /* init */
                position.setFromMatrixPosition(reticle_text.object3D.matrixWorld);
            });

            /* clean up */
            $('#positions #content-selector option').not(':first').remove();
            /* clean up */
            $('#positions #content-attached option').not(':first').remove();
            /* reset counter */
            var maxnumber_counter = 0;
            $('#positions #maxnumber').text(maxnumber_counter);
            $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);

            /* init content selector */
            if (open_fieldtype_positions_ref.find('.content-selector').val() != '') {

                var json = jQuery.parseJSON(open_fieldtype_positions_ref.find('.content-selector').val());            
                $.each(json, function(index, value) {
                    $('#positions #content-selector').append($('<option>', {
                        value: JSON.stringify(value.id), text: value.title
                    }));
                });
            }


            /* init positions */           
            if (open_fieldtype_positions_ref.find('.positions-info').val() != '') {

                var json = jQuery.parseJSON(open_fieldtype_positions_ref.find('.positions-info').val()); 
                $.each(json, function(index, value) {
                    var content = document.querySelector('#reticle-text');

                    /* clean up */
                    var entity = document.querySelector('a-text[data-id="' + value.id + '"]');
                    if (entity != null) {
                        content.sceneEl.removeChild(entity);
                    }

                    entity = document.createElement('a-text');
                    entity.setAttribute('position', { x: value.position.x, y: value.position.y, z: value.position.z });
                    //entity.setAttribute('rotation', { x: 0, y: value.rotation.y, z: 0 });
                    entity.setAttribute('rotation', { x: value.rotation.x, y: value.rotation.y, z: 0 });
                    entity.setAttribute('scale', { x: value.scale.x, y: value.scale.y, z: value.scale.z });
                    entity.setAttribute('value', '[' + $('#positions #content-selector option[value="' + value.content_id + '"]').text() + ']');
                    entity.setAttribute('font', window.ideaspace_site_path + '/public/aframe/fonts/Roboto-msdf.json');
                    entity.setAttribute('align', 'center');
                    entity.setAttribute('width', '6');
                    entity.setAttribute('data-id', value.id);

                    var entity_dot = document.createElement('a-circle');
                    entity_dot.setAttribute('position', {x:0, y:-0.14, z:0});
                    entity_dot.setAttribute('color', 'red');
                    entity_dot.setAttribute('radius', 0.02);
                    entity.appendChild(entity_dot);

                    scene.appendChild(entity);                  

                    entity.setAttribute('visible', true);
                    $('#positions #content-attached').append($('<option>', {
                        value: JSON.stringify(value), text: $('#positions #content-selector option[value="' + value.content_id + '"]').text()
                    }));
                    /* counter */
                    if (parseInt($('#positions #content-attached').attr('data-maxnumber-counter')) < parseInt($('#positions #content-attached').attr('data-maxnumber'))) {
                        var maxnumber_counter = parseInt($('#positions #content-attached').attr('data-maxnumber-counter'));
                        maxnumber_counter++;
                        $('#positions #maxnumber').text(maxnumber_counter);
                        $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);
                        if (maxnumber_counter >= parseInt($('#positions #content-attached').attr('data-maxnumber'))) {
                            $('#positions #btn-attach').prop('disabled', true);
                        }
                    } else {
                        $('#positions #btn-attach').prop('disabled', true);
                    }

                }); /* each */

                $('#positions .insert-btn').show();

            } /* init positions */
   

            /* remove children after closing, otherwise there can be conflicts when loading a-frame assets via loading component */
            $('#positions-target .modal').on('hidden.bs.modal', function() {
                $('#positions-target').empty();
            });
 

            $('#positions').modal('show');

        });

    };
    $('.add-edit-positions-btn').unbind('click');
    $('.add-edit-positions-btn').click(positions_add_edit_click_handler);


    var positions_content_selector = function() {

        var camera = document.querySelector('#camera'); 
        var camera_wrapper = document.querySelector('#camera-wrapper'); 

        /* do not reset camera position */
        //camera_wrapper.setAttribute('position', {x: 0, y:0, z:0});
        //camera_wrapper.setAttribute('rotation', {x: 0, y:0, z:0});
        //camera.setAttribute('position', {x: 0, y: 1.6, z: 0});            
        //camera.setAttribute('rotation', {x: 0, y: 0, z: 0});            

        $('#positions #z-axis-counter').text('-2');

        if ($(this).val() == '') {
            document.querySelector('#reticle-text').setAttribute('visible', false);
            document.querySelector('#reticle-text').setAttribute('value', '');
            document.querySelector('#reticle-text').setAttribute('position', {x: 0, y: 0, z: -2});
            $('#positions #btn-attach').prop('disabled', true);
            $('#positions #z-axis-minus').prop('disabled', true);
            $('#positions #z-axis-reset').prop('disabled', true);
            $('#positions #z-axis-plus').prop('disabled', true);
        } else {
            if (parseInt($('#positions #content-attached').attr('data-maxnumber-counter')) < parseInt($('#positions #content-attached').attr('data-maxnumber'))) {
                document.querySelector('#reticle-text').setAttribute('value', '[' + $('#positions #content-selector option[value="' + $(this).val() + '"]').text() + ']');
                document.querySelector('#reticle-text').setAttribute('position', {x: 0, y: 0, z: -2});
                document.querySelector('#reticle-text').setAttribute('visible', true);
                $('#positions #btn-attach').prop('disabled', false);
                $('#positions #z-axis-minus').prop('disabled', false);
                $('#positions #z-axis-reset').prop('disabled', false);
                $('#positions #z-axis-plus').prop('disabled', false);
            }
        }

        $(this).blur();
    };


    var positions_content_attach = function(e) {

        var entity = document.createElement('a-text');
        var entity_dot = document.createElement('a-circle');
        entity_dot.setAttribute('position', {x:0, y:-0.14, z:0});
        entity_dot.setAttribute('color', 'red');
        entity_dot.setAttribute('radius', 0.02);

        var content = document.querySelector('#reticle-text');

        var id = new Date().getUTCMilliseconds();

        content.sceneEl.object3D.updateMatrixWorld();

        var position = new THREE.Vector3();
        position.setFromMatrixPosition( content.object3D.matrixWorld );

        var quaternion = new THREE.Quaternion();
        content.object3D.matrixWorld.decompose(new THREE.Vector3(), quaternion, new THREE.Vector3());

        var rotation_radians = new THREE.Euler().setFromQuaternion(quaternion, 'YXZ');
				var rotation_x = THREE.Math.radToDeg(rotation_radians.x);
        var rotation_y = THREE.Math.radToDeg(rotation_radians.y);

        entity.setAttribute('position', { x: position.x, y: position.y, z: position.z }); 
        entity.setAttribute('rotation', { x: 0, y: rotation_y, z: 0 }); 
        entity.setAttribute('value', '[' + $('#positions #content-selector option:selected').text() + ']'); 
        entity.setAttribute('font', window.ideaspace_site_path + '/public/aframe/fonts/Roboto-msdf.json');
        entity.setAttribute('align', 'center');
        entity.setAttribute('width', '6');
        entity.setAttribute('data-id', id);
        entity.appendChild(entity_dot);

        content.sceneEl.appendChild(entity);

        entity.setAttribute('visible', true); 

        $('#positions #content-attached').append($('<option>', {
            value: '{ "id": "' + id + '", "content_id": "' + $('#positions #content-selector option:selected').val() + '", "position": {"x": "' + position.x + '", "y": "' + position.y + '", "z": "' + position.z + '"}, "rotation": {"x": "' + rotation_x + '", "y": "' + rotation_y + '", "z": "0"}, "scale": { "x": "1.0", "y": "1.0", "z": "1.0" } }',
            text: $('#positions #content-selector option:selected').text()
        }));

        /* counter */
        if (parseInt($('#positions #content-attached').attr('data-maxnumber-counter')) < parseInt($('#positions #content-attached').attr('data-maxnumber'))) {
            var maxnumber_counter = parseInt($('#positions #content-attached').attr('data-maxnumber-counter'));
            maxnumber_counter++;
            $('#positions #maxnumber').text(maxnumber_counter);
            $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);
            if (maxnumber_counter >= parseInt($('#positions #content-attached').attr('data-maxnumber'))) {
                $('#positions #btn-attach').prop('disabled', true);
            }
        } else {
            $('#positions #btn-attach').prop('disabled', true);
        }

        $('#positions #z-axis-minus').prop('disabled', true);
        $('#positions #z-axis-reset').prop('disabled', true);
        $('#positions #z-axis-plus').prop('disabled', true);

        $('#positions .insert-btn').removeClass('btn-success').addClass('btn-default');

        setTimeout(function() {
            $('#positions .insert-btn').removeClass('btn-default').addClass('btn-success');
        }, 1000);

        $('#positions .insert-btn').show();

    };


    var positions_content_detach = function() {

        if ($('#positions #content-attached option:selected').val() != '') {
            var json = jQuery.parseJSON($('#positions #content-attached option:selected').val()); 
            var entity = $('#positions a-scene').find('[data-id="' + json.id + '"]'); 

            entity.remove(); 
            /* important: keep quotes as they are, otherwise value is not being found */
            $("#positions #content-attached option[value='" + $('#positions #content-attached option:selected').val() + "']").remove();

            /* counter */
            var maxnumber_counter = parseInt($('#positions #content-attached').attr('data-maxnumber-counter'));
            maxnumber_counter--;
            $('#positions #maxnumber').text(maxnumber_counter);
            $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);

            $('#positions .insert-btn').removeClass('btn-success').addClass('btn-default');

            setTimeout(function() {
                $('#positions .insert-btn').removeClass('btn-default').addClass('btn-success');
            }, 1000);

            if (maxnumber_counter < 1) {
                $('#positions .insert-btn').hide();
            }

            /* center camera */
            var camera = document.querySelector('#camera');
            var camera_wrapper = document.querySelector('#camera-wrapper');
            camera_wrapper.setAttribute('position', {x: 0, y:0, z:0});
            camera_wrapper.setAttribute('rotation', {x: 0, y:0, z:0});
            camera.setAttribute('position', {x: 0, y: 1.6, z: 0});
            camera.setAttribute('rotation', {x: 0, y: 0, z: 0});
        }
    };


    var positions_reset_content_selector = function() {

        document.querySelector('#reticle-text').setAttribute('visible', false);
        document.querySelector('#reticle-text').setAttribute('value', '');
        $('#positions #btn-attach').prop('disabled', true);
        $('#positions #content-selector').find('option:eq(0)').prop('selected', true);
        $('#positions #z-axis-counter').text('-2');
    };

    
    var positions_content_attached_selector = function() {

        var camera = document.querySelector('#camera'); 
        var camera_wrapper = document.querySelector('#camera-wrapper'); 

        if ($(this).val() == '') {
            /* reset camera position and rotation */
            camera_wrapper.setAttribute('position', {x: 0, y:0, z:0});
            camera_wrapper.setAttribute('rotation', {x: 0, y:0, z:0});
            camera.setAttribute('position', {x: 0, y: 1.6, z: 0});            
            camera.setAttribute('rotation', {x: 0, y: 0, z: 0});            
            positions_reset_content_selector();
            $('#positions #btn-detach').prop('disabled', true);

            $('#positions #reticle-position-x').text('-');
            $('#positions #reticle-position-y').text('-');
            $('#positions #reticle-position-z').text('-');

            $('#positions #reticle-rotation-x').text('-');
            $('#positions #reticle-rotation-y').text('-');
            $('#positions #reticle-rotation-z').text('-');

        } else {
            /* put camera in front of content */
            var json = jQuery.parseJSON($(this).val());
            camera_wrapper.setAttribute('position', {x: parseFloat(json.position.x), y: parseFloat(json.position.y), z: parseFloat(json.position.z)});
            camera_wrapper.setAttribute('rotation', {x: parseFloat(json.rotation.x), y: parseFloat(json.rotation.y), z: parseFloat(json.rotation.z)});
            /* it is not possible to add this one meter to the z position of the camera wrapper directly; why? */
            camera.setAttribute('position', {x: 0, y:0, z:2});
            camera.setAttribute('rotation', {x: 0, y:0, z:0});
            positions_reset_content_selector();
            $('#positions #btn-detach').prop('disabled', false);

            $('#positions #reticle-position-x').text(parseFloat(json.position.x).toFixed(2));
            $('#positions #reticle-position-y').text(parseFloat(json.position.y).toFixed(2));
            $('#positions #reticle-position-z').text(parseFloat(json.position.z).toFixed(2));

            $('#positions #reticle-rotation-x').text(parseFloat(json.rotation.x).toFixed(2));
            $('#positions #reticle-rotation-y').text(parseFloat(json.rotation.y).toFixed(2));
            $('#positions #reticle-rotation-z').text(parseFloat(json.rotation.z).toFixed(2));
        }

        $(this).blur();
    };


    var positions_navigation_center_click_handler = function() {
        
        var camera = document.querySelector('#camera'); 
        var camera_wrapper = document.querySelector('#camera-wrapper'); 

        camera_wrapper.setAttribute('position', {x: 0, y:0, z:0});
        camera_wrapper.setAttribute('rotation', {x: 0, y:0, z:0});
        camera.setAttribute('position', {x: 0, y: 1.6, z: 0});            
        camera.setAttribute('rotation', {x: 0, y: 0, z: 0});            
    };


    var positions_navigation_up_mousedown_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 87;
            window.fireEvent('onkeydown', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keydown', true, true);
            eventObj.which = 87; 
            eventObj.keyCode = 87;
            window.dispatchEvent(eventObj);
        }
    };
    var positions_navigation_up_mouseup_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 87;
            window.fireEvent('onkeyup', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keyup', true, true);
            eventObj.which = 87; 
            eventObj.keyCode = 87;
            window.dispatchEvent(eventObj);
        }
    };


    var positions_navigation_down_mousedown_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 83;
            window.fireEvent('onkeydown', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keydown', true, true);
            eventObj.which = 83; 
            eventObj.keyCode = 83;
            window.dispatchEvent(eventObj);
        }
    };
    var positions_navigation_down_mouseup_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 83;
            window.fireEvent('onkeyup', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keyup', true, true);
            eventObj.which = 83; 
            eventObj.keyCode = 83;
            window.dispatchEvent(eventObj);
        }
    };


    var positions_navigation_left_mousedown_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 65;
            window.fireEvent('onkeydown', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keydown', true, true);
            eventObj.which = 65; 
            eventObj.keyCode = 65;
            window.dispatchEvent(eventObj);
        }
    };
    var positions_navigation_left_mouseup_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 65;
            window.fireEvent('onkeyup', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keyup', true, true);
            eventObj.which = 65; 
            eventObj.keyCode = 65;
            window.dispatchEvent(eventObj);
        }
    };


    var positions_navigation_right_mousedown_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 68;
            window.fireEvent('onkeydown', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keydown', true, true);
            eventObj.which = 68; 
            eventObj.keyCode = 68;
            window.dispatchEvent(eventObj);
        }
    };
    var positions_navigation_right_mouseup_handler = function() {

        if (document.createEventObject) {
            var eventObj = document.createEventObject();
            eventObj.keyCode = 68;
            window.fireEvent('onkeyup', eventObj);
        } else if (document.createEvent) {
            var eventObj = document.createEvent('Events');
            eventObj.initEvent('keyup', true, true);
            eventObj.which = 68; 
            eventObj.keyCode = 68;
            window.dispatchEvent(eventObj);
        }
    };


    var positions_insert_btn_click_handler = function() {

        var value = '[';
        $('#positions #content-attached option').each(function() {
            if ($(this).val() != '' && $(this).val() != null) {
                value = value + $(this).val() + ',';
            }
        });
        value = value.substring(0, value.length - 1);
        value = value + ']';

        open_fieldtype_positions_ref.find('.positions-info').val(value);
        if (open_fieldtype_positions_ref.find('.positions-add').css('display') != 'none') {
            open_fieldtype_positions_ref.find('.positions-add').hide();
            open_fieldtype_positions_ref.find('.positions-edit').show();
        }

        location.hash = '#' + open_fieldtype_positions_ref.parent().attr('id');
    };


    $('.form-control-add-positions .positions-edit .remove-positions-btn').click(function() {

        /* clean up */
        $('#positions #content-attached option').not(':first').remove();

        var json = jQuery.parseJSON($(this).parent().parent().find('.positions-info').val());

        $.each(json, function(index, value) {
            var content = document.querySelector('#reticle-text');
            /* clean up */
            var entity = document.querySelector('a-text[data-id="' + value.id + '"]');
            if (entity != null) {
                content.sceneEl.removeChild(entity);
            }
            /* counter */
            var maxnumber_counter = 0;
            $('#positions #maxnumber').text(maxnumber_counter);
            $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);
        });

        $(this).parent().parent().find('.positions-info').val('');
        $(this).parent().parent().find('.positions-add').show();
        $(this).parent().parent().find('.positions-edit').hide();
    });

  
    var positions_z_axis_minus_handler = function() {

        var content = document.querySelector('#reticle-text');
        var pos = content.getAttribute('position');
        if (pos.z < -2) {
            content.setAttribute('position', { x: pos.x, y: pos.y, z: pos.z+1 }); 
            $('#positions #z-axis-counter').text(pos.z+1);
        }
    };


    var positions_z_axis_reset_handler = function() {
 
        var content = document.querySelector('#reticle-text');
        content.setAttribute('position', { x: 0, y: 0, z: -2 }); 
        $('#positions #z-axis-counter').text('-2');
        
    };


    var positions_z_axis_plus_handler = function() {

        var content = document.querySelector('#reticle-text');
        var pos = content.getAttribute('position');
        content.setAttribute('position', { x: pos.x, y: pos.y, z: pos.z-1 }); 
        $('#positions #z-axis-counter').text(pos.z-1);
    };


});


