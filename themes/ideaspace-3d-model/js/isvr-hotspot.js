AFRAME.registerComponent('isvr-hotspot', {

    schema: {
        type: 'string' 
    },

    init: function() {

        var annotation_id = this.data;

        this.el.addEventListener('click', function(e) {

            var annotation = document.querySelector('#annotation-id-' + annotation_id);

            if (annotation.getAttribute('visible') == true) {
                annotation.setAttribute('visible', false);
            } else {
                annotation.setAttribute('visible', true);
            }

            var annotations = document.querySelectorAll('.annotation');
            for (var i = 0; i < annotations.length; i++) {
                if (annotations[i].id != 'annotation-id-' + annotation_id) {
                    annotations[i].setAttribute('visible', false);                 
                }
            }

        });

    }

});

