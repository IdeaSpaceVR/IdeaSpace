AFRAME.registerComponent('isvr-photosphere-menu-thumb', {

    init: function() {

      this.el.addEventListener('click', this.onClick.bind(this));
      
    },

    onClick: function(evt) {

      var position = this.el.getAttribute('position');

      /* prevent immediate selection of image after menu appears */
      if (this.el.parentEl.getAttribute('visible') && position.z == 0.5) {

        var id = this.el.getAttribute('data-image-id');
        id = '#img-photosphere-' + id;

        /* keep menu if material is the same */
        if (document.querySelector('#photosphere').getAttribute('material').src != id) {

          document.querySelector('#photosphere-menu').setAttribute('visible', false);
          document.querySelector('#cursor').setAttribute('visible', false);
          document.querySelector('#photosphere').setAttribute('material', 'src', id);

        }
      }

    },

    update: function(oldData) {
    },

    remove: function() {
    }

});
