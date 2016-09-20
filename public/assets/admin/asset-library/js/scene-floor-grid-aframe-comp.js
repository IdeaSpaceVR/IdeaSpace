AFRAME.registerComponent('scene-floor-grid', {

    init: function() {

        var helper = new THREE.GridHelper(50, 1);
        helper.setColors(0x0080e5, 0x808080); /* blue central line, gray grid */
        this.el.object3D.add(helper); 

    }

});


