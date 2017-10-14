AFRAME.registerComponent('isvr-photosphere-menu-thumb', {

    init: function() {

      this.el.addEventListener('click', this.onClick.bind(this));
      
    },

    onClick: function(evt) {

        var self = this;

        var position = this.el.getAttribute('position');

        /* prevent immediate selection of image after menu appears */
        if (this.el.parentEl.getAttribute('visible') && position.z == 0.5) {

            var image_id = this.el.getAttribute('data-image-id');
            var content_id = this.el.getAttribute('data-content-id');

            var hotspots = document.querySelectorAll('.hotspot-wrapper');
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', false);
            }

            var sphere = document.querySelector('#photosphere');

            /* do not allow selecting the current photo sphere again */
            if (sphere.getAttribute('material').src.id != 'img-photosphere-' + image_id) {

                sphere.emit('photosphere-fade-out');
                sphere.setAttribute('material', 'src', '#img-photosphere-' + image_id);
                sphere.setAttribute('data-content-id', content_id);

                var materialtextureloaded_listener = function() {

                    /* reset camera rotation in order to let people see the photo sphere title, if set */
                    var camera = document.querySelector('#camera');
                    camera.setAttribute('rotation', { x:0, y:0, z:0 });

                    document.querySelector('#photosphere-menu').setAttribute('visible', false);

                    self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();

                    /* set visible to true on hotspot wrapper, opacity is still 0 so they are invisible */
                    var hotspot_wrapper = document.querySelectorAll('.hotspot-wrapper-content-id-' + content_id);
                    for (var i = 0; i < hotspot_wrapper.length; i++) {
                        hotspot_wrapper[i].setAttribute('visible', true);
                    }
                    /* animation */
                    var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
                    for (var i = 0; i < hotspots.length; i++) {
                        hotspots[i].setAttribute('visible', true);
                        hotspots[i].emit('hotspot-intro-' + content_id);
                    }

                    var title = document.querySelector('#photosphere-title-content-id-' + content_id);
                    if (title != null) {
                        title.setAttribute('position', { x: 0, y:1.6, z:-2 });
                        title.setAttribute('visible', true);
                        setTimeout(function() {
                            title.setAttribute('visible', false);
                            /* workaround because of interference with menu */
                            title.setAttribute('position', { x: 0, y:1.6, z:-10 });
                        }, 10000);
                    }
                    sphere.emit('photosphere-fade-in');
                    sphere.removeEventListener('materialtextureloaded', materialtextureloaded_listener);
                };
                sphere.addEventListener('materialtextureloaded', materialtextureloaded_listener);

            } /* if */

        } /* if */

    },

    update: function(oldData) {},

    remove: function() {}

});
