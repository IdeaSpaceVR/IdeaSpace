AFRAME.registerSystem('isvr-scene-helper', {

    showCursor: function () {

        /* only show cursor if no controller is connected */
        if (!document.querySelector('a-scene').is('controllerconnected') && AFRAME.utils.device.checkHeadsetConnected()) {
            document.querySelector('#cursor').components.cursor.play();
            document.querySelector('#cursor').setAttribute('visible', true);
        }
    },

    hideCursor: function () {

        document.querySelector('#cursor').setAttribute('visible', false);
      
        if (document.querySelector('a-scene').is('controllerconnected') && AFRAME.utils.device.checkHeadsetConnected()) {
            document.querySelector('#cursor').components.cursor.pause();
        }
    },

});

AFRAME.registerComponent('isvr-scene', {
  
    init: function () {

        if (!AFRAME.utils.device.checkHeadsetConnected()) {
            document.querySelector('#no-hmd-intro').setAttribute('visible', true);
            document.querySelector('#cursor').setAttribute('geometry', { radius: 0.04 });
        }

        this.el.addEventListener('enter-vr', function() {

            document.querySelector('#camera').setAttribute('camera', {
                far: 10000,
                fov: 80,
                near: 0.1,
                userHeight: 0 /* workaround needed for a-frame 0.7.0 */
            });
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

    }

});

