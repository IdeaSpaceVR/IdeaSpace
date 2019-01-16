AFRAME.registerComponent('isvr-navigation-down', {


		schema: {
				cid: {
            type: 'number'
        }
		},

  
    init: function () {

				var self = this;

        this.el.addEventListener('click', function() {
						document.getElementById('posts-wrapper').emit('nav_down_' + self.data.cid);		
				});	
		}

});

