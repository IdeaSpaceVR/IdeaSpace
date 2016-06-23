jQuery(document).ready(function($) {

    var textfield_editor = new MediumEditor('.field-type-textfield', {
        imageDragging: false,
        extensions: {
          'imageDragging': {}
        },
        toolbar: {
            buttons: ['bold', 'italic', 'h1', 'h2', 'h3', 'h4', 'justifyLeft', 'justifyCenter', 'justifyRight']
        },
        disableReturn: true,
        disableDoubleReturn: true
    });

    var textarea_editor = new MediumEditor('.field-type-textarea', {
        imageDragging: false,
        extensions: {
          'imageDragging': {}
        },
        toolbar: {
            buttons: ['bold', 'italic', 'h1', 'h2', 'h3', 'h4', 'justifyLeft', 'justifyCenter', 'justifyRight']
        },
    });


    $('.content-add-save').click(function() {

        var textfields_content = textfield_editor.serialize();
        $.each(textfields_content, function(index, value) {
            $('input[name='+index+']').val(value.value);
        });

        var textareas_content = textarea_editor.serialize();
        $.each(textareas_content, function(index, value) {
            $('textarea[name='+index+']').val(value.value);
        });

        $(this).addClass('disabled');
        $('form').submit();

    });

});
