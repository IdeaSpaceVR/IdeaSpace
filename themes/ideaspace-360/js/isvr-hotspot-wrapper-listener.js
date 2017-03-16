AFRAME.registerComponent('isvr-hotspot-wrapper-listener', {
  
    init: function () {

        this.el.addEventListener('mouseenter', function() {

            document.querySelector('#cursor').setAttribute('visible', true);
        });

        this.el.addEventListener('mouseleave', function() {

            if (document.querySelector('#photosphere-menu').getAttribute('visible') == false) {
                document.querySelector('#cursor').setAttribute('visible', false);
            }
        });

        this.el.addEventListener('click', function() {

            //this.emit('hotspot-outro-' + this.getAttribute('data-content-id'));        
            this.setAttribute('visible', false);
            document.querySelector('.hotspot-text-content-id-' + this.getAttribute('data-text-content-id')).setAttribute('visible', true);
        });

    }
});

