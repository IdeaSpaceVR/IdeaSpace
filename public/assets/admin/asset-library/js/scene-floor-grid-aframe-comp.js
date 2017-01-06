AFRAME.registerComponent('scene-floor-grid', {

    init: function() {

        var helper = new THREE.GridHelper(30, 30, 0x0080e5, 0x808080);

        this.el.object3D.add(helper); 

    }

});


