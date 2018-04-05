var isvr_assets = {

    init: function (u) {

        this.all_assets_ready = {};

				this.url = u;

				this.sceneEl = document.querySelector('a-scene');

        this.xmlhttp = new XMLHttpRequest();
        this.xmlhttp.onreadystatechange = this.responseHandler.bind(this);
        this.xmlhttp.open('GET', this.url, true);
        this.xmlhttp.send();

        var interval = setInterval((function() {

            var done = false;
            for (var k in this.all_assets_ready) {
                if (this.all_assets_ready[k] == true && (typeof document.querySelectorAll('.img-photosphere-0')[0] !== 'undefined')) {
                    done = true;
                } else {
                    done = false;
                }
            }

            if (done) {

                clearInterval(interval);

                /* set initial photo sphere */
                var id = document.querySelectorAll('.img-photosphere-0')[0].id;
                var content_id = document.querySelectorAll('.img-photosphere-0')[0].dataset.contentId;

                var sphere = document.querySelector('#photosphere');
                 
                sphere.setAttribute('material', 'src', '#' + id);
                sphere.setAttribute('data-content-id', content_id);

                //var camera = document.querySelector('#camera');
                //camera.setAttribute('rotation', { x: 0, y: this.data.camera_rotation, z: 0 }); 
                //camera.setAttribute('rotation', { x: 0, y: 0, z: 0 }); 

                var photosphere_texture_loaded_listener = function() {

                    document.querySelector('#photosphere-loading').setAttribute('visible', false);
                    document.querySelector('#photosphere-loading-background').setAttribute('visible', false);
                    document.querySelector('#photosphere-loading-anim').stop();

                    document.querySelector('#photosphere-start-btn').setAttribute('visible', true);

                    var intro_mouseenter = function() {
                        this.sceneEl.systems['isvr-scene-helper'].showCursor();
                    };
                    var intro_mouseleave = function() {
                        this.sceneEl.systems['isvr-scene-helper'].hideCursor();
                    };
                    document.querySelector('#intro-0').addEventListener('mouseenter', intro_mouseenter);
                    document.querySelector('#intro-0').addEventListener('mouseleave', intro_mouseleave);

                    document.querySelector('#intro-0').addEventListener('click', function(evt) {

                        document.querySelector('#intro-0').removeEventListener('mouseenter', intro_mouseenter);
                        document.querySelector('#intro-0').removeEventListener('mouseleave', intro_mouseleave);
                        this.sceneEl.systems['isvr-scene-helper'].hideCursor();

                        // workaround because of interference with menu
                        document.querySelector('#intro-0').setAttribute('position', { x: 0, y: 1.6, z: -10 });
                        document.querySelector('#no-hmd-intro').setAttribute('position', { x: 0, y: 1.6, z: -10 });

                        document.querySelector('#intro-0').setAttribute('visible', false);
                        document.querySelector('#no-hmd-intro').setAttribute('visible', false);

                        var hotspots = document.querySelectorAll('.hotspot-wrapper-content-id-' + content_id);
                        for (var i = 0; i < hotspots.length; i++) {
                            hotspots[i].setAttribute('visible', true);
                        }
                        hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
                        for (var i = 0; i < hotspots.length; i++) {
                            hotspots[i].setAttribute('visible', true);
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

                        sphere.removeEventListener('materialtextureloaded', photosphere_texture_loaded_listener);
                    });

                };
                sphere.addEventListener('materialtextureloaded', photosphere_texture_loaded_listener); 

            } /* if */

        }).bind(this), 1000);

    },

    responseHandler: function () {

        var self = this;

        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);

            for (var i=0; i<obj['photo-spheres'].length; i++) {

                /* 1st photo sphere asset, to show immediately */
                var photosphere_image = new Image();
                photosphere_image.onload = (function(content_id, i, length) {
                    return function() {
                        var image_elem = document.createElement('img');

                        image_elem.setAttribute('id', 'img-photosphere-' + content_id);
                        image_elem.setAttribute('class', 'img-photosphere-' + i);
                        image_elem.setAttribute('data-content-id', content_id);
                        image_elem.setAttribute('src', this.src);

                        var assets = document.querySelector('a-assets');
                        assets.appendChild(image_elem);

                        self.all_assets_ready[content_id] = true;
                    }
                }(obj['photo-spheres'][i]['photo-sphere']['#content-id'], i, obj['photo-spheres'].length));
                photosphere_image.src = obj['photo-spheres'][i]['photo-sphere']['#uri']['#value'];

            } /* for */

        } /* if */

    }

};


