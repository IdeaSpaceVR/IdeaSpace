AFRAME.registerComponent('isvr-model-center', {

    schema: {
				offset: {
        	default: 0
				}
    },

    init: function() {

				var self = this;

        var offset = this.data.offset;

        var mdl = document.querySelector('#model');

        var camera = document.querySelector('a-entity[camera]'); 

        if (mdl) {

            mdl.addEventListener('model-loaded', function() {

                var model = document.querySelector('#model');

						 		var camera_wrapper = document.querySelector('#camera-wrapper');
						 		camera_wrapper.setAttribute('position', { x: 0, y: 0, z: offset });


                model.addEventListener('animationcomplete', function() {

                    var annotations = document.querySelectorAll('.annotation');
                    for (var i = 0; i < annotations.length; i++) {
                        annotations[i].setAttribute('visible', true);
                    }

						 				camera_wrapper.setAttribute('position', { x: 0, y: 0, z: 0 });
                    camera.setAttribute('orbit-controls', { rotateSpeed: 0.3, enableDamping: true, enablePan: true, enableZoom: true, initialPosition: '0 0 ' + offset, minDistance: 0.5, maxDistance: 180 }); 
                });

                model.setAttribute('visible', true);

								if (scene.is('vr-mode')) {

									document.querySelector('#camera-wrapper').setAttribute('position', { x: 0, y: 0, z: 0 });
									model.setAttribute('position', { x: 0, y: 0, z: 0 });
									var annotations = document.querySelectorAll('.annotation');
									for (var i = 0; i < annotations.length; i++) {
											annotations[i].setAttribute('visible', true);
									}

								} else {

                	model.emit('isvr-model-intro');
								}

            });

        }

    },


		tick: function () {

    		document.querySelector('#look-at').object3D.position.copy(document.querySelector('a-entity[camera]').getObject3D('camera').position);
  	}

});


