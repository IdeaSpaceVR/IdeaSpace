jQuery(document).ready(function($) {

  if ($(window).width() < 1440) {
    if ($(window).width() < 768) {
      $('#sidebar-nav').hide();
      $('#sidebar-icons-nav').hide();
    } else {
      $('#sidebar-nav').hide();
      $('#sidebar-icons-nav ul').css('width', '45px');
      $('#sidebar-icons-nav').show();
    }
  } else {
    $('#sidebar-nav').show();
    $('#sidebar-icons-nav').hide();
  }

  $(window).resize(function() {
    if ($(window).width() < 1440) {
      if ($(window).width() < 768) {
        $('#sidebar-nav').hide();
        $('#sidebar-icons-nav').hide();
      } else {
        $('#sidebar-nav').hide();
        $('#sidebar-icons-nav ul').css('width', '45px');
        $('#sidebar-icons-nav').show();
      }
    } else {
      $('#sidebar-nav').show();
      $('#sidebar-icons-nav').hide();
    }
  });


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
  });
});

