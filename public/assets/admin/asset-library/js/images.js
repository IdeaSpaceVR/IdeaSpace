jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    if ($('.asset-library-nav').find('#images-tab').hasClass('auto-opentab')) {
        /* when opened from space content edit page, allow single file uploads and show upload area */
        $('.upload-area').find('input[type="file"]').removeAttr('multiple');
        $('.upload-area').addClass('visible');
        $('.upload-area').show();

        $('#images .files .insert-link').show();
        $('#asset-details .insert-btn').show();
        $('#images .files .list-item .insert').unbind('click');
        $('#images .files .list-item .insert').click(window.insert_click_handler);
        $('#asset-details .insert-btn').unbind('click');
        $('#asset-details .insert-btn').click(window.insert_btn_click_handler);

    } else {
        /* when opened from assets menu, set active class on images tab */
        $('.asset-library-nav').find('#images-tab').parent().addClass('active');
    }


    /* touch */
    var list_item_menu_click_handler = function() {
        $('#images .files .list-item').find('.menu').hide();
        $(this).find('.menu').show();
    };
    window.list_item_menu_click_handler = list_item_menu_click_handler;
    $('#images .files .list-item').click(window.list_item_menu_click_handler);


    /* mouse */
    var list_item_menu_hover_in_handler = function() {
        $(this).find('.menu').show();
    };
    var list_item_menu_hover_out_handler = function() {
        $(this).find('.menu').hide();
    };
    window.list_item_menu_hover_in_handler = list_item_menu_hover_in_handler;
    window.list_item_menu_hover_out_handler = list_item_menu_hover_out_handler;
    $('#images .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);


    /* show image edit page */
    var list_item_edit_click_handler = function(e) {
        e.preventDefault();
        var image_id = $(e.target).attr('data-image-id');

        $('#asset-details .modal-content').prepend('<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:60px;position:absolute;top:300px;left:50%;"></i>');
        $('#asset-details').modal('show');

        $('#asset-details .modal-content').load(window.ideaspace_site_path + '/admin/assets/image/' + image_id + '/edit', function() {

            /* allow switching views */
            $('#asset-details .vr-view').unbind('click');
            $('#asset-details .vr-view').click(window.list_item_vr_view_click_handler);

            $('#asset-details .save-btn').unbind('click');
            $('#asset-details .save-btn').click(window.image_edit_save_btn_click_handler);
            $('#asset-details #caption').unbind('keydown');
            $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
            $('#asset-details #description').unbind('keydown');
            $('#asset-details #description').on('keydown', window.reset_save_btn_handler);
            $('#asset-details .delete-link').unbind('click');
            $('#asset-details .delete-link').click(window.image_edit_delete_btn_click_handler);

            if ($('.asset-library-nav').find('#images-tab').hasClass('auto-opentab')) {
                $('#asset-details .insert-btn').unbind('click');
                $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                $('#asset-details .insert-btn').show();
            }
        });
    };
    window.list_item_edit_click_handler = list_item_edit_click_handler;
    $('#images .files .list-item .edit').click(window.list_item_edit_click_handler);


    /* show image vr view page */
    var list_item_vr_view_click_handler = function(e) {
        e.preventDefault();
        var image_id = $(e.target).attr('data-image-id');

        $('#asset-details .modal-content').prepend('<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:60px;position:absolute;top:300px;left:50%;"></i>');
        $('#asset-details').modal('show');

        $('#asset-details .modal-content').load(window.ideaspace_site_path + '/admin/assets/image/' + image_id + '/vr-view', function() {

            /* allow switching views */
            $('#asset-details .edit-image').unbind('click');
            $('#asset-details .edit-image').click(window.list_item_edit_click_handler);

            /* set height dynamically, because of mobile */
            $('#asset-details .modal-body a-scene').css('max-height', '600px');        
            $('#asset-details .modal-body a-scene').css('height', $(window).height() * 0.6);        

            $('#asset-details').unbind('hide.bs.modal');
            $('#asset-details').unbind('shown.bs.modal');
            $('#asset-details').on('shown.bs.modal', function() {
                /* trigger resize event, otherwise canvas is not showing up */
                var evt = window.document.createEvent('UIEvents'); 
                evt.initUIEvent('resize', true, false, window, 0); 
                window.dispatchEvent(evt);
            });

            if ($('.asset-library-nav').find('#images-tab').hasClass('auto-opentab')) {
                $('#asset-details .insert-btn').unbind('click');
                $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                $('#asset-details .insert-btn').show();
            }

            /* update camera distance to image */
            $('#asset-details #distance-to-image').unbind('change');
            $('#asset-details #distance-to-image').change(function() {
                $('#asset-details #vr-view-image').attr('position', '0 1.6 -'+$(this).val());
            });

        });
    };
    window.list_item_vr_view_click_handler = list_item_vr_view_click_handler;
    $('#images .files .list-item .vr-view').click(window.list_item_vr_view_click_handler);


    /* insert link */
    var insert_click_handler = function(e) {

        var image_id = $(e.target).attr('data-image-id');
        window.open_asset_library_ref.find('.image-id').val(image_id); 
        window.open_asset_library_ref.find('.image-placeholder img').attr('src', $(e.target).parent().parent().parent().find('img').attr('src'));
        window.open_asset_library_ref.find('.image-add').hide();
        window.open_asset_library_ref.find('.image-edit').show();

        location.hash = '#' + window.open_asset_library_ref.parent().attr('id');

        $('#assets').modal('hide');
    };
    window.insert_click_handler = insert_click_handler;
    $('#images .files .list-item .insert').unbind('click');
    $('#images .files .list-item .insert').click(window.insert_click_handler);


    /* insert button */
    var insert_btn_click_handler = function(e) {

        var image_id = $(e.target).attr('data-image-id');
        window.open_asset_library_ref.find('.image-id').val(image_id); 
        window.open_asset_library_ref.find('.image-placeholder img').attr('src', $('#images .files .list-item').find('img[data-image-id=' + image_id + ']').attr('src'));
        window.open_asset_library_ref.find('.image-add').hide();
        window.open_asset_library_ref.find('.image-edit').show();

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
        if ($('.asset-library-nav').find('#images-tab').hasClass('auto-opentab') && $('#assets').css('display') != 'none') {
            $('body').addClass('modal-open');
        }
    });

    $('#assets').on('hidden.bs.modal', function(e) {
        $('body').removeClass('modal-open');
    });


    /* save caption and description */
    var image_edit_save_btn_click_handler = function(e) {

        var data = {};
        data.caption = $('#asset-details #caption').val();
        data.description = $('#asset-details #description').val();

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/image/'+$(this).attr('data-image-id')+'/save',
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
    window.image_edit_save_btn_click_handler = image_edit_save_btn_click_handler;
    $('#asset-details .save-btn').click(window.image_edit_save_btn_click_handler);


    /* caption and description text areas */
    var reset_save_btn_handler = function(e) {
        $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
    };
    window.reset_save_btn_handler = reset_save_btn_handler;
    $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
    $('#asset-details #description').on('keydown', window.reset_save_btn_handler);


    /* delete image */
    var image_edit_delete_btn_click_handler = function(e) {

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/image/'+$(this).attr('data-image-id')+'/delete',
            type: 'POST',
            data: {}
        }).done(function(data) {

            if (data.status == 'success') {
                $('#images .files .list .list-item .wrapper[data-image-id=\''+data.image_id+'\']').parent().remove();
                var counter = $('#images .files').attr('data-file-counter');
                if (counter > 0) {
                    counter--;
                }
                $('#images .files').attr('data-file-counter', counter);
            }

        }).fail(function() {
        }).always(function() {
        });
    };
    window.image_edit_delete_btn_click_handler = image_edit_delete_btn_click_handler;
    $('#asset-details .delete-link').click(window.image_edit_delete_btn_click_handler);


    var localization_strings = {};
    $.ajax({
        url: window.ideaspace_site_path + '/admin/assets/images/get-localization-strings',
        cache: true,
        success: function(return_data) {
            localization_strings = return_data; 
        }
    });


    $('#images .upload').dmUploader({
        url: window.ideaspace_site_path + '/admin/assets/images/add',
        dataType: 'json',
        allowedTypes: 'image/*',
        maxFileSize: $('#images #max_filesize_bytes').val(),
        extraData: {},
        extFilter: 'jpg;jpeg;png;gif',
        onInit: function() {
            $('#images .upload').click(function(e) {
                if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
                    $(this).find('input[type=file]').click();
                }
            });
        },
        onBeforeUpload: function(id) {
        },
        onNewFile: function(id, file) {

            $('#images .files .no-content').hide();

            var template = 
            '<li class="list-item">' +
                '<div id="file-' + id + '" class="wrapper">' +
                    '<div class="progress progress-striped active" style="margin-top:80px">' +
                        '<div class="progress-bar" role="progressbar" style="width:0%">' +
                            '<span class="sr-only">0%</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</li>';

            $('#images .files ul').prepend(template);
        },
        onComplete: function() {
        },
        onUploadProgress: function(id, percent) {
            percent = percent + '%';
            $('#images #file-' + id).find('div.progress-bar').width(percent);
            $('#images #file-' + id).find('span.sr-only').html(percent);
        },
        onUploadSuccess: function(id, data){

            if (data.status == 'success') {

                $('#images #file-' + id + ':first').html('<div><img class="edit img-thumbnail img-responsive" src="' + data.uri + '" data-image-id="'+data.image_id+'"></div>'); 
                $('#images #file-' + id + ':first').attr('data-image-id', data.image_id);
                $('#images #file-' + id + ':first').append('<div class="menu" style="text-align:center;margin-top:5px;display:none">' +
                    '<a href="#" class="vr-view" data-image-id="'+data.image_id+'">'+localization_strings['vr_view']+'</a> | ' + 
                    '<a href="#" class="edit" data-image-id="'+data.image_id+'">'+localization_strings['edit']+'</a> ' +
                    '<span class="insert-link" style="display:none">| <a href="#" class="insert" data-image-id="'+data.image_id+'">'+localization_strings['insert']+'</a></span></div>');

                $('#images .files .list-item').unbind('click');
                $('#images .files .list-item').click(window.list_item_menu_click_handler);
                $('#images .files .list-item').unbind('hover');
                $('#images .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);
                $('#images .files .list-item .edit').unbind('click');
                $('#images .files .list-item .edit').click(window.list_item_edit_click_handler);
                $('#images .files .list-item .vr-view').unbind('click');
                $('#images .files .list-item .vr-view').click(window.list_item_vr_view_click_handler);

                /* hide upload area */
                $('.upload-area').removeClass('visible');
                $('.upload-area').hide();

                /* show insert link when opened from space edit content page */
                if ($('.asset-library-nav').find('#images-tab').hasClass('auto-opentab')) {
                    $('#images .files .insert-link').show();
                    $('#asset-details .insert-btn').show();
                    $('#images .files .list-item .insert').unbind('click');
                    $('#images .files .list-item .insert').click(window.insert_click_handler);
                    $('#asset-details .insert-btn').unbind('click');
                    $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                } 

          } else if (data.status == 'error') {

              var i = $('#images .files').attr('data-file-counter');
              $('#images #file-' + i).html(data.message).addClass('file-upload-error');
          }
        },
        onUploadError: function(id, message) {
            var i = $('#images .files').attr('data-file-counter');
            $('#images #file-' + i).html(message).addClass('file-upload-error');
        },
        onFileTypeError: function(file) {
            $('#images').find('#file-error').remove();
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_type_error'] + '</div>');
            $("#images #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#images #file-type-error").remove(); });
        },
        onFileSizeError: function(file) {
            $('#images').find('#file-error').remove();
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_size_error'] + '</div>');
            $("#images #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#images #file-type-error").remove(); });
        },
        onFileExtError: function(file) {
            $('#images').find('#file-error').remove();
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_ext_error'] + '</div>');
            $("#images #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#images #file-type-error").remove(); });
        },
        onFallbackMode: function(message) {
        }
    });

});

