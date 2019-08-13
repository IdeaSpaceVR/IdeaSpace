AFRAME.registerComponent('isvr-about-link', {


		schema: {
		},
  

    init: function () {

				var self = this;
				var soundClick = document.querySelector('#sound-click');


				this.el.addEventListener('mouseenter', function(evt) {
						self.el.setAttribute('material', 'target', '#about-link-hover-texture');
        });


        this.el.addEventListener('mouseleave', function() {
						self.el.setAttribute('material', 'target', '#about-link-texture');
        });


				/* show */
				this.el.addEventListener('click', function() {

						soundClick.components.sound.stopSound();
            soundClick.components.sound.playSound();

						if (document.getElementById('about-wrapper').getAttribute('visible') == false) {

								document.getElementById('about-wrapper').emit('show-about');
								document.getElementById('about-wrapper').setAttribute('visible', true);

								document.getElementById('posts-wrapper').setAttribute('visible', false);

						} else {

								document.getElementById('about-wrapper').emit('hide-about');
						}
        });


				/* hide */
				document.getElementById('about-wrapper').addEventListener('click', function() {

						soundClick.components.sound.stopSound();
            soundClick.components.sound.playSound();

            document.getElementById('about-wrapper').emit('hide-about');
        });


				/* hide */
				document.getElementById('about-wrapper').addEventListener('animationcomplete', function(e) {

						if (e.detail.name == 'animation__hide_about') {

        				document.getElementById('about-wrapper').setAttribute('visible', false);

								document.getElementById('posts-wrapper').setAttribute('visible', true);

						} else if (e.detail.name == 'animation__show_about') {

								//document.getElementById('posts-wrapper').setAttribute('visible', false);

						}
				});

		}

});


