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

            $('#positions #content-selector').unbind('change');
            $('#positions #content-selector').change(window.positions_content_selector);

            $('#positions #btn-attach').unbind('click');
            $('#positions #btn-attach').click(window.positions_content_attach);

            $('#positions #btn-detach').unbind('click');
            $('#positions #btn-detach').click(window.positions_content_detach);

            $('#positions #content-scale').unbind('change');
            $('#positions #content-scale').change(window.positions_content_scale);

            var scene = document.querySelector('a-scene');
            scene.addEventListener('enter-vr', window.positions_reset_content_selector);

            $('#positions').modal('show');
        });

    };
    $('.add-edit-positions-btn').unbind('click');
    $('.add-edit-positions-btn').click(positions_add_edit_click_handler);


    var positions_content_selector = function() {

            if ($(this).val() == '') {
                document.querySelector('#reticle').setAttribute('visible', false);
                document.querySelector('#reticle-text').setAttribute('bmfont-text', { text: '', color: '#FFFFFF' });
                $('#positions #btn-attach').prop('disabled', true);
            } else {
                if ($('#positions #content-attached').attr('data-maxnumber-counter') < $('#positions #content-attached').attr('data-maxnumber')) {
                    document.querySelector('#reticle-text').setAttribute('bmfont-text', { text: $('#positions #content-selector option[value="' + $(this).val() + '"]').text(), color: '#FFFFFF' });
                    document.querySelector('#reticle').setAttribute('visible', true);
                    $('#positions #btn-attach').prop('disabled', false);
                }
            }

        $(this).blur();
    };
    window.positions_content_selector = positions_content_selector;
    $('#positions #content-selector').change(window.positions_content_selector);


    var positions_content_attach = function() {

        var entity = document.createElement('a-entity');
        var content = document.querySelector('#reticle-text');

        var id = new Date().getUTCMilliseconds();

        content.sceneEl.object3D.updateMatrixWorld();

        var position = new THREE.Vector3();
        position.setFromMatrixPosition( content.object3D.matrixWorld );

        var quaternion = new THREE.Quaternion();
        content.object3D.matrixWorld.decompose( new THREE.Vector3(), quaternion, new THREE.Vector3() );

        var rotation_radians = new THREE.Euler().setFromQuaternion(quaternion, 'YXZ');
        var rotation_y = THREE.Math.radToDeg(rotation_radians.y);

        entity.setAttribute('position', { x: position.x, y: position.y, z: position.z }); 
        entity.setAttribute('rotation', { x: 0, y: rotation_y, z: 0 }); 
        entity.setAttribute('bmfont-text', { text: $('#positions #content-selector option:selected').text(), color: '#FFFFFF' }); 
        entity.setAttribute('data-id', id);

        content.sceneEl.appendChild(entity);

        entity.setAttribute('visible', true); 

        $('#positions #content-attached').append($('<option>', {
            value: '{ "id": "' + id + '", "content_id": "' + $('#positions #content-selector option:selected').val() + '", "position": {"x": "' + position.x + '", "y": "' + position.y + '", "z": "' + position.z + '"}, "rotation": {"x": "0", "y": "' + rotation_y + '", "z": "0"}, "scale": { "x": "1.0", "y": "1.0", "z": "1.0" } }',
            text: $('#positions #content-selector option:selected').text()
        }));


        if ($('#positions #content-attached').attr('data-maxnumber-counter') < $('#positions #content-attached').attr('data-maxnumber')) {
            var maxnumber_counter = $('#positions #content-attached').attr('data-maxnumber-counter');
            maxnumber_counter++;
            $('#positions #content-attached').parent().find('#maxnumber').text(maxnumber_counter);
            $('#positions #content-attached').attr('data-maxnumber-counter', maxnumber_counter);
            if (maxnumber_counter >= $('#positions #content-attached').attr('data-maxnumber')) {
                $('#positions #btn-attach').prop('disabled', true);
            }
        } else {
            $('#positions #btn-attach').prop('disabled', true);
        }
    };
    window.positions_content_attach = positions_content_attach;
    $('#positions #btn-attach').click(window.positions_content_attach);


    var positions_content_detach = function() {

        var json = jQuery.parseJSON($('#positions #content-attached option:selected').val()); 
        var entity = $('#positions a-scene').find('[data-id="' + json.id + '"]'); 

        entity.remove(); 
        /* important: keep quotes as they are, otherwise value is not being found */
        $("#positions #content-attached option[value='" + $('#positions #content-attached option:selected').val() + "']").remove();
    };
    window.positions_content_detach = positions_content_detach;
    $('#positions #btn-detach').click(window.positions_content_detach);


    var positions_content_scale = function() {

        var json = jQuery.parseJSON($('#positions #content-attached option:selected').val()); 
        var entity = document.querySelector('a-entity[data-id="' + json.id + '"]');
        entity.setAttribute('scale', { x: parseFloat($(this).val()), y: parseFloat($(this).val()), z: parseFloat($(this).val()) });
        json.scale.x = $(this).val();
        json.scale.y = $(this).val();
        json.scale.z = $(this).val();
        $('#positions #content-attached option:selected').val(JSON.stringify(json));
    };
    window.positions_content_scale = positions_content_scale;
    $('#positions #content-scale').change(window.positions_content_scale);
    

    var positions_reset_content_selector = function() {

        document.querySelector('#reticle').setAttribute('visible', false);
        document.querySelector('#reticle-text').setAttribute('bmfont-text', { text: '', color: '#FFFFFF' });
        $('#positions #btn-attach').prop('disabled', true);
        $('#positions #content-selector').find('option:eq(0)').prop('selected', true);
    };
    window.positions_reset_content_selector = positions_reset_content_selector;

    
    var positions_content_attached_selector = function() {

        var camera = document.querySelector('a-camera'); 
        var camera_wrapper = document.querySelector('#camera'); 

        if ($(this).val() == '') {
            /* reset camera position and rotation */
            camera_wrapper.setAttribute('position', {x: 0, y:0, z:4});
            camera_wrapper.setAttribute('rotation', {x: 0, y:0, z:0});
            camera.setAttribute('position', {x: 0, y:0, z:0});
            camera.setAttribute('rotation', {x: 0, y:0, z:0});
            camera.setAttribute('position', {x: 0, y: 1.6, z: 0});            
            camera.setAttribute('rotation', {x: 0, y: 0, z: 0});            
            window.positions_reset_content_selector();
            $('#positions #btn-detach').prop('disabled', true);
            $('#positions #content-scale').prop('disabled', true);

            $('#positions #content-scale option[value="1.0"]').prop('selected', true); 
        } else {
            /* put camera in front of content */
            var json = jQuery.parseJSON($(this).val());
            camera_wrapper.setAttribute('position', {x: parseFloat(json.position.x), y: parseFloat(json.position.y), z: parseFloat(json.position.z)});
            camera_wrapper.setAttribute('rotation', {x: parseFloat(json.rotation.x), y: parseFloat(json.rotation.y), z: parseFloat(json.rotation.z)});
            /* it is not possible to add this one meter to the z position of the wrapper directly; why? */
            camera.setAttribute('position', {x: 0, y:0, z:1});
            camera.setAttribute('rotation', {x: 0, y:0, z:0});
            window.positions_reset_content_selector();
            $('#positions #btn-detach').prop('disabled', false);
            $('#positions #content-scale').prop('disabled', false);

            $('#positions #content-scale option[value="' + json.scale.x + '"]').prop('selected', true); 
        }

        $(this).blur();
    };
    window.positions_content_attached_selector = positions_content_attached_selector;
    $('#positions #content-attached').change(window.positions_content_attached_selector);


});


