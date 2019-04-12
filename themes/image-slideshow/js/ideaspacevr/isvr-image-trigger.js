AFRAME.registerComponent('isvr-image-trigger', {


		schema: {
		},
  

    init: function () {

				var self = this;

				document.querySelector('canvas').addEventListener('click', function() {
						self.showImage();
        });

				document.querySelector('canvas').addEventListener('touchstart', function() {
						self.showImage();
        });

				this.el.addEventListener('triggerdown', function() {
						self.showImage();
        });

				this.el.addEventListener('trackpaddown', function() {
						self.showImage();
        });

				this.el.addEventListener('thumbstickdown', function() {
						self.showImage();
        });

				this.el.addEventListener('gripdown', function() {
						self.showImage();
        });

				this.el.addEventListener('surfacedown', function() {
						self.showImage();
        });

		},

		showImage: function () {

				var images_wrapper = document.querySelector('#images-wrapper');

				var i = images_wrapper.dataset.image;
				var all = images_wrapper.dataset.images;
	
				if (all == i) {
						i = 0;
				}

				if (document.querySelector('#intro').getAttribute('visible') == true) {

						document.querySelector('#intro').setAttribute('visible', false); 
				}

				var images_all = document.querySelectorAll('.image');

				for (var j = 0; j < images_all.length; j++) {
						images_all[j].setAttribute('visible', false);
						images_all[j].setAttribute('material', { opacity: 0.0 });
				}

				document.querySelector('#image-' + i).setAttribute('visible', true);
				document.querySelector('#image-' + i).emit('show-image-' + i);

				i++;

				images_wrapper.dataset.image = i;
		}

});


