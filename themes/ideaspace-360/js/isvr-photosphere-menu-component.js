AFRAME.registerComponent('isvr-photosphere-menu', {

    /* in play: otherwide AFRAME.utils.device.checkHeadsetConnected() returns false */
    play: function() {

        if (AFRAME.utils.device.checkHeadsetConnected()) {

            document.querySelector('#photosphere').addEventListener('click', this.onClick.bind(this));

        } else if (!AFRAME.utils.device.checkHeadsetConnected() && AFRAME.utils.device.isMobile()) {

            document.querySelector('#photosphere').addEventListener('click', this.onClick.bind(this));

        } else {

            window.onkeydown = (function(e) {
                var code = e.keyCode ? e.keyCode : e.which;
                /* space or enter keys */
                if (code === 13 || code === 32) { 
                    this.onClick();
                }
            }).bind(this);
        }


        this.yaxis = new THREE.Vector3(0, 1, 0);
        this.zaxis = new THREE.Vector3(0, 0, 1);

        this.pivot = new THREE.Object3D();
        //this.el.object3D.position.set(0, 1.6, -4);
        this.el.object3D.position.set(0, 100, -4);

        this.el.sceneEl.object3D.add(this.pivot);
        this.pivot.add(this.el.object3D);

    },

    onClick: function(evt) {

        var hide_hotspot_text = false;
        var hotspot_text = document.querySelectorAll('.hotspot-text');
        for (var i = 0; i < hotspot_text.length; i++) {
            if (hotspot_text[i].getAttribute('visible') == true) {
                hotspot_text[i].setAttribute('visible', false);
                /* hide hotspot texts on this click first, next click is for showing menu */
                hide_hotspot_text = true;
            }
        }            

        var hide_photosphere_title = false;
        var photosphere_title = document.querySelectorAll('.photosphere-title');
        for (var i = 0; i < photosphere_title.length; i++) {
            if (photosphere_title[i].getAttribute('visible') == true) {
                photosphere_title[i].setAttribute('visible', false);
                /* hide photo sphere title on this click first, next click is for showing menu */
                hide_photosphere_title = true;
            }
        }

        var content_id = document.querySelector('#photosphere').getAttribute('data-content-id');
        var hotspots = document.querySelectorAll('.hotspot-wrapper-content-id-' + content_id);
        for (var i = 0; i < hotspots.length; i++) {
            hotspots[i].setAttribute('visible', true);
        }



        if (hide_photosphere_title == false && 
						hide_hotspot_text == false && 
						document.getElementsByClassName('img-photosphere-thumb').length > 1 && 
            this.el.getAttribute('visible') == false && 
            document.querySelector('#photosphere-loading').getAttribute('visible') == false) {

            var hotspot_wrapper = document.querySelectorAll('.hotspot');
            for (var i = 0; i < hotspot_wrapper.length; i++) {
                hotspot_wrapper[i].setAttribute('visible', false);
            }            

            var direction = this.zaxis.clone();
            direction.applyQuaternion(document.querySelector('#camera').object3D.quaternion);
            var ycomponent = this.yaxis.clone().multiplyScalar(direction.dot(this.yaxis));
            direction.sub(ycomponent);
            direction.normalize();

            this.pivot.quaternion.setFromUnitVectors(this.zaxis, direction);

            this.el.setAttribute('position', { x: 0, y: 1.6, z: -4 });
            this.el.setAttribute('visible', true);

        } else if (hide_photosphere_title == false && 
						hide_hotspot_text == false && 
						document.getElementsByClassName('img-photosphere-thumb').length > 1 && 
						this.el.getAttribute('visible') == true) {

            this.el.setAttribute('position', { x: 0, y: 100, z: -4 });
            this.el.setAttribute('visible', false);

            var content_id = document.querySelector('#photosphere').getAttribute('data-content-id');

            var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', true);
            }

        }

    },

    update: function(oldData) {},

    remove: function() {}

});


