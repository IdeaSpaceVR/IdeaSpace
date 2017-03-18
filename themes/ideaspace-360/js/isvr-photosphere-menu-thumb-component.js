AFRAME.registerComponent('isvr-photosphere-menu-thumb', {

    init: function() {

      this.el.addEventListener('click', this.onClick.bind(this));
      
    },

    onClick: function(evt) {

        var position = this.el.getAttribute('position');

        /* prevent immediate selection of image after menu appears */
        if (this.el.parentEl.getAttribute('visible') && position.z == 0.5) {

            var image_id = this.el.getAttribute('data-image-id');
            var content_id = this.el.getAttribute('data-content-id');

            var hotspots = document.querySelectorAll('.hotspot-wrapper');
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', 'false');
            }

            var sphere = document.querySelector('#photosphere');
            sphere.setAttribute('material', 'src', '#img-photosphere-' + image_id);
            sphere.setAttribute('data-content-id', content_id);

            var materialtextureloaded_listener = function() {

                document.querySelector('#photosphere-menu').setAttribute('visible', false);
                document.querySelector('#cursor').setAttribute('visible', false);

                /* set visible to true on hotspot wrapper, opacity is still 0 so they are invisible */
                var hotspot_wrapper = document.querySelectorAll('.hotspot-wrapper-content-id-' + content_id);
                for (var i = 0; i < hotspot_wrapper.length; i++) {
                    hotspot_wrapper[i].setAttribute('visible', true);
                }
                /* animation */
                var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
                for (var i = 0; i < hotspots.length; i++) {
                    hotspots[i].setAttribute('visible', 'true');
                    hotspots[i].emit('hotspot-intro-' + content_id);
                }

                var title = document.querySelector('#photosphere-title-content-id-' + content_id);
                if (title != null) {
                    title.setAttribute('position', { x: 0, y:1.6, z:-2 });
                    title.setAttribute('visible', true);
                    setTimeout(function() {
                        title.setAttribute('visible', false);
                    }, 10000);
                }
                sphere.removeEventListener('materialtextureloaded', materialtextureloaded_listener);
            };
            sphere.addEventListener('materialtextureloaded', materialtextureloaded_listener);

        } /* if */

    },

    update: function(oldData) {},

    remove: function() {}

});
