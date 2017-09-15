AFRAME.registerComponent('isvr-hotspot-navigation-wrapper-listener', {
  
    init: function () {

        var self = this;

        this.el.addEventListener('mouseenter', function() {

            self.el.sceneEl.systems['isvr-scene-helper'].showCursor();

            var sphere = document.querySelector('#photosphere');
            var content_id = sphere.getAttribute('data-content-id');            

            var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', false);
            }

            var target_content_id = this.getAttribute('data-content-id');

            var titles = document.querySelectorAll('.photosphere-title-target-content-id-' + target_content_id + '-content-id-' + content_id);
            for (var i = 0; i < titles.length; i++) {
                if (titles[i] != null) {
                    titles[i].setAttribute('position', { x: 1.05, y: 0, z: 0.4 });
                    titles[i].setAttribute('visible', true);
                }
            }

        });

        this.el.addEventListener('mouseleave', function() {

            self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();

            var sphere = document.querySelector('#photosphere');
            var content_id = sphere.getAttribute('data-content-id');            

            var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', true);
            }

            var target_content_id = this.getAttribute('data-content-id');

            var titles = document.querySelectorAll('.photosphere-title-target-content-id-' + target_content_id + '-content-id-' + content_id);
            for (var i = 0; i < titles.length; i++) {
                if (titles[i] != null) {
                    titles[i].setAttribute('position', { x: 0, y: 10, z: -2.1 });
                    titles[i].setAttribute('visible', false);
                }
            }
        });

        this.el.addEventListener('click', function() {

            var titles = document.querySelectorAll('.photosphere-title');
            for (var i = 0; i < titles.length; i++) {
                titles[i].setAttribute('visible', false);
            }

            var hotspots = document.querySelectorAll('.hotspot');
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', false);
            }

            var hotspot_text = document.querySelectorAll('.hotspot-text');
            for (var i = 0; i < hotspot_text.length; i++) {
                hotspot_text[i].setAttribute('visible', false);
            }

            hotspots = document.querySelectorAll('.hotspot-navigation');
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', false);
            }

            var content_id = this.getAttribute('data-content-id');

            var sphere = document.querySelector('#photosphere');
            sphere.emit('photosphere-fade-out');

            sphere.setAttribute('data-content-id', content_id);

            self.el.sceneEl.systems['isvr-scene-helper'].hideCursor();

            var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', true);
                hotspots[i].emit('hotspot-intro-' + content_id);
            }

            hotspots = document.querySelectorAll('.hotspot-navigation-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', true);
            }

            //var camera = document.querySelector('#camera');
            //camera.setAttribute('rotation', { x: 0, y: this.getAttribute('data-camera-rotation'), z: 0 });
            //camera.setAttribute('rotation', { x: 0, y: 0, z: 0 });

            sphere.setAttribute('material', 'src', '#img-photosphere-' + content_id);
            sphere.emit('photosphere-fade-in');

        });

    }
});

