jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    if ($('.asset-library-nav').find('#audio-tab').hasClass('auto-opentab')) {
        /* when opened from space content edit page, allow single file uploads and show upload area */
        $('.upload-area').find('input[type="file"]').removeAttr('multiple');
        $('.upload-area').addClass('visible');
        $('.upload-area').show();

        $('#audio .files .insert-link').show();
        $('#asset-details .insert-btn').show();
        $('#audio .files .list-item .insert').unbind('click');
        $('#audio .files .list-item .insert').click(window.insert_click_handler);
        $('#asset-details .insert-btn').unbind('click');
        $('#asset-details .insert-btn').click(window.insert_btn_click_handler);

    } //else {
        /* when opened from assets menu, set active class on audio tab */
        //$('.asset-library-nav').find('#audio-tab').parent().addClass('active');
    //}


    /* touch */
    var list_item_menu_click_handler = function() {
        $('#audio .files .list-item').find('.menu').hide();
        $(this).find('.menu').show();
    };
    window.list_item_menu_click_handler = list_item_menu_click_handler;
    $('#audio .files .list-item').click(window.list_item_menu_click_handler);


    /* mouse */
    var list_item_menu_hover_in_handler = function() {
        $(this).find('.menu').show();
    };
    var list_item_menu_hover_out_handler = function() {
        $(this).find('.menu').hide();
    };
    window.list_item_menu_hover_in_handler = list_item_menu_hover_in_handler;
    window.list_item_menu_hover_out_handler = list_item_menu_hover_out_handler;
    $('#audio .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);


    /* show audio edit page */
    var list_item_edit_click_handler = function(e) {
        e.preventDefault();
        var audio_id = $(e.target).attr('data-audio-id');

        $('#asset-details .modal-content').prepend('<i class="fa fa-refresh fa-spin" style="color:#0080e5;font-size:60px;position:absolute;top:300px;left:50%;"></i>');
        $('#asset-details').modal('show');

        $('#asset-details .modal-content').load(window.ideaspace_site_path + '/admin/assets/audio/' + audio_id + '/edit', function() {

            $('#asset-details .save-btn').unbind('click');
            $('#asset-details .save-btn').click(window.audio_edit_save_btn_click_handler);
            $('#asset-details #caption').unbind('keydown');
            $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
            $('#asset-details #description').unbind('keydown');
            $('#asset-details #description').on('keydown', window.reset_save_btn_handler);
            $('#asset-details .delete-link').unbind('click');
            $('#asset-details .delete-link').click(window.audio_edit_delete_btn_click_handler);

            if ($('.asset-library-nav').find('#audio-tab').hasClass('auto-opentab')) {
                $('#asset-details .insert-btn').unbind('click');
                $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                $('#asset-details .insert-btn').show();
            }
        });
    };
    window.list_item_edit_click_handler = list_item_edit_click_handler;
    $('#audio .files .list-item .edit').click(window.list_item_edit_click_handler);


    /* insert link */
    var insert_click_handler = function(e) {

        var audio_id = $(e.target).attr('data-audio-id');
        window.open_asset_library_ref.find('.audio-id').val(audio_id);
        window.open_asset_library_ref.find('.audio-placeholder audio source').attr('src', $(e.target).parent().parent().parent().find('source').attr('src'));
        window.open_asset_library_ref.find('.audio-add').hide();
        window.open_asset_library_ref.find('.audio-edit').show();

        location.hash = '#' + window.open_asset_library_ref.parent().attr('id');

        $('#assets').modal('hide');
    };
    window.insert_click_handler = insert_click_handler;
    $('#audio .files .list-item .insert').unbind('click');
    $('#audio .files .list-item .insert').click(window.insert_click_handler);


    /* insert button */
    var insert_btn_click_handler = function(e) {

        var audio_id = $(e.target).attr('data-audio-id');
        window.open_asset_library_ref.find('.audio-id').val(audio_id);
        window.open_asset_library_ref.find('.audio-placeholder audio source').attr('src', $(e.target).parent().parent().parent().find('source').attr('src'));
        window.open_asset_library_ref.find('.audio-add').hide();
        window.open_asset_library_ref.find('.audio-edit').show();

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
        if ($('.asset-library-nav').find('#audio-tab').hasClass('auto-opentab') && $('#assets').css('display') != 'none') {
            $('body').addClass('modal-open');
        }
    });

    $('#assets').on('hidden.bs.modal', function(e) {
        $('body').removeClass('modal-open');
    });


    /* save caption and description */
    var audio_edit_save_btn_click_handler = function(e) {

        var data = {};
        data.caption = $('#asset-details #caption').val();
        data.description = $('#asset-details #description').val();

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/audio/'+$(this).attr('data-audio-id')+'/save',
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
    window.audio_edit_save_btn_click_handler = audio_edit_save_btn_click_handler;
    $('#asset-details .save-btn').click(window.audio_edit_save_btn_click_handler);


    /* caption and description text areas */
    var reset_save_btn_handler = function(e) {
        $('#asset-details .save-btn').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '+localization_strings['save']);
    };
    window.reset_save_btn_handler = reset_save_btn_handler;
    $('#asset-details #caption').on('keydown', window.reset_save_btn_handler);
    $('#asset-details #description').on('keydown', window.reset_save_btn_handler);


    /* delete audio */
    var audio_edit_delete_btn_click_handler = function(e) {

        $.ajax({
            url: window.ideaspace_site_path + '/admin/assets/audio/'+$(this).attr('data-audio-id')+'/delete',
            type: 'POST',
            data: {}
        }).done(function(data) {

            if (data.status == 'success') {
                $('#audio .files .list .list-item .wrapper[data-audio-id=\''+data.audio_id+'\']').parent().remove();
                var counter = $('#audio .files').attr('data-file-counter');
                if (counter > 0) {
                    counter--;
                }
                $('#audio .files').attr('data-file-counter', counter);
            }

        }).fail(function() {
        }).always(function() {
        });
    };
    window.audio_edit_delete_btn_click_handler = audio_edit_delete_btn_click_handler;
    $('#asset-details .delete-link').click(window.audio_edit_delete_btn_click_handler);


    var localization_strings = {};
    $.ajax({
        url: window.ideaspace_site_path + '/admin/assets/audio/get-localization-strings',
        cache: true,
        success: function(return_data) {
            localization_strings = return_data;
        }
    });


    $('#audio .upload').dmUploader({
        url: window.ideaspace_site_path + '/admin/assets/audio/add',
        dataType: 'json',
        allowedTypes: 'audio/*',
        maxFileSize: $('#audio #max_filesize_bytes').val(),
        extraData: {},
        extFilter: 'mp3;wav',
        onInit: function() {
            $('#audio .upload').click(function(e) {
                if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
                    $(this).find('input[type=file]').click();
                }
            });
        },
        onBeforeUpload: function(id) {
        },
        onNewFile: function(id, file) {

            $('#audio .files .no-content').hide();

            var template =
            '<li class="list-item">' +
                '<div id="file-' + id + '" class="wrapper">' +
                    '<div class="progress progress-striped active" style="margin-top:10px">' +
                        '<div class="progress-bar" role="progressbar" style="width:0%">' +
                            '<span class="sr-only">0%</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</li>';

            $('#audio .files ul').prepend(template);
        },
        onComplete: function() {
        },
        onUploadProgress: function(id, percent) {
            percent = percent + '%';
            $('#audio #file-' + id).find('div.progress-bar').width(percent);
            $('#audio #file-' + id).find('span.sr-only').html(percent);
        },
        onUploadSuccess: function(id, data){

            if (data.status == 'success') {

                /* workaround for trying to avoid 412 precondition failed errors */
                setTimeout(function() {

                    $('#audio #file-' + id + ':first').html('<div><audio controls="controls" data-audio-id="'+data.audio_id+'">' +
                        '<source src="' + data.uri + '" type="audio/mpeg"></audio></div>');
                    $('#audio #file-' + id + ':first').attr('data-audio-id', data.audio_id);
                    $('#audio #file-' + id + ':first').append('<div class="menu" style="text-align:center;margin-top:5px;display:none">' +
                        '<a href="#" class="edit" data-audio-id="'+data.audio_id+'">'+localization_strings['edit']+'</a> ' +
                        '<span class="insert-link" style="display:none">| <a href="#" class="insert" data-audio-id="'+data.audio_id+'">'+localization_strings['insert']+'</a></span></div>');

                    $('#audio .files .list-item').unbind('click');
                    $('#audio .files .list-item').click(window.list_item_menu_click_handler);
                    $('#audio .files .list-item').unbind('hover');
                    $('#audio .files .list-item').hover(window.list_item_menu_hover_in_handler, window.list_item_menu_hover_out_handler);
                    $('#audio .files .list-item .edit').unbind('click');
                    $('#audio .files .list-item .edit').click(window.list_item_edit_click_handler);
                    $('#audio .files .list-item .vr-view').unbind('click');
                    $('#audio .files .list-item .vr-view').click(window.list_item_vr_view_click_handler);

                    /* hide upload area */
                    $('.upload-area').removeClass('visible');
                    $('.upload-area').hide();
  
                    /* show insert link when opened from space edit content page */
                    if ($('.asset-library-nav').find('#audio-tab').hasClass('auto-opentab')) {
                        $('#audio .files .insert-link').show();
                        $('#asset-details .insert-btn').show();
                        $('#audio .files .list-item .insert').unbind('click');
                        $('#audio .files .list-item .insert').click(window.insert_click_handler);
                        $('#asset-details .insert-btn').unbind('click');
                        $('#asset-details .insert-btn').click(window.insert_btn_click_handler);
                    }

                }, 3000);      


          } else if (data.status == 'error') {

              var i = $('#audio .files').attr('data-file-counter');
              $('#audio #file-' + i).html(data.message).addClass('file-upload-error');
          }
        },
        onUploadError: function(id, message) {
            var i = $('#audio .files').attr('data-file-counter');
            $('#audio #file-' + i).html(message).addClass('file-upload-error');
        },
        onFileTypeError: function(file) {
            $('#audio').find('#file-error').remove();
            $('#audio').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_type_error'] + '</div>');
            $("#audio #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#audio #file-type-error").remove(); });
        },
        onFileSizeError: function(file) {
            $('#audio').find('#file-error').remove();
            $('#audio').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_size_error'] + '</div>');
            $("#audio #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#audio #file-type-error").remove(); });
        },
        onFileExtError: function(file) {
            $('#audio').find('#file-error').remove();
            $('#audio').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_ext_error'] + '</div>');
            $("#audio #file-error").fadeTo(7000, 500).slideUp(500, function() { $("#audio #file-type-error").remove(); });
        },
        onFallbackMode: function(message) {
        }
    });

});

