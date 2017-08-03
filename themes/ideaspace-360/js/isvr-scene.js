AFRAME.registerSystem('isvr-scene-helper', {

    showCursor: function () {

        /* only show cursor if no controller is connected */
        if (!document.querySelector('a-scene').is('controllerconnected')) {
            document.querySelector('#cursor').components.cursor.play();
            document.querySelector('#cursor').setAttribute('visible', true);
        }
    },

    hideCursor: function () {

        document.querySelector('#cursor').setAttribute('visible', false);
      
        if (document.querySelector('a-scene').is('controllerconnected')) {
            document.querySelector('#cursor').components.cursor.pause();
        }
    },

});

AFRAME.registerComponent('isvr-scene', {
  
    init: function () {

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

