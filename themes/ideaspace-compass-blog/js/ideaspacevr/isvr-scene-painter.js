
AFRAME.registerComponent('isvr-scene-painter', {


		schema: {
        sound: {
            type: 'string'
        }
		},

  
    init: function () {

				var self = this;

				/* workaround because paintings cannot be positioned and otherwise they are wrongly positioned */
				document.querySelector('[camera]').setAttribute('position', {x: 0, y: 1.6, z: 0});
				document.querySelector('#posts-wrapper').setAttribute('position', {x: 0, y: 1.6, z: 0});
				document.querySelector('#dashboard-wrapper').setAttribute('position', {x: 0, y: 1.6, z: 0});

        this.el.addEventListener('enter-vr', function() {

						if (AFRAME.utils.device.checkHeadsetConnected()) {
								/* workaround */
								document.querySelector('[camera]').setAttribute('position', {x: 0, y: 0, z: 0});
                document.querySelector('#posts-wrapper').setAttribute('position', {x: 0, y: 1.6, z: 0});
                document.querySelector('#dashboard-wrapper').setAttribute('position', {x: 0, y: 1.6, z: 0});
            }


						if (self.data.sound != 'none') {
								self.sound = new Howl({
										src: [self.data.sound],
										autoplay: true,
										loop: true
								});
								self.sound.play();
						}


						var blog_post_rotate_left = document.querySelector('#blog-post-rotate-left');
						var blog_post_rotate_right = document.querySelector('#blog-post-rotate-right');
						blog_post_rotate_left.setAttribute('visible', true);
						blog_post_rotate_right.setAttribute('visible', true);

            document.querySelector('a-scene').addState('entered-vr');
						
        });

        this.el.addEventListener('exit-vr', function() {

						if (self.data.sound != 'none') {
								self.sound.stop();
						}

						var blog_post_rotate_left = document.querySelector('#blog-post-rotate-left');
						var blog_post_rotate_right = document.querySelector('#blog-post-rotate-right');
						blog_post_rotate_left.setAttribute('visible', false);
						blog_post_rotate_right.setAttribute('visible', false);

            document.querySelector('a-scene').removeState('entered-vr');

        });


    }

});

