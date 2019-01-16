
AFRAME.registerComponent('isvr-scene', {
  
    init: function () {

        this.el.addEventListener('enter-vr', function() {

						if (AFRAME.utils.device.checkHeadsetConnected()) {
								/* workaround */
                document.querySelector('#camera-wrapper').setAttribute('position', {x: 0, y: -1.6, z: 0});
                document.querySelector('.laser-controls-wrapper').setAttribute('position', {x: 0, y: -1.6, z: 0});
            }


						//var cursor = document.querySelector('#cursor');
						//cursor.setAttribute('cursor', { fuse: false, rayOrigin: 'entity' });


						var wrapper = document.querySelector('.laser-controls-wrapper');

						var lcLeftEl = document.createElement('a-entity');
						lcLeftEl.setAttribute('laser-controls', {hand: 'left'});
						//lcLeftEl.setAttribute('gearvr-controls', {hand: 'left'});
						lcLeftEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcLeftEl.setAttribute('line', {color: '#FFFFFF'});
						lcLeftEl.setAttribute('class', 'laser-controls');
						wrapper.appendChild(lcLeftEl);

						var lcRightEl = document.createElement('a-entity');
						lcRightEl.setAttribute('laser-controls', {hand: 'right'});
						//lcRightEl.setAttribute('gearvr-controls', {hand: 'right'});
						lcRightEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcRightEl.setAttribute('line', {color: '#FFFFFF'});
						lcRightEl.setAttribute('class', 'laser-controls');
						wrapper.appendChild(lcRightEl);


						var posts = document.querySelectorAll('.post');
						posts.forEach(function(elem) {
								elem.setAttribute('isvr-spin', '');
						});


            document.querySelector('a-scene').addState('entered-vr');
						
        });

        this.el.addEventListener('exit-vr', function() {

            document.querySelector('a-scene').removeState('entered-vr');

        });


    }

});

