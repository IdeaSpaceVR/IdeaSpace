jQuery(document).ready(function($) {

    /* click on painter button */
    var painter_add_edit_click_handler = function(e) {

        /* needed for insert operation */
        //open_fieldtype_rotation_ref = $(this).parent().parent();

        var space_id = $(e.target).attr('data-space-id');
        var contenttype_name = $(e.target).attr('data-contenttype-name');
        var scene_template = $(e.target).attr('data-scene-template');
        var content_id = $(e.target).attr('data-content-id');

        //var subject_type = $(e.target).attr('data-subject-field-type');
        //var subject_name = $(e.target).attr('data-subject-field-name');
        //var subject_label = $(e.target).attr('data-subject-field-label');

        //var subject_id = '';
        //subject_id = $('input[name="' + subject_name + '"]').val();

				document.getElementById('painter-iframe').onload = function() {

            /* set height dynamically, because of mobile */
            $('#painter-iframe').css('height', $(window).height() * 0.5);

            //$('#painter .modal-title').text($('#painter .modal-title').text() + ' ' + subject_label);

						var doc = document.getElementById('painter-iframe').contentWindow.document;
				
						var script = document.createElement('script');

						script.src = window.ideaspace_site_path + '/public/a-painter/vendor/aframe-input-mapping-component.js';
						doc.head.appendChild(script);

						script.src = window.ideaspace_site_path + '/public/a-painter/build.js';
						doc.head.appendChild(script);

						script.src = window.ideaspace_site_path + '/public/a-painter/vendor/aframe-teleport-controls.min.js';
						doc.head.appendChild(script);

						script.src = window.ideaspace_site_path + '/public/a-painter/vendor/aframe-tooltip-component.min.js';
						doc.head.appendChild(script);

						var link = document.createElement('link');
						link.rel = 'stylesheet';
						link.href = window.ideaspace_site_path + '/public/a-painter/css/main.css';
						doc.head.appendChild(link);

						link.rel = 'manifest';
						link.href = window.ideaspace_site_path + '/public/a-painter/manifest.webmanifest';
						doc.head.appendChild(link);

						var scene = doc.querySelector('a-scene');
						var assets = doc.querySelector('a-assets');

						var img = document.createElement('img');
						img.id = 'uinormal';
						img.src = window.ideaspace_site_path + '/public/a-painter/assets/images/ui-normal.png';
						img.crossorigin = 'anonymous';
						assets.appendchild(img);

						img = document.createElement('img');
						img.id = 'floor';
						img.src = window.ideaspace_site_path + '/public/a-painter/assets/images/floor.jpg';
						img.crossorigin = 'anonymous';
						assets.appendchild(img);

						var asset_item = document.createElement('a-asset-item');
						asset_item.id = 'logoobj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/logo.obj';
						assets.appendchild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'logomtl';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/logo.mtl';
						assets.appendchild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'uiobj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/ui.obj';
						assets.appendchild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'hitEntityObj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/teleportHitEntity.obj';
						assets.appendchild(asset_item);

						var audio = document.createElement('audio');
						asset_item.id = 'ui_click0';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_click0.ogg';
						assets.appendchild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_click1';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_click1.ogg';
						assets.appendchild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_menu';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_menu.ogg';
						assets.appendchild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_undo';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_undo.ogg';
						assets.appendchild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_tick';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_tick.ogg';
						assets.appendchild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_paint';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_paint.ogg';
						assets.appendchild(asset_item);

						var entity = document.createElement('a-light');
						entity.setAttribute('type', 'point');
						entity.setAttribute('light', { color: '#fff', intensity: 0.6 });
						entity.setAttribute('position', { x:3, y:10, z:1 });
						scene.appendchild(entity);

						entity = document.createElement('a-light');
						entity.setAttribute('type', 'point');
						entity.setAttribute('light', { color: '#fff', intensity: 0.2 });
						entity.setAttribute('position', { x:-3, y:-10, z:0 });
						scene.appendchild(entity);

						entity = document.createElement('a-light');
						entity.setAttribute('type', 'hemisphere');
						entity.setAttribute('light', { color: '#888', intensity: 0.8 });
						scene.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'logo';
						entity.setAttribute('obj-model', { obj: '#logoobj', mtl: '#logomtl' });
						scene.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'ground';
						entity.setAttribute('geometry', { primitive: 'box', width: 12, height: 0.01, depth: 12 });
						entity.setAttribute('material', { shader: 'flat', src: '#floor' });
						scene.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'hitEntityLeft';
						entity.setAttribute('material', { shader: 'flat', color: '#ff3468' });
						entity.setAttribute('obj-model', { obj: '#hitEntityObj' });
						scene.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'hitEntityRight';
						entity.setAttribute('material', { shader: 'flat', color: '#ff3468' });
						entity.setAttribute('obj-model', { obj: '#hitEntityObj' });
						scene.appendchild(entity);

						var camera_rig = document.createElement('a-entity');
						camera_rig.id = 'cameraRig';
						scene.appendchild(camera_rig);

						entity = document.createElement('a-entity');
						entity.id = 'acamera';
						entity.setAttribute('camera', {});
						entity.setAttribute('wasd-controls', {});
						entity.setAttribute('look-controls', {});
						entity.setAttribute('orbit-controls', {});
						camera_rig.appendchild(entity);

						var left_hand = document.createElement('a-entity');
						left_hand.id = 'left-hand';
						left_hand.setAttribute('brush', {});
						left_hand.setAttribute('ui', {});
						left_hand.setAttribute('if-no-vr-headset', { visible: false });
						left_hand.setAttribute('paint-controls', { hand: 'left' });
						left_hand.setAttribute('teleport-controls', { cameraRig: '#cameraRig', button: 'trackpad', ground: '#ground', hitCylinderColor: '#ff3468', curveHitColor: '#ff3468', curveMissColor: '#333333', curveLineWidth: 0.01, hitEntity: '#hitEntityLeft' });
						camera_rig.appendchild(left_hand);

						var vive_tooltips = document.createElement('a-entity');
            vive_tooltips.className = 'vive-tooltips';
            vive_tooltips.setAttribute('visible', false);
            left_hand.appendchild(vive_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(slide up/down)', width: 0.1, height: 0.04, targetPosition: '0 0.016 0.0073', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:0.025, z:0.048 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '0 -0.07 -0.062', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:0.015, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to paint\n(pressure sensitive)', width: 0.11, height: 0.04, targetPosition: '0 -0.06 -0.067', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.11, y:-0.055, z:0.04 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendchild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Undo', width: 0.06, height: 0.03, targetPosition: '-0.003 0.046 0.106', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:-0.005, z:0.12 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendchild(entity);










            $('#painter').on('shown.bs.modal', function() {

                // trigger resize event, otherwise canvas is not showing up 
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);

                $('#painter-target .insert-btn').unbind('click');
                $('#painter-target .insert-btn').click(painter_insert_click_handler);
            });

        
            /* remove children after closing, otherwise there can be conflicts when loading a-frame assets via loading component */  
            $('#painter-target .modal').on('hidden.bs.modal', function() {
                $('#painter-iframe').empty();
            });


            $('#painter').modal('show');
        };

				document.getElementById('painter-iframe').src = window.ideaspace_site_path + '/admin/space/' + space_id + '/edit/' + contenttype_name + '/painter/' + scene_template + '/' + content_id;

    };
    $('.add-edit-painter-btn').unbind('click');
    $('.add-edit-painter-btn').click(painter_add_edit_click_handler);


    var painter_insert_click_handler = function() {

        //var field_type = open_fieldtype_rotation_ref.find('.add-edit-rotation-btn').attr('data-subject-field-type');


        //open_fieldtype_rotation_ref.find('.rotation-info').val(info);

        if (open_fieldtype_rotation_ref.find('.rotation-add').css('display') != 'none') {
            open_fieldtype_rotation_ref.find('.rotation-add').hide();
            open_fieldtype_rotation_ref.find('.rotation-edit').show();
        }

        location.hash = '#' + open_fieldtype_rotation_ref.parent().attr('id');
    };


    var painter_remove_click_handler = function(e) {

        //$(this).parent().parent().find('.rotation-info').val('');
        $(this).parent().parent().find('.painter-add').show();
        $(this).parent().parent().find('.painter-edit').hide();
    };
    $('.form-control-add-painter .painter-edit .remove-painter-btn').click(painter_remove_click_handler);          
 
});


