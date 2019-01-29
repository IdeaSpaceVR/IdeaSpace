AFRAME.registerComponent('isvr-link-hover', {


		schema: {
				id: {
            type: 'string'
        }
		},
  

    init: function () {

				var self = this;
				var texture_id = self.el.children[0].getAttribute('material').target;

				this.el.addEventListener('mouseenter', function(evt) {
						if (self.texture_id != null) {
								document.querySelector('#' + self.data.id).setAttribute('visible', true);
								self.el.children[0].setAttribute('material', 'target', self.texture_id + '-active');						
						} else {
								self.texture_id = self.el.children[0].getAttribute('material').target;
						}
        });

        this.el.addEventListener('mouseleave', function() {
						document.querySelector('#' + self.data.id).setAttribute('visible', false);
						self.el.children[0].setAttribute('material', 'target', self.texture_id);						
        });
		}

});

