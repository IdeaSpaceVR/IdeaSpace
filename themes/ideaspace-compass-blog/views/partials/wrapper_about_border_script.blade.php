@if (isset($content['general-settings'][0]['blog-about']))

function about_wrapper_helper () {

		var about_image = document.querySelector('#about-image');
		var about_texture = document.querySelector('#about-texture');
		var about_wrapper = document.querySelector('#about-wrapper');
		var height = (about_texture.offsetHeight * about_wrapper.getAttribute('width')) / about_texture.offsetWidth;

		if (isNaN(height)) {
    		window.requestAnimationFrame(about_wrapper_helper);
		} else {
				about_wrapper.setAttribute('height', height);
				about_image.setAttribute('position', { x: 0, y: (height / 2), z: 0.001 });
		}
};
about_wrapper_helper();

@endif

