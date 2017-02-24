jQuery(document).ready(function($) {

    $('#space-move-trash').click(function() {
      $(this).addClass('disabled');
      $('form').submit(); 
    });

    $('#space-save-draft').click(function() {
      $('select[name=space_status]').val('draft');
      $(this).addClass('disabled');
      $('form').submit(); 
    });

    $('#space-save-publish').click(function() {
      $('select[name=space_status]').val('published');
      $(this).addClass('disabled');
      $('form').submit(); 
    });

    $('#space-save-update').click(function() {
      $(this).addClass('disabled');
      $('form').submit(); 
    });

    $('#space-status-change').click(function() {
      $(this).addClass('disabled');
      $('form').submit(); 
    });

    $('.space-add-content').click(function() {
      $(this).addClass('disabled');
      /* set content type key for redirection */
      $('#contenttype_key').val($(this).attr('data-contenttype-key'));
      $('form').submit(); 
    });

    $("#space-embed-code").focus(function() {
      var $this = $(this);
      $this.select();
      $this.mouseup(function() {
        /* Prevent further mouseup intervention */
        $this.unbind("mouseup");
        return false;
      });
    });

    /* touch */
    $('.field-title .title').click(function(e) {
        $('.field-title .field-actions').hide();
        $(this).parent().parent().find('.field-actions').show();
    });    

    /* mouse */
    $('.field-title').hover(function() {
        $(this).find('.field-actions').show();
        $(this).parent().find('.fa').css('display', 'block');
    }, function() {
        $(this).find('.field-actions').hide();
        $(this).parent().find('.fa').hide();
    });

    $('.field-drag').hover(function() {
        $(this).parent().find('.field-actions').show();
        $(this).find('.fa').css('display', 'block');
    }, function() {
        $(this).parent().find('.field-actions').hide();
        $(this).find('.fa').hide();
    });

    /* helper function to keep table row from collapsing when being sorted */
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };

    /* make table sortable */
    $('.table-responsive').each(function(i, obj) {
        $(this).find('tbody').sortable({
            handle: '.field-drag',
            helper: fixHelperModified,
            stop: function(event, ui) {
                weight_table($(this))
            }
        }).disableSelection();
    });

    function weight_table(tbody) {
        var weight_order = [];
        tbody.find('tr').each(function() {
            count = $(this).parent().children().index($(this)) + 1;
            //console.log(count);
            $(this).find('.weight').val(count);
            //weight_order[count] = $(this).find('.id').val();
            weight_order.push({ 'id': $(this).find('.id').val(), 'weight': count }); 
        });
        /* submit */
        $.ajax({
            url: 'weight-order',
            type: 'post',
            cache: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 'space_id': $('input[name="space_id"]').val(), 'weight_order': weight_order },
            success: function(return_data) {
                if (return_data.success == 'true') {
                    $('#space-edit-headline').after(
                        '<div class="row">' + 
                        '<div class="col-md-9" style="padding-left:35px">' + 
                        '<div class="alert alert-success">' + 
                        return_data.message + 
                        '</div>' + 
                        '</div>' + 
                        '</div>');  
                    $('.alert-success').delay(3000).fadeOut();
                }
            }
        });
    }


});

