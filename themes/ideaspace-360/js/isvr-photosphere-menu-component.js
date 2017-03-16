AFRAME.registerComponent('isvr-photosphere-menu', {

    init: function() {

        document.querySelector('#photosphere').addEventListener('click', this.onClick.bind(this));

        this.yaxis = new THREE.Vector3(0, 1, 0);
        this.zaxis = new THREE.Vector3(0, 0, 1);

        this.pivot = new THREE.Object3D();
        this.el.object3D.position.set(0, document.querySelector('#camera').object3D.getWorldPosition().y, -4);

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

        var hotspot_wrapper = document.querySelectorAll('.hotspot-wrapper');
        for (var i = 0; i < hotspot_wrapper.length; i++) {
            hotspot_wrapper[i].setAttribute('visible', true);
        }


        if (hide_hotspot_text == false && document.getElementsByClassName('img-photosphere-thumb').length > 1 && 
            this.el.getAttribute('visible') == false && 
            document.querySelector('#photosphere-loading').getAttribute('visible') == false) {

            /* set visible to false on hotspot wrapper in order to avoid transparency issues; opacity is still 0 */
            var hotspot_wrapper = document.querySelectorAll('.hotspot-wrapper');
            for (var i = 0; i < hotspot_wrapper.length; i++) {
                hotspot_wrapper[i].setAttribute('visible', false);
            }            

            var direction = this.zaxis.clone();
            direction.applyQuaternion(document.querySelector('#camera').object3D.quaternion);
            var ycomponent = this.yaxis.clone().multiplyScalar(direction.dot(this.yaxis));
            direction.sub(ycomponent);
            direction.normalize();

            this.pivot.quaternion.setFromUnitVectors(this.zaxis, direction);
            this.pivot.position.copy(document.querySelector('#camera').object3D.getWorldPosition()); 

            this.el.setAttribute('visible', true);
            document.querySelector('#cursor').setAttribute('visible', true);

        } else if (hide_hotspot_text == false && document.getElementsByClassName('img-photosphere-thumb').length > 1 && this.el.getAttribute('visible') == true) {

            /* set visible to true on hotspot wrapper, opacity is still 0 so they are invisible */
            var hotspot_wrapper = document.querySelectorAll('.hotspot-wrapper');
            for (var i = 0; i < hotspot_wrapper.length; i++) {
                hotspot_wrapper[i].setAttribute('visible', true);
            }

            this.el.setAttribute('visible', false);
            document.querySelector('#cursor').setAttribute('visible', false);
        }

    },

    update: function(oldData) {},

    remove: function() {}

});


