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

        if (document.getElementsByClassName('img-photosphere-thumb').length > 1 && 
            this.el.getAttribute('visible') == false && 
            document.querySelector('#photosphere-loading').getAttribute('visible') == false) {

            var direction = this.zaxis.clone();
            direction.applyQuaternion(document.querySelector('#camera').object3D.quaternion);
            var ycomponent = this.yaxis.clone().multiplyScalar(direction.dot(this.yaxis));
            direction.sub(ycomponent);
            direction.normalize();

            this.pivot.quaternion.setFromUnitVectors(this.zaxis, direction);
            this.pivot.position.copy(document.querySelector('#camera').object3D.getWorldPosition()); 

            this.el.setAttribute('visible', true);
            document.querySelector('#cursor').setAttribute('visible', true);

        } else if (document.getElementsByClassName('img-photosphere-thumb').length > 1 && this.el.getAttribute('visible') == true) {

            this.el.setAttribute('visible', false);
            document.querySelector('#cursor').setAttribute('visible', false);
        }

    },

    update: function(oldData) {},

    remove: function() {}

});


