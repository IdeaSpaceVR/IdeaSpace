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

  /* make diagnosis table sortable */
  $('.table-responsive').each(function(i, obj) {
    $(this).find('tbody').sortable({
      helper: fixHelperModified,
      stop: function(event, ui) {
        weight_table($(this).find('table').class)
      }
    }).disableSelection();
  });

  function weight_table(tableID) {
    $(tableID + ' tr').each(function() {
      count = $(this).parent().children().index($(this)) + 1;
      $(this).find('.weight').val(count);
    });
  }


});

