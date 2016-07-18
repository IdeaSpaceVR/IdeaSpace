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
    }, function() {
        $(this).find('.field-actions').hide();
    });

});

