<?php

function space_embed_code($space_url, $width, $height = null) {

    $height_html = '';
    if ($height != null) {
      $height_html = 'height=' . $height; 
    }
    return '<iframe width="' . $width . '" ' . $height_html . ' allowfullscreen frameborder="0" src="' . $space_url . '"></iframe>';
}
