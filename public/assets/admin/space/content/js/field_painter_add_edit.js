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
						assets.appendChild(img);

						img = document.createElement('img');
						img.id = 'floor';
						img.src = window.ideaspace_site_path + '/public/a-painter/assets/images/floor.jpg';
						img.crossorigin = 'anonymous';
						assets.appendChild(img);

						var asset_item = document.createElement('a-asset-item');
						asset_item.id = 'logoobj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/logo.obj';
						assets.appendChild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'logomtl';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/logo.mtl';
						assets.appendChild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'uiobj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/ui.obj';
						assets.appendChild(asset_item);

						asset_item = document.createElement('a-asset-item');
						asset_item.id = 'hitEntityObj';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/models/teleportHitEntity.obj';
						assets.appendChild(asset_item);

						var audio = document.createElement('audio');
						asset_item.id = 'ui_click0';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_click0.ogg';
						assets.appendChild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_click1';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_click1.ogg';
						assets.appendChild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_menu';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_menu.ogg';
						assets.appendChild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_undo';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_undo.ogg';
						assets.appendChild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_tick';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_tick.ogg';
						assets.appendChild(asset_item);

						audio = document.createElement('audio');
						asset_item.id = 'ui_paint';
						asset_item.src = window.ideaspace_site_path + '/public/a-painter/assets/sound/ui_paint.ogg';
						assets.appendChild(asset_item);

						var entity = document.createElement('a-light');
						entity.setAttribute('type', 'point');
						entity.setAttribute('light', { color: '#fff', intensity: 0.6 });
						entity.setAttribute('position', { x:3, y:10, z:1 });
						scene.appendChild(entity);

						entity = document.createElement('a-light');
						entity.setAttribute('type', 'point');
						entity.setAttribute('light', { color: '#fff', intensity: 0.2 });
						entity.setAttribute('position', { x:-3, y:-10, z:0 });
						scene.appendChild(entity);

						entity = document.createElement('a-light');
						entity.setAttribute('type', 'hemisphere');
						entity.setAttribute('light', { color: '#888', intensity: 0.8 });
						scene.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'logo';
						entity.setAttribute('obj-model', { obj: '#logoobj', mtl: '#logomtl' });
						scene.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'ground';
						entity.setAttribute('geometry', { primitive: 'box', width: 12, height: 0.01, depth: 12 });
						entity.setAttribute('material', { shader: 'flat', src: '#floor' });
						scene.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'hitEntityLeft';
						entity.setAttribute('material', { shader: 'flat', color: '#ff3468' });
						entity.setAttribute('obj-model', { obj: '#hitEntityObj' });
						scene.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.id = 'hitEntityRight';
						entity.setAttribute('material', { shader: 'flat', color: '#ff3468' });
						entity.setAttribute('obj-model', { obj: '#hitEntityObj' });
						scene.appendChild(entity);

						var camera_rig = document.createElement('a-entity');
						camera_rig.id = 'cameraRig';
						scene.appendChild(camera_rig);

						entity = document.createElement('a-entity');
						entity.id = 'acamera';
						entity.setAttribute('camera', {});
						entity.setAttribute('wasd-controls', {});
						entity.setAttribute('look-controls', {});
						entity.setAttribute('orbit-controls', {});
						camera_rig.appendChild(entity);

						/* left hand */
						var left_hand = document.createElement('a-entity');
						left_hand.id = 'left-hand';
						left_hand.setAttribute('brush', {});
						left_hand.setAttribute('ui', {});
						left_hand.setAttribute('if-no-vr-headset', { visible: false });
						left_hand.setAttribute('paint-controls', { hand: 'left' });
						left_hand.setAttribute('teleport-controls', { cameraRig: '#cameraRig', button: 'trackpad', ground: '#ground', hitCylinderColor: '#ff3468', curveHitColor: '#ff3468', curveMissColor: '#333333', curveLineWidth: 0.01, hitEntity: '#hitEntityLeft' });
						camera_rig.appendChild(left_hand);

						var vive_tooltips = document.createElement('a-entity');
            vive_tooltips.className = 'vive-tooltips';
            vive_tooltips.setAttribute('visible', false);
            left_hand.appendChild(vive_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(slide up/down)', width: 0.1, height: 0.04, targetPosition: '0 0.016 0.0073', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:0.025, z:0.048 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '0 -0.07 -0.062', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:0.015, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to paint\n(pressure sensitive)', width: 0.11, height: 0.04, targetPosition: '0 -0.06 -0.067', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.11, y:-0.055, z:0.04 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Undo', width: 0.06, height: 0.03, targetPosition: '-0.003 0.046 0.106', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:-0.005, z:0.12 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						vive_tooltips.appendChild(entity);

						var oculus_tooltips = document.createElement('a-entity');
            oculus_tooltips.className = 'oculus-tooltips';
            oculus_tooltips.setAttribute('visible', false);
            left_hand.appendChild(oculus_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main Menu', width: 0.07, height: 0.03, targetPosition: '-0.009 0 -0.002', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.066, y:0.013, z:0.013 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Teleport', width: 0.06, height: 0.03, targetPosition: '0.008 0 -0.001', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.059, y:0.015, z:-0.028 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(slide up/down)', width: 0.09, height: 0.04, targetPosition: '-0.009 0.01 -0.01', lineHorizontalAlign: 'center', lineVerticalAlign: 'top', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.07, y:0.01, z:0.06 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to paint!\n(pressure sensitive)', width: 0.11, height: 0.04, targetPosition: '0.002 -0.023 -0.02', lineHorizontalAlign: 'right', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.09, y:0.020, z:-0.067 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Undo', width: 0.05, height: 0.03, targetPosition: '0.005 -0.022 0.027', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.058, y:-0.01, z:0.055 });
						oculus_tooltips.appendChild(entity);

						var windows_motion_samsung_tooltips = document.createElement('a-entity');
            windows_motion_samsung_tooltips.className = 'windows-motion-samsung-tooltips';
            windows_motion_samsung_tooltips.setAttribute('visible', false);
            left_hand.appendChild(windows_motion_samsung_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Trigger to paint!', width: 0.1, height: 0.04, targetPosition: '0 -0.3 -0.1', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:-0.1, z:-0.2 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '0.005 -0.002 -0.06', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.1, y:0.02, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(up/down)', width: 0.11, height: 0.04, targetPosition: '0 -0.09 -0.1', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.2, y:0, z:-0.11 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to undo', width: 0.11, height: 0.03, targetPosition: '0 0 0', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.11, y:0, z:0 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						var windows_motion_tooltips = document.createElement('a-entity');
            windows_motion_tooltips.className = 'windows-motion-tooltips';
            windows_motion_tooltips.setAttribute('visible', false);
            left_hand.appendChild(windows_motion_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Trigger to paint!', width: 0.1, height: 0.04, targetPosition: '0 -0.3 -0.1', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:-0.1, z:-0.2 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '0.01 0.0025 -0.06', lineHorizontalAlign: 'right', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.1, y:0.02, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(up/down)', width: 0.11, height: 0.04, targetPosition: '0 -0.09 -0.1', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.14, y:0, z:-0.1 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to undo', width: 0.11, height: 0.03, targetPosition: '0 0 0', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.11, y:0, z:0 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						/* right hand */
						var right_hand = document.createElement('a-entity');
						right_hand.id = 'right-hand';
						right_hand.setAttribute('brush', {});
						right_hand.setAttribute('ui', {});
						right_hand.setAttribute('if-no-vr-headset', { visible: false });
						right_hand.setAttribute('paint-controls', { hand: 'right' });
						right_hand.setAttribute('teleport-controls', { cameraRig: '#cameraRig', button: 'trackpad', ground: '#ground', hitCylinderColor: '#ff3468', curveHitColor: '#ff3468', curveMissColor: '#333333', curveLineWidth: 0.01, hitEntity: '#hitEntityRight' });
						camera_rig.appendChild(right_hand);

						/* same tooltips as for left hand */
						right_hand.appendChild(vive_tooltips);

						oculus_tooltips = document.createElement('a-entity');
            oculus_tooltips.className = 'oculus-tooltips';
            oculus_tooltips.setAttribute('visible', false);
            right_hand.appendChild(oculus_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main Menu', width: 0.07, height: 0.03, targetPosition: '0.009 0 -0.002', rotation: '-90 0 0', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.066, y:0.013, z:0.013 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Teleport', width: 0.06, height: 0.03, targetPosition: '-0.008 0 -0.001', rotation: '-90 0 0', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.059, y:0.015, z:-0.028 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(slide up/down)', width: 0.09, height: 0.04, targetPosition: '0.009 0.01 -0.01', lineHorizontalAlign: 'center', lineVerticalAlign: 'top', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.07, y:0.01, z:0.06 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to paint!\n(pressure sensitive)', width: 0.11, height: 0.04, targetPosition: '-0.002 -0.023 -0.02', lineHorizontalAlign: 'left', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.09, y:0.020, z:-0.067 });
						oculus_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Undo', width: 0.05, height: 0.03, targetPosition: '-0.005 -0.022 -0.027', lineHorizontalAlign: 'right', rotation: '-90 0 0', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.058, y:-0.01, z:0.055 });
						oculus_tooltips.appendChild(entity);

						windows_motion_samsung_tooltips = document.createElement('a-entity');
            windows_motion_samsung_tooltips.className = 'windows-motion-samsung-tooltips';
            windows_motion_samsung_tooltips.setAttribute('visible', false);
            right_hand.appendChild(windows_motion_samsung_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Trigger to paint!', width: 0.1, height: 0.04, targetPosition: '0 -0.3 -0.1', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:-0.1, z:-0.2 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '-0.01 -0.004 -0.06', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:0.02, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(up/down)', width: 0.11, height: 0.04, targetPosition: '0 -0.09 -0.1', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.19, y:-0.003, z:-0.11 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to undo', width: 0.11, height: 0.03, targetPosition: '0 0 0', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.11, y:0, z:0 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_samsung_tooltips.appendChild(entity);

						windows_motion_tooltips = document.createElement('a-entity');
            windows_motion_tooltips.className = 'windows-motion-tooltips';
            windows_motion_tooltips.setAttribute('visible', false);
            right_hand.appendChild(windows_motion_tooltips);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Trigger to paint!', width: 0.1, height: 0.04, targetPosition: '0 -0.3 -0.1', lineHorizontalAlign: 'center', lineVerticalAlign: 'bottom', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0, y:-0.1, z:-0.2 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Main menu', width: 0.07, height: 0.03, targetPosition: '-0.015 0.0025 -0.06', lineHorizontalAlign: 'left', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:0.1, y:0.02, z:-0.05 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Brush size\n(up/down)', width: 0.11, height: 0.04, targetPosition: '0 -0.09 -0.1', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.14, y:0, z:-0.1 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);

						entity = document.createElement('a-entity');
						entity.setAttribute('tooltip', { text: 'Press to undo', width: 0.11, height: 0.03, targetPosition: '0 0 0', lineHorizontalAlign: 'right', src: window.ideaspace_site_path + '/public/a-painter/assets/images/tooltip.png' });
						entity.setAttribute('position', { x:-0.11, y:0, z:0 });
						entity.setAttribute('rotation', { x:-90, y:0, z:0 });
						windows_motion_tooltips.appendChild(entity);



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


