
AFRAME.registerComponent('isvr-scene', {


		schema: {
        sound: {
            type: 'string'
        }
		},

  
    init: function () {

				var self = this;

        this.el.addEventListener('enter-vr', function() {

						if (AFRAME.utils.device.checkHeadsetConnected()) {
								/* workaround */
                document.querySelector('#camera-wrapper').setAttribute('position', {x: 0, y: -1.6, z: 0});
                document.querySelector('.laser-controls-wrapper').setAttribute('position', {x: 0, y: -1.6, z: 0});
            }


						if (self.data.sound != 'none') {
								self.sound = new Howl({
										src: [self.data.sound],
										autoplay: true,
										loop: true
								});
								self.sound.play();
						}


						var wrapper = document.querySelector('.laser-controls-wrapper');

						if (wrapper !== null) {

								var lcLeftEl = document.createElement('a-entity');
								lcLeftEl.setAttribute('laser-controls', {hand: 'left'});
								lcLeftEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
								lcLeftEl.setAttribute('line', {color: '#FFFFFF'});
								lcLeftEl.setAttribute('class', 'laser-controls');
								lcLeftEl.setAttribute('thumb-controls', {hand: 'left'});
								/* text nav with oculus go touch controls */
								lcLeftEl.setAttribute('oculus-go-controls', {hand: 'left'});
								wrapper.appendChild(lcLeftEl);

								var lcRightEl = document.createElement('a-entity');
								lcRightEl.setAttribute('laser-controls', {hand: 'right'});
								lcRightEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
								lcRightEl.setAttribute('line', {color: '#FFFFFF'});
								lcRightEl.setAttribute('class', 'laser-controls');
								lcRightEl.setAttribute('thumb-controls', {hand: 'right'});
								/* text nav with oculus go touch controls */
								lcRightEl.setAttribute('oculus-go-controls', {hand: 'right'});
								wrapper.appendChild(lcRightEl);
						}

						var blog_post_rotate_left = document.querySelector('#blog-post-rotate-left');
						var blog_post_rotate_right = document.querySelector('#blog-post-rotate-right');
						blog_post_rotate_left.setAttribute('visible', true);
						blog_post_rotate_right.setAttribute('visible', true);
						

						document.querySelector('a-scene').emit('added-laser-controls');

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

