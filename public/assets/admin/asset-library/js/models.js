jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) {
        /* when opened from space content edit page, allow single file uploads and show upload area */
        //$('.upload-area').find('input[type="file"]').removeAttr('multiple');
        $('.upload-area').addClass('visible');
        $('.upload-area').show();

        $('#models .files .insert-link').show();
        $('#asset-details .insert-btn').show();
        $('#models .files .list-item .insert').unbind('click');
        $('#models .files .list-item .insert').click(window.insert_click_handler);
        $('#asset-details .insert-btn').unbind('click');
        $('#asset-details .insert-btn').click(window.insert_btn_click_handler);

    } //else {
        /* when opened from assets menu, set active class on models tab */
        //$('.asset-library-nav').find('#models-tab').parent().addClass('active');
    //}


    /* touch */
    var list_item_menu_click_handler = function() {
        $('#models .files .list-item').find('.menu').hide();
        $(this).find('.menu').show();
    };
    window.list_item_menu_click_handler = list_item_menu_click_handler;
    $('#models .files .list-item').click(window.list_item_menu_click_handler);


    /* mouse */
    var list_item_menu_hover_in_handler = function() {
        $(this).find('.menu').show();
    };
    var list_item_menu_hover_out_handler = function() {
        $(this).find('.menu').hide();
    };
    window.list_item_menu_hover_in_handler = list_item_menu_hover_in_handler;
    window.list_item_menu_hover_out_handler = list_item_menu_hover_out_handler;
    $('#models .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);


    /* show model edit page */
    var list_item_edit_click_handler = function(e) {
        e.preventDefault();
        var model_id = $(e.target).attr('data-model-id');

        $('#asset-details .modal-content').prepend('<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:60px;position:absolute;top:300px;left:50%;"></i>');
        $('#asset-details').modal('show');

        if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) { 
            var content_id = window.open_asset_library_ref.find('.content-id').val();
            var field_key = window.open_asset_library_ref.find('.content-key').val();
            var uri = window.ideaspace_site_path + '/admin/assets/model/' + field_key + '/' + content_id + '/' + model_id + '/edit' 
        } else {
            var uri = window.ideaspace_site_path + '/admin/assets/model/null/null/' + model_id + '/edit' 
        }
  
        $('#asset-details .modal-content').load(uri, function() {

            /* allow switching views */
            $('#asset-details .vr-view').unbind('click');
            $('#asset-details .vr-view').click(window.list_item_vr_view_click_handler);

            /* set height dynamically, because of mobile */
            $('#asset-details .modal-body a-scene').css('max-height', '600px');
            $('#asset-details .modal-body a-scene').css('height', $(window).height() * 0.6);

            $('#asset-details').unbind('shown.bs.modal');
            $('#asset-details').on('shown.bs.modal', function() {
                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            });

            $('#asset-details .save-btn').unbind('click');
            $('#asset-details .save-btn').click(window.model_edit_save_btn_click_handler);
            $('#asset-details #caption').unbind('keydown');
            $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
            $('#asset-details #description').unbind('keydown');
            $('#asset-details #description').on('keydown', window.reset_save_btn_handler);
            $('#asset-details .delete-link').unbind('click');
            $('#asset-details .delete-link').click(window.model_edit_delete_btn_click_handler);

            if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) {
                $('#asset-details .insert-btn').unbind('click');
                $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                $('#asset-details .insert-btn').show();
            }

            /* update model scale */
            $('#asset-details #scale').unbind('change');
            $('#asset-details #scale').change(function() {
                $('#asset-details #model').attr('scale', $(this).val() + ' ' + $(this).val() + ' ' + $(this).val());
                $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
            });

            /* update model rotation */
            $('#asset-details #rotation-x').unbind('change');
            $('#asset-details #rotation-x').change(function() {
                var rotation = document.querySelector('a-entity#model').getAttribute('rotation');
                if ($(document.querySelector('a-entity#model')).hasClass('ply-model')) {
                    document.querySelector('a-entity#model').setAttribute('rotation', ($(this).val() - 90) + ' ' + rotation.y + ' ' + rotation.z);
                } else {
                    document.querySelector('a-entity#model').setAttribute('rotation', $(this).val() + ' ' + rotation.y + ' ' + rotation.z);
                }
                $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
            });
            $('#asset-details #rotation-y').unbind('change');
            $('#asset-details #rotation-y').change(function() {
                var rotation = document.querySelector('a-entity#model').getAttribute('rotation');
                document.querySelector('a-entity#model').setAttribute('rotation', rotation.x + ' ' + $(this).val() + rotation.z);
                $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
            });
            $('#asset-details #rotation-z').unbind('change');
            $('#asset-details #rotation-z').change(function() {
                var rotation = document.querySelector('a-entity#model').getAttribute('rotation');
                document.querySelector('a-entity#model').setAttribute('rotation', rotation.x + ' ' + rotation.y + ' ' + $(this).val());
                $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
            });

        });
    };
    window.list_item_edit_click_handler = list_item_edit_click_handler;
    $('#models .files .list-item .edit').click(window.list_item_edit_click_handler);


    /* show model vr view page */
    var list_item_vr_view_click_handler = function(e) {
        e.preventDefault();
        var model_id = $(e.target).attr('data-model-id');

        $('#asset-details .modal-content').prepend('<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:60px;position:absolute;top:300px;left:50%;"></i>');
        $('#asset-details').modal('show');

        $('#asset-details .modal-content').load(window.ideaspace_site_path + '/admin/assets/model/' + model_id + '/vr-view', function() {

            /* allow switching views */
            $('#asset-details .edit-model').unbind('click');
            $('#asset-details .edit-model').click(window.list_item_edit_click_handler);

            /* set height dynamically, because of mobile */
            $('#asset-details .modal-body a-scene').css('max-height', '600px');
            $('#asset-details .modal-body a-scene').css('height', $(window).height() * 0.6);

            $('#asset-details').unbind('shown.bs.modal');
            $('#asset-details').on('shown.bs.modal', function() {
                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents');
                evt.initUIEvent('resize', true, false, window, 0);
                window.dispatchEvent(evt);
            });

            if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) {
                $('#asset-details .insert-btn').unbind('click');
                $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                $('#asset-details .insert-btn').show();
            }

            /* update camera distance to model */
            $('#asset-details #distance-to-model').unbind('change');
            $('#asset-details #distance-to-model').change(function() {
                $('#asset-details #camera').attr('position', '0 '+$('#asset-details #user-height').val()+' '+$(this).val());
            });

            /* update user height */
            $('#asset-details #user-height').unbind('change');
            $('#asset-details #user-height').change(function() {
                $('#asset-details #camera').attr('position', '0 '+$(this).val()+' '+$('#asset-details #distance-to-model').val());
            });

            /* rotation animation */
            $('#asset-details #rotate-model').unbind('change');
            $('#asset-details #rotate-model').change(function() {
                if (this.checked) {
                    document.querySelector('a-entity#model').emit('start-rotation-y');
                } else {
                    document.querySelector('a-entity#model').emit('stop-rotation-y');
                }
            });

        });
    };
    window.list_item_vr_view_click_handler = list_item_vr_view_click_handler;
    $('#models .files .list-item .vr-view').click(window.list_item_vr_view_click_handler);


    /* insert link */
    var insert_click_handler = function(e) {

        var model_id = $(e.target).attr('data-model-id');
        window.open_asset_library_ref.find('.model-id').val(model_id);
        window.open_asset_library_ref.find('.model-placeholder img').attr('src', $(e.target).parent().parent().parent().find('img').attr('src'));
        window.open_asset_library_ref.find('.model-add').hide();
        window.open_asset_library_ref.find('.model-edit').show();

        location.hash = '#' + window.open_asset_library_ref.parent().attr('id');

        $('#assets').modal('hide');
    };
    window.insert_click_handler = insert_click_handler;
    $('#models .files .list-item .insert').unbind('click');
    $('#models .files .list-item .insert').click(window.insert_click_handler);


    /* insert button */
    var insert_btn_click_handler = function(e) {

        var model_id = $(e.target).attr('data-model-id');
        window.open_asset_library_ref.find('.model-id').val(model_id);
        window.open_asset_library_ref.find('.model-placeholder img').attr('src', $('#models .files .list-item').find('img[data-model-id=' + model_id + ']').attr('src'));
        window.open_asset_library_ref.find('.model-add').hide();
        window.open_asset_library_ref.find('.model-edit').show();

        location.hash = '#' + window.open_asset_library_ref.parent().attr('id');

        $('#asset-details').modal('hide');
        $('#assets').modal('hide');
    };
    window.insert_btn_click_handler = insert_btn_click_handler;
    $('#asset-details .insert-btn').unbind('click');
    $('#asset-details .insert-btn').click(window.insert_btn_click_handler);


    /* keep possibility to scroll on asset library modal dialog after closing asset detail modal dialog;
       only when opened from space content edit page */
    $('#asset-details').on('hidden.bs.modal', function(e) {
        if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab') && $('#assets').css('display') != 'none') {
            $('body').addClass('modal-open');
        }
    });

    $('#assets').on('hidden.bs.modal', function(e) {
        $('body').removeClass('modal-open');
    });


    /* save caption and description */
    var model_edit_save_btn_click_handler = function(e) {

        var data = {};
        data.caption = $('#asset-details #caption').val();
        data.description = $('#asset-details #description').val();
        data.scale = $('#asset-details #scale').val();
        data.rotation_x = $('#asset-details #rotation-x').val();
        data.rotation_y = $('#asset-details #rotation-y').val();
        data.rotation_z = $('#asset-details #rotation-z').val();

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/model/'+$(this).attr('data-model-id')+'/save',
            type: 'POST',
            data: data
        }).done(function(data) {

            if (data.status == 'success') {
                $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:#449d44"></span> '+localization_strings['saved']);
            }

        }).fail(function() {
        }).always(function() {
        });
    };
    window.model_edit_save_btn_click_handler = model_edit_save_btn_click_handler;
    $('#asset-details .save-btn').click(window.model_edit_save_btn_click_handler);


    var reset_save_btn_handler = function(e) {
        $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
    };
    window.reset_save_btn_handler = reset_save_btn_handler;
    $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
    $('#asset-details #description').on('keydown', window.reset_save_btn_handler);


    /* delete model */
    var model_edit_delete_btn_click_handler = function(e) {

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/model/'+$(this).attr('data-model-id')+'/delete',
            type: 'POST',
            data: {}
        }).done(function(data) {

            if (data.status == 'success') {
                $('#models .files .list .list-item .wrapper[data-model-id=\''+data.model_id+'\']').parent().remove();
                var counter = $('#models .files').attr('data-file-counter');
                if (counter > 0) {
                    counter--;
                }
                $('#models .files').attr('data-file-counter', counter);
            }

        }).fail(function() {
        }).always(function() {
        });
    };
    window.model_edit_delete_btn_click_handler = model_edit_delete_btn_click_handler;
    $('#asset-details .delete-link').click(window.model_edit_delete_btn_click_handler);


    var localization_strings = {};
    $.ajax({
        url: window.ideaspace_site_path + '/admin/assets/models/get-localization-strings',
        cache: true,
        success: function(return_data) {
            localization_strings = return_data;
        }
    });


    $('#models .upload').dmUploader({
        url: window.ideaspace_site_path + '/admin/assets/models/add',
        dataType: 'json',
        allowedTypes: '*',
        maxFileSize: $('#models #max_filesize_bytes').val(),
        extraData: {},
        extFilter: 'obj;mtl;dae;png;jpg;gif;tga;ply;gltf;glb',
        onInit: function() {
            $('#models .upload').click(function(e) {
                if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
                    $(this).find('input[type=file]').click();
                }
            });
        },
        onBeforeUpload: function(id) {

            $('#models .files .no-content').hide();

            var template =
            '<li class="list-item">' +
                '<div id="file-0" class="wrapper">' +
                    '<div class="progress progress-striped active" style="margin-top:60px">' +
                        '<div class="progress-bar" role="progressbar" style="width:0%">' +
                            '<span class="sr-only">0%</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</li>';

            $('#models .files ul').prepend(template);
        },
        onNewFile: function(id, file) {
        },
        onComplete: function() {
        },
        onUploadProgress: function(id, percent) {
            percent = percent + '%';
            $('#models #file-0:first').find('div.progress-bar').width(percent);
            $('#models #file-0:first').find('span.sr-only').html(percent);
        },
        onUploadSuccess: function(id, data) {

            if (data.status == 'success') {

                $('#models #file-0:first').attr('data-model-id', data.model_id);

                $('#models #file-0:first').load(window.ideaspace_site_path + '/admin/assets/model/'+data.model_id+'/get-model-preview-code', function() {

                    var scene = document.querySelector('#preview-scene');
                    if (scene.renderStarted) {
                        create_image();
                    } else {
                        scene.addEventListener('renderstart', create_image);
                    }

                    function create_image() {

                        scene.addEventListener('model-loaded', function(e) {

                            /* convert camera fov degrees to radians */
                            var fov = scene.camera.fov * (Math.PI / 180);
                            var model = document.querySelector('#preview-model');
                            var box = new THREE.Box3().setFromObject(model.getObject3D('mesh'));

                            var objectSize = Math.max(box.size().x, box.size().y);

                            var distance = Math.abs(objectSize / Math.sin(fov / 2));

                            var camera = document.querySelector('#preview-camera');
                            camera.setAttribute('position', {x: 0, y: box.size().y / 2, z: distance});

                            /* workaround since model-loaded is emitted before model is shown in scene */
                            setTimeout(function() {

                                //var canvasData = scene.renderer.domElement.toDataURL('image/png');
                                var sc = document.querySelector('a-scene#preview-scene');
                                sc.setAttribute('screenshot', { width: 300, height: 300 });
                                var canvasData = sc.components.screenshot.getCanvas('perspective').toDataURL('image/png');

                                $.ajax({
                                    url: window.ideaspace_site_path + '/admin/assets/model/save-image',
                                    type: 'POST',
                                    data: { 'canvasData': canvasData, 'model_id': data.model_id }
                                }).done(function(data) {

                                    if (data.status = 'success') {

                                        $('#models #file-0:first').html('<div><img class="edit img-thumbnail img-responsive" src="' + data.uri + '" data-model-id="'+data.model_id+'"></div>');
                                        $('#models #file-0:first').append('<div class="menu" style="text-align:center;margin-top:5px;display:none">' +
                                            '<a href="#" class="vr-view" data-model-id="'+data.model_id+'">'+localization_strings['vr_view']+'</a> | ' +
                                            '<a href="#" class="edit" data-model-id="'+data.model_id+'">'+localization_strings['edit']+'</a> ' +
                                            '<span class="insert-link" style="display:none">| <a href="#" class="insert" data-model-id="'+data.model_id+'">'+localization_strings['insert']+'</a></span></div>');

                                        $('#models .files .list-item').unbind('click');
                                        $('#models .files .list-item').click(window.list_item_menu_click_handler);
                                        $('#models .files .list-item').unbind('hover');
                                        $('#models .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);
                                        $('#models .files .list-item .vr-view').unbind('click');
                                        $('#models .files .list-item .vr-view').click(window.list_item_vr_view_click_handler);
                                        $('#models .files .list-item .edit').unbind('click');
                                        $('#models .files .list-item .edit').click(window.list_item_edit_click_handler);

                                        /* hide upload area */
                                        $('.upload-area').removeClass('visible');
                                        $('.upload-area').hide();

                                        /* show insert link when opened from space edit content page */
                                        if ($('.asset-library-nav').find('#models-tab').hasClass('auto-opentab')) {
                                            $('#models .files .insert-link').show();
                                            $('#asset-details .insert-btn').show();
                                            $('#models .files .list-item .insert').unbind('click');
                                            $('#models .files .list-item .insert').click(window.insert_click_handler);
                                            $('#asset-details .insert-btn').unbind('click');
                                            $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                                        }

                                    } else {
                                        $('#models').find('#file-error').remove();
                                        $('#models').prepend('<div id="file-error" class="alert alert-danger" role="alert">' + localization_strings['model_save_as_image_error'] + '</div>');
                                        $("#models #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#models #file-type-error").remove(); });
                                    }

                                }).fail(function() {
                                }).always(function() {
                                });

                            }, 4000); /* end setTimeout */

                        }); /* end model-loaded event listener */

                  } /* end create_image */

              }); /* end load */

          } else if (data.status == 'success-ongoing') {
              /* uploading files which belong together */
              $('#models .files ul #file-0:first').parent().remove();

          } else if (data.status == 'error') {

              var i = $('#models .files').attr('data-file-counter');
              $('#models #file-' + i).html(data.message).addClass('file-upload-error');
          }
        },
        onUploadError: function(id, message) {
            var i = $('#models .files').attr('data-file-counter');
            $('#models #file-' + i).html(message).addClass('file-upload-error');
        },
        onFileTypeError: function(file) {
            $('#models').find('#file-error').remove();
            $('#models').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_type_error'] + '</div>');
            $("#models #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#models #file-type-error").remove(); });
        },
        onFileSizeError: function(file) {
            $('#models').find('#file-error').remove();
            $('#models').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_size_error'] + '</div>');
            $("#models #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#models #file-type-error").remove(); });
        },
        onFileExtError: function(file) {
            $('#models').find('#file-error').remove();
            $('#models').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_ext_error'] + '</div>');
            $("#models #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#models #file-type-error").remove(); });
        },
        onFallbackMode: function(message) {
        }
    });

});

