<?php




Event::listen('media.image.manipulation', function($image_file_path) {

    /* available keys: width, height, quality */
    return array('width' => '4096', 'quality' => 75);

});


Event::listen('media.image.thumbnail.manipulation', function($image_file_path) {

    /* available keys: width, height, quality */
    return array('width' => '512');
});


 

