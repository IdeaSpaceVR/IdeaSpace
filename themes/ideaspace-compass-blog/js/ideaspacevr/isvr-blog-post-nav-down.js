AFRAME.registerComponent('isvr-blog-post-nav-down', {


		schema: {
				id: {
            type: 'string'
        }
		},
  

    init: function () {

				var self = this;

				this.el.addEventListener('mouseenter', function(evt) {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-down-hover-texture');
        });

        this.el.addEventListener('mouseleave', function() {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-down-texture');
        });
		}

});

