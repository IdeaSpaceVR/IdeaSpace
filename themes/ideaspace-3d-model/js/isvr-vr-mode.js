AFRAME.registerComponent('isvr-vr-mode', {

    schema: {
        camera_distance_vr: {type: 'number', default: 1.0}
    },

    init: function() {

        var self = this;
        this.el.addEventListener('enter-vr', function() {

            /* in order to avoid trouble with teleporation in vr */
            document.querySelector('#camera').removeAttribute('cursor', 'rayOrigin');

            document.querySelector('#floor').setAttribute('visible', true);

            var scale = document.querySelector('#model-wrapper').dataset.vrscale;
            document.querySelector('#model-wrapper').setAttribute('scale', AFRAME.utils.coordinates.parse(scale));

            var model_y_axis = document.querySelector('#model-wrapper').getAttribute('data-vr-model-y-axis');
            document.querySelector('#model-wrapper').setAttribute('position', { x:0, y:model_y_axis, z:0 });


            var camera_wrapper = document.querySelector('#camera-wrapper');
            /* store original position for exit-vr event */
            self.camera_wrapper_pos = camera_wrapper.getAttribute('position');
            camera_wrapper.setAttribute('position', { x: 0, y: 0, z: self.data.camera_distance_vr });

            var scene = document.querySelector('a-scene');
            scene.addState('vr-mode');
 
        });

        this.el.addEventListener('exit-vr', function() {

            scene.removeState('vr-mode');

            location.reload();

        });

    },

});


