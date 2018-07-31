AFRAME.registerComponent('isvr-vr-mode', {

    schema: {
        camera_distance_vr: {type: 'number', default: 1.0}
    },

    init: function() {

        var self = this;

        this.el.addEventListener('enter-vr', function() {

            /* in order to avoid trouble with teleporation in vr */
            document.querySelector('#camera').removeAttribute('cursor', 'rayOrigin');

						/* reset because of orbit-controls */
            document.querySelector('#camera').setAttribute('position', { x: 0, y: 0, z: 0 });


            document.querySelector('#floor').setAttribute('visible', true);

            var scale = document.querySelector('#model-wrapper').dataset.vrscale;
            document.querySelector('#model-wrapper').setAttribute('scale', AFRAME.utils.coordinates.parse(scale));

            var model_y_axis = document.querySelector('#model-wrapper').getAttribute('data-vr-model-y-axis');
            document.querySelector('#model-wrapper').setAttribute('position', { x:0, y:model_y_axis, z:0 });

            var camera_wrapper = document.querySelector('#camera-wrapper');
            /* store original position for exit-vr event */
            self.camera_wrapper_pos = camera_wrapper.getAttribute('position');
						camera_wrapper.setAttribute('position', { x: 0, y: 0, z: self.data.camera_distance_vr });


						var primaryHand = document.createElement('a-entity');
            primaryHand.setAttribute('id', 'primaryHand');
            primaryHand.setAttribute('mixin', 'hand');
            primaryHand.setAttribute('oculus-touch-controls', {hand: 'right'});
            primaryHand.setAttribute('vive-controls', {hand: 'right'});
            primaryHand.setAttribute('windows-motion-controls', {hand: 'right'});
            primaryHand.setAttribute('daydream-controls', 'right');
            primaryHand.setAttribute('gearvr-controls', 'right');
            camera_wrapper.appendChild(primaryHand);

						var secondaryHand = document.createElement('a-entity');
            secondaryHand.setAttribute('id', 'secondaryHand');
            secondaryHand.setAttribute('mixin', 'hand');
            secondaryHand.setAttribute('oculus-touch-controls', {hand: 'left'});
            secondaryHand.setAttribute('vive-controls', {hand: 'left'});
            secondaryHand.setAttribute('windows-motion-controls', {hand: 'left'});
            secondaryHand.setAttribute('daydream-controls', 'left');
            secondaryHand.setAttribute('gearvr-controls', 'left');
            camera_wrapper.appendChild(secondaryHand);
        });

        this.el.addEventListener('exit-vr', function() {

            location.reload();
        });

    },

});


