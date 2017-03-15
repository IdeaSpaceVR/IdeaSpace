AFRAME.registerComponent('isvr-photosphere-menu-thumb', {

    init: function() {

      this.el.addEventListener('click', this.onClick.bind(this));
      
    },

    onClick: function(evt) {

      var position = this.el.getAttribute('position');

      /* prevent immediate selection of image after menu appears */
      if (this.el.parentEl.getAttribute('visible') && position.z == 0.5) {

        var image_id = this.el.getAttribute('data-image-id');
        var content_id = this.el.getAttribute('data-content-id');

        var hotspots = document.querySelectorAll('.hotspot');
        for (var i = 0; i < hotspots.length; i++) {
            hotspots[i].setAttribute('visible', 'false');
        }

        document.querySelector('#photosphere-menu').setAttribute('visible', false);
        document.querySelector('#cursor').setAttribute('visible', false);
        document.querySelector('#photosphere').setAttribute('material', 'src', '#img-photosphere-' + image_id);
      
        setTimeout(function() { 
            var hotspots = document.querySelectorAll('.hotspot-content-id-' + content_id);
            for (var i = 0; i < hotspots.length; i++) {
                hotspots[i].setAttribute('visible', 'true');
                hotspots[i].emit('hotspot-intro-' + content_id);
            }
        }, 1000);

      }

    },

    update: function(oldData) {},

    remove: function() {}

});
