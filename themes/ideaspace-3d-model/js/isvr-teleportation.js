AFRAME.registerComponent('isvr-teleportation', {

  dependencies: ['raycaster'],

  schema: {},

  init: function() {

    var self = this;

    var teleportIndicator = document.querySelector('#teleport-indicator');
    var teleportPosition = {x: 0, y:0, z:0};

    var scene = document.querySelector('a-scene');

    this.el.addEventListener('raycaster-intersected', function(event) {

        if (scene.is('vr-mode')) {

            teleportPosition = event.detail.intersection.point;

            teleportIndicator.setAttribute('position', { x: event.detail.intersection.point.x, y: event.detail.intersection.point.y + 0.01, z: event.detail.intersection.point.z });

            teleportIndicator.setAttribute('visible', true);

        }

    });

    this.el.addEventListener('raycaster-intersected-cleared', function() {

        if (scene.is('vr-mode')) {

            teleportIndicator.setAttribute('visible', false);

        }

    });

    this.el.addEventListener('click', function() {

        if (scene.is('vr-mode')) {

            var camera_pos = document.querySelector('#camera-wrapper').getAttribute('position');
            document.querySelector('#camera-wrapper').setAttribute('position', { x: teleportPosition.x, y: teleportPosition.y + camera_pos.y, z: teleportPosition.z });

        }

    });

  }

});
