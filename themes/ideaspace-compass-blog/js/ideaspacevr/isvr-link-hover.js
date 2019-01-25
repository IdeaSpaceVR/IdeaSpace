AFRAME.registerComponent('isvr-link-hover', {


		schema: {
				id: {
            type: 'string'
        }
		},
  

    init: function () {

				var self = this;

				this.el.addEventListener('mouseenter', function(evt) {
						document.querySelector('#' + self.data.id).setAttribute('visible', true);
        });

        this.el.addEventListener('mouseleave', function() {
						document.querySelector('#' + self.data.id).setAttribute('visible', false);
        });
		}

});

