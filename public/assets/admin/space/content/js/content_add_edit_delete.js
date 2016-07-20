jQuery(document).ready(function($) {

    /**
     * Custom `color picker` extension
     */
    var ColorPickerExtension = MediumEditor.extensions.button.extend({
        name: "colorPicker",
        action: "applyForeColor",
        aria: "color picker",
        contentDefault: "<span class='editor-color-picker'>Text Color<span>",

        handleClick: function(e) {
            e.preventDefault();
            e.stopPropagation();

            this.selectionState = this.base.exportSelection();

            // If no text selected, stop here.
            if(this.selectionState && (this.selectionState.end - this.selectionState.start === 0) ) {
              return;
            }

            // colors for picker
            var pickerColors = [ 
              "#1abc9c",
              "#2ecc71",
              "#3498db",
              "#9b59b6",
              "#34495e",
              "#16a085",
              "#27ae60",
              "#2980b9",
              "#8e44ad",
              "#2c3e50",
              "#f1c40f",
              "#e67e22",
              "#e74c3c",
              "#bdc3c7",
              "#95a5a6",
              "#f39c12"
            ];

            var picker = vanillaColorPicker(this.document.querySelector(".medium-editor-toolbar-active .editor-color-picker"));
            picker.set("customColors", pickerColors);
            picker.set("positionOnTop");
            picker.openPicker();
            picker.on("colorChosen", function(color) {
              this.base.importSelection(this.selectionState);
              this.document.execCommand("styleWithCSS", false, true);
              this.document.execCommand("foreColor", false, color);
            }.bind(this));
        }
    });


    var textfield_editor = new MediumEditor('.field-type-textfield', {
        imageDragging: false,
        extensions: {
          'imageDragging': {},
          'colorPicker': new ColorPickerExtension() 
        },
        toolbar: {
            buttons: ['bold', 'italic', 'h1', 'h2', 'h3', 'h4', 'justifyLeft', 'justifyCenter', 'justifyRight', 'colorPicker']
        },
        disableReturn: true,
        disableDoubleReturn: true
    });

    var textarea_editor = new MediumEditor('.field-type-textarea', {
        imageDragging: false,
        extensions: {
          'imageDragging': {},
          'colorPicker': new ColorPickerExtension() 
        },
        toolbar: {
            buttons: ['bold', 'italic', 'h1', 'h2', 'h3', 'h4', 'justifyLeft', 'justifyCenter', 'justifyRight', 'colorPicker']
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


    $('.content-delete').click(function() {

        $(this).addClass('disabled');
        $('form').submit();
    });


});
