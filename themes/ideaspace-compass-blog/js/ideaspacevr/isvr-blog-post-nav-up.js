AFRAME.registerComponent('isvr-blog-post-nav-up', {


		schema: {
				id: {
            type: 'string'
        },
				cid: {
            type: 'number'
        }
		},
  

    init: function () {

				var self = this;

				this.el.addEventListener('mouseenter', function(evt) {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-up-hover-texture');
        });

        this.el.addEventListener('mouseleave', function() {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-up-texture');
        });

				this.el.addEventListener('click', function() {
            document.querySelector('#posts-wrapper').emit('nav_up_' + self.data.cid);
        });
		}

});

