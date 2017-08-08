AFRAME.registerComponent('isvr-annotation', {

    schema: {
    },

    init: function() {

        this.el.addEventListener('click', function(e) {

            if (this.getAttribute('visible') == true) {
                this.setAttribute('visible', false);
            }
        });

    }

});

