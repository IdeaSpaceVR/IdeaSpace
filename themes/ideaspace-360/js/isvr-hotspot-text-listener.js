AFRAME.registerComponent('isvr-hotspot-text-listener', {
  
    init: function () {

        this.el.addEventListener('click', function() {
        
            this.setAttribute('visible', false);
        });

    }
});

