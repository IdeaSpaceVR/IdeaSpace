AFRAME.registerComponent('isvr-scene', {

  
    init: function () {

        if (!AFRAME.utils.device.checkHeadsetConnected() || !AFRAME.utils.device.isOculusGo || !AFRAME.utils.device.isGearVR) {
            document.querySelector('#no-hmd-intro').setAttribute('visible', true);
        }

        this.el.addEventListener('enter-vr', function() {

						if (AFRAME.utils.device.checkHeadsetConnected()) {
                document.querySelector('#camera-wrapper').setAttribute('position', {x: 0, y: 0, z: 0});
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
                //document.querySelector('#cursor').setAttribute('visible', false);
            });

        }

    }

});

