AFRAME.registerComponent('reset-camera', {

    schema: {
    },

    init: function() {

        this.el.camera.el.setAttribute('rotation', '0 0 0');

    }

});
