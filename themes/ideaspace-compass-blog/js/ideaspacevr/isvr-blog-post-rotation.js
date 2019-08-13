AFRAME.registerComponent('isvr-blog-post-rotation', {


		bindMethods: function () {

				this.mouseenter_handler = this.mouseenter_handler.bind(this);
        this.mouseleave_handler = this.mouseleave_handler.bind(this);

				this.thumbstart_handler = this.thumbstart_handler.bind(this);
				this.thumbend_handler = this.thumbend_handler.bind(this);
		},


		schema: {
        dir: {
            type: 'string'
        }
    },


    init: function () {

				this.bindMethods();

				this.rotation_delta = 1.7; 
				this.thumbstart = false;
				this.last_time = 0;
				this.posts = document.querySelector('#posts-wrapper');

				this.el.addEventListener('mouseenter', this.mouseenter_handler); 
				this.el.addEventListener('mouseleave', this.mouseleave_handler); 
		},


		mouseenter_handler: function (e) {

				if (this.data.dir == 'left') {
						this.el.setAttribute('material', 'target', '#blog-post-rotate-left-hover-texture');
				} else if (this.data.dir == 'right') {
						this.el.setAttribute('material', 'target', '#blog-post-rotate-right-hover-texture');
				}

				if (this.el.sceneEl.is('entered-vr')) {

            var laser_controls = document.querySelectorAll('.laser-controls');
            if (laser_controls != null) {
                for (var i = 0; i < laser_controls.length; i++) {

                    laser_controls[i].addEventListener('thumbstart', this.thumbstart_handler, false);
                    laser_controls[i].addEventListener('thumbend', this.thumbend_handler, false);
                    laser_controls[i].addEventListener('mousedown', this.thumbstart_handler, false);
                    laser_controls[i].addEventListener('mouseup', this.thumbend_handler, false);
                }
            }
        }
		},


		mouseleave_handler: function (e) {

				if (this.data.dir == 'left') {
						this.el.setAttribute('material', 'target', '#blog-post-rotate-left-texture');
				} else if (this.data.dir == 'right') {
						this.el.setAttribute('material', 'target', '#blog-post-rotate-right-texture');
				}

				if (this.el.sceneEl.is('entered-vr')) {

						this.thumbstart = false;

            var laser_controls = document.querySelectorAll('.laser-controls');
            if (laser_controls != null) {
                for (var i = 0; i < laser_controls.length; i++) {

                    laser_controls[i].removeEventListener('thumbstart', this.thumbstart_handler, false);
                    laser_controls[i].removeEventListener('thumbend', this.thumbend_handler, false);
                    laser_controls[i].removeEventListener('mousedown', this.thumbstart_handler, false);
                    laser_controls[i].removeEventListener('mouseup', this.thumbend_handler, false);
                }
            }
        }
		},


		thumbstart_handler: function (e) {
				this.thumbstart = true;
		},


		thumbend_handler: function (e) {
				this.thumbstart = false;
		},


		tick: function (time) {

				if (this.thumbstart) {

						if (!this.last_time || time - this.last_time >= 30) {

								this.last_time = time;

								var rotationTmp = this.rotationTmp = this.rotationTmp || {x: 0, y: 0, z: 0};
								var rotation = this.posts.getAttribute('rotation');

								if (this.data.dir == 'left') {
										rotationTmp.x = rotation.x; 
										rotationTmp.y = (rotation.y + this.rotation_delta); 
										rotationTmp.z = rotation.z; 
								}

								if (this.data.dir == 'right') {
										rotationTmp.x = rotation.x; 
										rotationTmp.y = (rotation.y - this.rotation_delta); 
										rotationTmp.z = rotation.z; 
								}

								this.posts.setAttribute('rotation', rotationTmp);
						}
				}
		},


});

