@php
$_id = str_replace('-', '_', $id);
@endphp

var post_text_{{ $_id }}_textures = document.querySelectorAll('.post-text-{{ $id }}-texture');
for (var i = 0; i < post_text_{{ $_id }}_textures.length; i++) {
		var post_text_wrapper_{{ $_id }} = document.getElementById('post-text-wrapper-{{ $id }}-' + post_text_{{ $_id }}_textures[i].dataset.cid);
		var height_meters = (post_text_{{ $_id }}_textures[i].offsetHeight * post_text_wrapper_{{ $_id }}.getAttribute('width')) / post_text_{{ $_id }}_textures[i].offsetWidth;
		post_text_wrapper_{{ $_id }}.setAttribute('height', height_meters);
}

var post_image_{{ $_id }}_textures = document.querySelectorAll('.post-image-{{ $id }}-texture');
for (var i = 0; i < post_image_{{ $_id }}_textures.length; i++) {
		var post_image_wrapper_{{ $_id }} = document.getElementById('post-image-wrapper-{{ $id }}-' + post_image_{{ $_id }}_textures[i].dataset.cid);
		var height_meters = (post_image_{{ $_id }}_textures[i].height * post_image_wrapper_{{ $_id }}.getAttribute('width')) / post_image_{{ $_id }}_textures[i].width;
		post_image_wrapper_{{ $_id }}.setAttribute('height', (height_meters + 0.08));
}

