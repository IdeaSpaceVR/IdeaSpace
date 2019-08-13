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

				var soundClick = document.querySelector('#sound-click');

				this.el.addEventListener('mouseenter', function(evt) {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-up-hover-texture');
        });

        this.el.addEventListener('mouseleave', function() {
						document.querySelector('#' + self.data.id).setAttribute('material', 'target', '#navigation-arrow-up-texture');
        });

				this.el.addEventListener('click', function() {

						//document.querySelector('#posts-wrapper').setAttribute('rotation', { x: 0, y: 0, z: 0 });

						soundClick.components.sound.stopSound();
            soundClick.components.sound.playSound();

            document.querySelector('#posts-wrapper').emit('nav_up_' + self.data.cid);
        });
		}

});

