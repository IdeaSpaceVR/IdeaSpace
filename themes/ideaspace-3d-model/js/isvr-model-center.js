AFRAME.registerComponent('isvr-model-center', {

    schema: {
        default: 0
    },

    init: function() {

        var offset = this.data;

        document.querySelector('#model').addEventListener('model-loaded', function() {

            //var loading_indicator = document.querySelector('#loading-indicator-wrapper'); 
            //loading_indicator.setAttribute('visible', false);

            var camera = document.querySelector('a-entity[camera]'); 
            var model = document.querySelector('#model');

            var bb = new THREE.Box3()
            bb.setFromObject(model.object3D);

            var size = bb.getSize();
            var objectSize = Math.max(size.x, size.y);

            // Convert camera fov degrees to radians
            var fov = camera.getAttribute('camera').fov * (Math.PI / 180); 

            var distance = Math.abs(objectSize / Math.sin(fov / 2)); 

            camera.setAttribute('orbit-controls', 'enabled', false);
            camera.setAttribute('position', { x: 0, y: 0, z: distance - offset });

            var camera_wrapper = document.querySelector('#camera-wrapper');
            camera_wrapper.setAttribute('position', { x: 0, y: size.y/2, z: 0 });

            document.querySelector('#model-animation').addEventListener('animationend', function() {

                camera.setAttribute('orbit-controls', 'enabled', true);

                var hotspots = document.querySelectorAll('.hotspot');
                for (var i = 0; i < hotspots.length; i++) {
                    hotspots[i].setAttribute('visible', true);
                }
            });

            model.setAttribute('visible', true);

            this.emit('isvr-model-intro');
            
        });

    },

});


