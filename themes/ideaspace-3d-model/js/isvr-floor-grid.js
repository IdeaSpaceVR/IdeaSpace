AFRAME.registerComponent('isvr-floor-grid', {

    schema: {
    },

    init: function() {

        var helper = new THREE.GridHelper(120, 120, 0x808080, 0x808080);

        this.el.object3D.add(helper); 

    }

});


