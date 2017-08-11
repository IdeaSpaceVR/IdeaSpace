AFRAME.registerComponent('isvr-teleportation', {

  dependencies: ['raycaster'],

  play: function() {

    var teleportIndicator = document.querySelector('#teleport-indicator');
    var teleportPosition = {x: 0, y:0, z:0};

    this.el.addEventListener('raycaster-intersected', function(event) {
        //AFRAME.log(event.detail.intersection.point.x);
        teleportPosition = event.detail.intersection.point;
        teleportIndicator.setAttribute('position', {x: event.detail.intersection.point.x, y: 0.01, z: event.detail.intersection.point.z});
        teleportIndicator.setAttribute('visible', true);
    });

    this.el.addEventListener('raycaster-intersected-cleared', function() {
        //AFRAME.log('Player hit something!');
        teleportIndicator.setAttribute('visible', false);
    });

    this.el.addEventListener('click', function() {
    
//        var camera_pos = document.querySelector('#camera').getAttribute('position');
//        document.querySelector('#camera').setAttribute('position', {x: 0, y: camera_pos.y, z: 0});

        var camera_pos = document.querySelector('#camera').getAttribute('position');
        document.querySelector('#camera').setAttribute('position', {x: teleportPosition.x, y: camera_pos.y, z: teleportPosition.z});

//        var camera_wrapper_pos = document.querySelector('#camera-wrapper').getAttribute('position');
//        document.querySelector('#camera-wrapper').setAttribute('position', {x: teleportPosition.x, y: camera_wrapper_pos.y, z: teleportPosition.z});

//        var laserControls = document.querySelectorAll('.laser-controls');
//        laserControls[0].setAttribute('position', {x: teleportPosition.x, y: camera_wrapper_pos.y, z: teleportPosition.z});
//        laserControls[1].setAttribute('position', {x: teleportPosition.x, y: camera_wrapper_pos.y, z: teleportPosition.z});
    });

  }

});
