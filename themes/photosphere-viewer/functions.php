<?php




Event::listen('media.image.manipulation', function($image_file_path) {

    /* keys: width, height */
    return array('width' => '4096');

});


Event::listen('media.image.thumbnail.manipulation', function($image_file_path) {

    /* keys: width, height */
    return array('width' => '512');
});


 

