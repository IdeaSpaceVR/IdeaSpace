AFRAME.registerComponent('isvr-hotspot-text-listener', {
  
    init: function () {

        this.el.addEventListener('click', function(e) {

            if (this.getAttribute('data-content-id') == document.querySelector('#photosphere').getAttribute('data-content-id')) {        

                this.setAttribute('visible', false);

                var hotspot_text = document.querySelectorAll('.hotspot-text');
                for (var i = 0; i < hotspot_text.length; i++) {
                    hotspot_text[i].setAttribute('visible', false);
                }                 

                var content_id = document.querySelector('#photosphere').getAttribute('data-content-id');

                /*var navigation_hotspots = document.querySelectorAll('.hotspot-navigation-content-id-' + content_id);
                for (var i = 0; i < navigation_hotspots.length; i++) {
                    navigation_hotspots[i].setAttribute('visible', true);
                }*/

                var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
                for (var i = 0; i < hotspots.length; i++) {
                    hotspots[i].setAttribute('visible', true);
                }                 

            }

        });

    }
});

