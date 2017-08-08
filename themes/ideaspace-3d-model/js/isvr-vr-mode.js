AFRAME.registerComponent('isvr-vr-mode', {

    schema: {
    },

    init: function() {

        this.el.addEventListener('enter-vr', function() {

            document.querySelector('#floor-grid').setAttribute('visible', true);

            var scale = document.querySelector('#model-wrapper').dataset.vrscale;
            document.querySelector('#model-wrapper').setAttribute('scale', AFRAME.utils.coordinates.parse(scale));

            var floor_level = document.querySelector('#model-wrapper').dataset.vrfloorlevel;
            document.querySelector('#model-wrapper').setAttribute('position', { x:0, y:floor_level, z:0 });

        });

        this.el.addEventListener('exit-vr', function() {

            document.querySelector('#floor-grid').setAttribute('visible', false);

            document.querySelector('#model-wrapper').setAttribute('scale', { x: 1, y: 1, z: 1 });

            document.querySelector('#model-wrapper').setAttribute('position', { x: 0, y: 0, z: 0 });

        });

    },

});


