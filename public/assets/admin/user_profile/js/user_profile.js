$(document).ready(function () {

    var options = {};
    options.ui = {
        container: "#password-container",
        showVerdictsInsideProgressBar: true,
        viewports: {
            progress: ".pwstrength_viewport_progress"
        }
    };
    //$(':password').pwstrength(options);
    $('input[name="password"]').pwstrength(options);


    $('button[type=submit]').click(function() {
      $(this).addClass('disabled');
    });

});

