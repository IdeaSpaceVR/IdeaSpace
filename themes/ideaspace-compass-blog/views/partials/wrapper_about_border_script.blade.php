@if (isset($content['general-settings'][0]['blog-about']))

var about_image = document.querySelector('#about-image');
var about_texture = document.querySelector('#about-texture');
var about_wrapper = document.querySelector('#about-wrapper');
var height = (about_texture.offsetHeight * about_wrapper.getAttribute('width')) / about_texture.offsetWidth;
about_wrapper.setAttribute('height', height);
about_image.setAttribute('position', { x: 0, y: (height / 2), z: 0.001 });

@endif

