AFRAME.registerComponent('isvr-photosphere-title-listener', {
  
    init: function () {

        this.el.addEventListener('click', function() {
        
            this.setAttribute('visible', false);
        });

    }
});

