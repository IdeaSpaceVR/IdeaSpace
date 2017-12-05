jQuery(document).ready(function($) {

    $.ajax({
        url: window.ideaspace_site_path + '/admin/themes/all',
        type: 'GET'
    }).done(function(themes_data) {

        $.ajax({
            url: 'https://www.ideaspacevr.org/blog/news.json?callback=news_handler&themes=' + themes_data.themes,
            dataType: 'jsonp',
            success: function(data) {

                var this_data = data;
                var data_obj = {};
                data_obj.news = this_data;

                $.ajax({
                    url: window.ideaspace_site_path + '/admin/dashboard/news',
                    type: 'POST',
                    data: data_obj
                }).done(function(data) {

                    if (data.status == 'success') {
                    
                        $.each(this_data, function(index, value) {
                            $('.news .news-headlines').append(value);
                        });

                        $('.panel-body.news').parent().show();

                    } else {
                        console.log('Could not submit news.');
                    }

                }).fail(function() {
                }).always(function() {
                });
            }
        });

    });

});
