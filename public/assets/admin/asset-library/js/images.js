jQuery(document).ready(function($) {


    $('[data-toggle="tooltip"]').tooltip();


    /*$(document).on('click', '.image-file-delete', function() {

        var ref_id = $(this).attr('id');
        var image_id = $(this).parents('.image-file').attr('id');

        $.ajax({
            url: 'media/images/delete',
            // TOKEN!!
            type: 'POST',
            data: { ref_id: ref_id, image_id: image_id }
        }).done(function(data) {
            if (data.status == 'success') {
                $('#image-file-' + data.image_id).html('<table><tr><td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <span style="font-weight:bold">' + data.message + '</span></td></tr></table>');
            } else if (data.status == 'error') {
                $('#image-file-' + data.image_id).html('<table><tr><td><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> <span style="font-weight:bold">' + data.message + '</span></td></tr></table>');
            }
            setTimeout(function() {
                $('#image-file-' + data.image_id).fadeOut('slow');
            }, 5000);
        }).fail(function() {
        }).always(function() {
        }); 
    });*/


    

    /*var humanizeSize = function(size) {
        var i = Math.floor( Math.log(size) / Math.log(1024) );
        return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
    }*/

    var localization_strings = {};
    $.ajax({
        url: window.ideaspace_site_path + '/admin/assets/images/get-localization-strings',
        cache: true,
        success: function(return_data) {
            localization_strings = return_data; 
        }
    });


    $('.upload').dmUploader({
        url: window.ideaspace_site_path + '/admin/assets/images/add',
        dataType: 'json',
        allowedTypes: 'image/*',
        maxFileSize: $('#max_filesize_bytes').val(),
        extraData: {},
        extFilter: 'jpg;jpeg;png;gif',
        onInit: function() {
            $('.upload').click(function(e) {
                if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
                    $(this).find('input[type=file]').click();
                }
            });
        },
        onBeforeUpload: function(id) {
        },
        onNewFile: function(id, file) {

            var template = 
            '<li class="list-item">' +
                '<div id="file-' + id + '">' +
                    '<div class="progress progress-striped active" style="margin-top:80px">' +
                        '<div class="progress-bar" role="progressbar" style="width:0%">' +
                            '<span class="sr-only">0%</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</li>';

            var i = $('#image-files').attr('file-counter');
            if (!i) {
                $('files').empty();
                i = 0;
            }
            i++;

            $('.files').attr('file-counter', i);
            $('.files ul').prepend(template);
        },
        onComplete: function() {
        },
        onUploadProgress: function(id, percent) {
            percent = percent + '%';
            $('#file-' + id).find('div.progress-bar').width(percent);
            $('#file-' + id).find('span.sr-only').html(percent);
        },
        onUploadSuccess: function(id, data){

            if (data.status == 'success') {

                $('#file-' + id).html('<a href="#"><img class="img-thumbnail img-responsive" src="' + data.uri + '"></a>'); 

          } else if (data.status == 'error') {

              var i = $('.files').attr('data-file-counter');
              $('#file-' + i).html(data.message).addClass('file-upload-error');
          }
        },
        onUploadError: function(id, message) {
            var i = $('.files').attr('data-file-counter');
            $('#file-' + i).html(message).addClass('file-upload-error');
        },
        onFileTypeError: function(file) {
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_type_error'] + '</div>');
            $("#file-error").fadeTo(7000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFileSizeError: function(file) {
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_size_error'] + '</div>');
            $("#file-error").fadeTo(7000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFileExtError: function(file) {
            $('#images').prepend('<div id="file-error" class="alert alert-danger" role="alert">\'' + file.name + '\' ' + localization_strings['file_ext_error'] + '</div>');
            $("#file-error").fadeTo(7000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFallbackMode: function(message) {
        }
      });

});

