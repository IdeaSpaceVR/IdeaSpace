AFRAME.registerComponent('isvr-hotspot-wrapper-listener', {
  
    init: function () {

        this.el.addEventListener('mouseenter', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                document.querySelector('#cursor').setAttribute('visible', true);
            }
        });

        this.el.addEventListener('mouseleave', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                document.querySelector('#cursor').setAttribute('visible', false);
            }
        });

        this.el.addEventListener('click', function() {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id') && 
                document.querySelector('#photosphere-menu').getAttribute('visible') == false) {

                this.setAttribute('visible', false);

                var hotspot_text = document.querySelectorAll('.hotspot-text');
                for (var i = 0; i < hotspot_text.length; i++) {
                    hotspot_text[i].setAttribute('visible', false);
                }

                var content_id = document.querySelector('#photosphere').getAttribute('data-content-id');
                var hotspots = document.querySelectorAll('.hotspot-wrapper-content-id-' + content_id);
                for (var i = 0; i < hotspots.length; i++) {
                    hotspots[i].setAttribute('visible', false);
                }

                document.querySelector('.hotspot-text-content-id-' + this.getAttribute('data-text-content-id')).setAttribute('visible', true);
            }
        });

    }
});

