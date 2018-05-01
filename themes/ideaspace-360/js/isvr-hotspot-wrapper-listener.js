AFRAME.registerComponent('isvr-hotspot-wrapper-listener', {
  
    init: function () {

        var self = this;

        this.el.addEventListener('mouseenter', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                self.el.sceneEl.systems['isvr-scene-helper'].showCursor();
            }
        });

        this.el.addEventListener('mouseleave', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();
            }
        });

        this.el.addEventListener('click', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                var hotspot_text = document.querySelectorAll('.hotspot-text');
                for (var i = 0; i < hotspot_text.length; i++) {
                    hotspot_text[i].setAttribute('visible', false);
                }

                var content_id = document.querySelector('#photosphere').getAttribute('data-content-id');
                var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
                for (var i = 0; i < hotspots.length; i++) {
                    hotspots[i].setAttribute('visible', true);
                }

                this.setAttribute('visible', false);

								document.querySelector('.hotspot-text-content-id-' + this.getAttribute('data-text-content-id')).setAttribute('position', {x:0, y:1.6, z:-2.1});
                document.querySelector('.hotspot-text-content-id-' + this.getAttribute('data-text-content-id')).setAttribute('visible', true);
            }
        });

    }
});

