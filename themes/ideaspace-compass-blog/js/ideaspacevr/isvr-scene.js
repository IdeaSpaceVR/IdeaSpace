
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

						var lcLeftEl = document.createElement('a-entity');
						lcLeftEl.setAttribute('laser-controls', {hand: 'left'});
						lcLeftEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcLeftEl.setAttribute('line', {color: '#FFFFFF'});
						lcLeftEl.setAttribute('class', 'laser-controls');
						wrapper.appendChild(lcLeftEl);

						var lcRightEl = document.createElement('a-entity');
						lcRightEl.setAttribute('laser-controls', {hand: 'right'});
						lcRightEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcRightEl.setAttribute('line', {color: '#FFFFFF'});
						lcRightEl.setAttribute('class', 'laser-controls');
						wrapper.appendChild(lcRightEl);


						/*var posts = document.querySelectorAll('.post');
						posts.forEach(function(elem) {
								elem.setAttribute('isvr-spin', '');
						});*/


            document.querySelector('a-scene').addState('entered-vr');
						
        });

        this.el.addEventListener('exit-vr', function() {

						if (self.data.sound != 'none') {
								self.sound.stop();
						}

            document.querySelector('a-scene').removeState('entered-vr');

        });


    }

});

