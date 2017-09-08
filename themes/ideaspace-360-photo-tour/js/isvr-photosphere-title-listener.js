AFRAME.registerComponent('isvr-photosphere-title-listener', {
  
    init: function () {

        var self = this;

        this.el.addEventListener('mouseenter', function() {

            if (this.getAttribute('visible') == true) {
                self.el.sceneEl.systems['isvr-scene-helper'].showCursor();
            }
        });

        this.el.addEventListener('mouseleave', function() {

            if (this.getAttribute('visible') == true) {
                self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();
            }
        });

        this.el.addEventListener('click', function() {

            this.setAttribute('visible', false);
            this.setAttribute('data-shown', 'true');
            /* workaround because of interference with menu */
            this.setAttribute('position', { x: 0, y: 10, z: -2.1 });
 
            self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();
        });

    }
});

