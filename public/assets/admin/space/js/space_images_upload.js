jQuery(document).ready(function($) {


  $("[rel=tooltip]").tooltip({placement: 'right'});


  $(document).on('click', '.image-file-delete', function() {

      var ref_id = $(this).attr('id');
      var image_id = $(this).parents('.image-file').attr('id');

      $.ajax({
          url: 'media/images/delete',
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
  });


  var humanizeSize = function(size) {
      var i = Math.floor( Math.log(size) / Math.log(1024) );
      return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
  }


  $('#upload-image-files').dmUploader({
        url: 'media/images/add',
        dataType: 'json',
        allowedTypes: 'image/*',
        maxFileSize: $('#max_filesize_bytes').val(),
        extraData: { 'type': $('#fileuploadtype').val() },
        /*extFilter: 'jpg;png;gif',*/
        onInit: function() {
            //console.log('Plugin initialized correctly');
            $('#upload-image-files').click(function(e) {
                if (e.currentTarget === this && e.target.nodeName !== 'INPUT') {
                    $(this).find('input[type=file]').click();
                }
            });
        },
        onBeforeUpload: function(id) {
          //console.log('Starting the upload of #' + id);
          $('#image-file-' + id).find('span.image-file-status').html('Uploading...').addClass('image-file-status-default');
        },
        onNewFile: function(id, file) {
          var template =  '<div class="image-file" id="image-file-' + id + '">' +
                          '<span class="image-file-name">' + file.name + '</span> <span class="image-file-size">(' + humanizeSize(file.size) + ')</span> <span class="status-text"> Status:</span> <span class="image-file-status">Waiting to upload</span>'+
                          '<div id="process-file' + id + '" class="progress progress-striped active">' +
                          '<div class="progress-bar" role="progressbar" style="width: 0%;">' +
                          '<span class="sr-only">0% Complete</span>' +
                          '</div>' +
                          '</div>' +
                          '</div>';
                   
          var i = $('#image-files').attr('file-counter');
          if (!i) {
            $('#image-files').empty();
            i = 0;
          }
          i++;
    
          $('#image-files').attr('file-counter', i);
          $('#image-files').prepend(template);
        },
        onComplete: function() {
          //console.log('All pending tranfers completed');
        },
        onUploadProgress: function(id, percent) {
          percent = percent + '%';
          $('#image-file-' + id).find('div.progress-bar').width(percent);
          $('#image-file-' + id).find('span.sr-only').html(percent + ' Complete');
        },
        onUploadSuccess: function(id, data){
          //console.log('Upload of file #' + id + ' completed');
          //console.log('Server Response for file #' + id + ': ' + JSON.stringify(data));

          if (data.status == 'success') {

            $('#image-file-' + id).find('span.image-file-status').html('<strong>' + data.message + '</strong>').addClass('image-file-status-success');
            var elem_id = $('#upload-image-files').parent().attr('class').split(' ')[1];
            $('#image-file-' + id).html('<input name="' + elem_id + '[]" type="hidden" value="' + data.ref_id + '"><table><tr><td><span class="image"><img class="img-responsive" width="400" src="' + data.uri + '"></span></td><td style="padding: 0 0 0 10px"><span style="color:rgb(60, 118, 61)" class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + $('#image-file-' + id).find('span.image-file-status').html() + '<br><br><button type="button" class="btn btn-danger image-file-delete" aria-label="Delete" id="#image-file-delete-' + data.ref_id + '"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="font-size:12px"></span> ' + data.delete_text + '</button></td></tr></table>'); 

          } else if (data.status == 'error') {

            $('#image-file-' + id).find('span.image-file-status').html(data.message).addClass('image-file-status-error');
          }
        },
        onUploadError: function(id, message) {
          $('#image-file-' + id).find('span.image-file-status').html(message).addClass('image-file-status-error');
          //console.log('Failed to Upload file #' + id + ': ' + message);
        },
        onFileTypeError: function(file) {
          $('#upload-image-files').parent().prepend('<div id="file-type-error" class="alert alert-danger" role="alert">File \'' + file.name + '\' cannot be added: must be an image.</div>');
          $("#file-type-error").fadeTo(4000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFileSizeError: function(file) {
          $('#upload-image-files').parent().prepend('<div id="file-type-error" class="alert alert-danger" role="alert">File \'' + file.name + '\' cannot be added: file size too large.</div>');
          $("#file-type-error").fadeTo(4000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFileExtError: function(file) {
          $('#upload-image-files').parent().prepend('<div id="file-type-error" class="alert alert-danger" role="alert">File \'' + file.name + '\' cannot be added: wrong file extension.</div>');
          $("#file-type-error").fadeTo(4000, 500).slideUp(500, function() { $("#file-type-error").remove(); });
        },
        onFallbackMode: function(message) {
          //console.log('Browser not supported(do something else here!): ' + message);
        }
      });

});

