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

            var title = document.querySelector('#photosphere-title-content-id-' + target_content_id);
            if (title != null) {
                title.setAttribute('position', { x: 1.05, y: 0, z: 0.4 });
                title.setAttribute('visible', true);
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

            var title = document.querySelector('#photosphere-title-content-id-' + target_content_id);
            if (title != null) {
                title.setAttribute('position', { x: 0, y: 10, z: -2.1 });
                title.setAttribute('visible', false);
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

            /*var n = 1;
            clearInterval(window.interval);
            window.interval = setInterval(function() {
                var hotspot_nav_arrow_1 = document.querySelectorAll('.hotspot-navigation-arrow-' + n + '-content-id-' + content_id);
                for (var i = 0; i < hotspot_nav_arrow_1.length; i++) {
                    hotspot_nav_arrow_1[i].setAttribute('visible', true);
                }
                if (n < 4) {
                    n++;
                } else {
                    n = 1;
                    var hotspot_nav_arrows = document.querySelectorAll('.hotspot-navigation-arrow');
                    for (var i = 0; i < hotspot_nav_arrows.length; i++) {
                        hotspot_nav_arrows[i].setAttribute('visible', false);
                    }
                }
            }, 1200);*/

            sphere.setAttribute('material', 'src', '#img-photosphere-' + content_id);
            sphere.emit('photosphere-fade-in');

        });

    }
});

