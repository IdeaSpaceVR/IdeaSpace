AFRAME.registerSystem('isvr-scene-helper', {

    showCursor: function () {
				/* nothing to do */
    },

    hideCursor: function () {
				/* nothing to do */
    },

});

AFRAME.registerComponent('isvr-scene', {
  
		init: function () {

        if (!AFRAME.utils.device.checkHeadsetConnected()) {

            document.querySelector('#no-hmd-intro').setAttribute('visible', true);
            document.querySelector('#cursor').setAttribute('geometry', { radius: 0.04 });
        }

        this.el.addEventListener('enter-vr', function() {

        		if (AFRAME.utils.device.checkHeadsetConnected()) {
								document.querySelector('#camera-wrapper').setAttribute('position', {x: 0, y: 0, z: 0});
						}

            /* workaround for non-positional tracking devices and a-frame 0.7.0 */
            if (!AFRAME.utils.device.checkHasPositionalTracking()) {
                document.querySelector('#camera').setAttribute('camera', {
                    far: 10000,
                    fov: 80,
                    near: 0.1 
                });
            }

						/* show controllers only in VR */
        		var laser_controls = document.querySelectorAll('.laser-controls');
        		for (var i = 0; i < laser_controls.length; i++) {
            		laser_controls[i].setAttribute('visible', true);
						}

						document.querySelector('a-scene').addState('entered-vr');

        });

        this.el.addEventListener('exit-vr', function() {

            location.reload();

        });

        var laser_controls = document.querySelectorAll('.laser-controls');

        for (var i = 0; i < laser_controls.length; i++) {

            laser_controls[i].addEventListener('controllerconnected', function (evt) {

                document.querySelector('a-scene').addState('controllerconnected');
                document.querySelector('a-scene').setAttribute('data-controllertype', evt.detail.name);
                document.querySelector('#cursor').setAttribute('visible', false);
            });

        }

				var div = document.createElement('div');
				div.setAttribute('style', 'position:absolute;top:20px;right:20px;width:49px;font-size:8px;font-family:Arial,Helvetica,sans-serif;color:#FFF');
				var a = document.createElement('a');
				a.setAttribute('href', 'https://www.ideaspacevr.org');
				a.setAttribute('target', '_blank');
				var img = document.createElement('img');
				img.setAttribute('style', 'width:49px;');
				img.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAMAAAAPkIrYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRF////AJn/2EMNoAAAADhJREFUeNrs1jENAAAIBLHHv2mCBQJbT0DnS90VFovFYrFYKysTi8VisVisN8ubsFgsFou1rwUYAFK9FX2i/ebnAAAAAElFTkSuQmCC';
				a.appendChild(img);
				div.appendChild(a);
				var txt = document.createTextNode('powered by IdeaSpaceVR');
				div.appendChild(txt);
  			document.body.appendChild(div); 

    }

});

