jQuery(document).ready(function($) {

		var open_fieldtype_painter_ref = null;

    /* click on painter button */
    var painter_add_edit_click_handler = function(e) {

        /* needed for insert operation */
        open_fieldtype_painter_ref = $(this).parent().parent();

        var space_id = $(e.target).attr('data-space-id');
        var contenttype_name = $(e.target).attr('data-contenttype-name');
        var scene_template = $(e.target).attr('data-scene-template');
        var content_id = $(e.target).attr('data-content-id');

				document.getElementById('painter-iframe').onload = function() {

            /* set height dynamically, because of mobile */
            $('#painter-iframe').css('height', $(window).height() * 0.5);

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

				var blob = document.getElementById('painter-iframe').contentWindow.painting;

				var fileReader = new FileReader();
				fileReader.onload = function(event) {
					/* base64 encode */
     			open_fieldtype_painter_ref.find('.painter-info').val(fileReader.result.substr(fileReader.result.indexOf(',') + 1));
				};
				fileReader.readAsDataURL(blob);	

        if (open_fieldtype_painter_ref.find('.painter-add').css('display') != 'none') {
            open_fieldtype_painter_ref.find('.painter-add').hide();
            open_fieldtype_painter_ref.find('.painter-edit').show();
        }

        location.hash = '#' + open_fieldtype_painter_ref.parent().attr('id');
    };


    var painter_remove_click_handler = function(e) {

        $(this).parent().parent().find('.painter-info').val('');
        $(this).parent().parent().find('.painter-add').show();
        $(this).parent().parent().find('.painter-edit').hide();
    };
    $('.form-control-add-painter .painter-edit .remove-painter-btn').click(painter_remove_click_handler);          
 
});


