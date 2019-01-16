AFRAME.registerComponent('isvr-navigation-up', {


		schema: {
				cid: {
            type: 'number'
        }
		},

  
    init: function () {

				var self = this;

        this.el.addEventListener('click', function() {
						document.querySelector('#posts-wrapper').emit('nav_up_' + self.data.cid);		
				});	
		}

});

