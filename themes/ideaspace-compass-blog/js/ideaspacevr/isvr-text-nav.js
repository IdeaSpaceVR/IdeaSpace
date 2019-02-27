AFRAME.registerComponent('isvr-text-nav', {


    init: function () {

				this.el.addEventListener('mouseenter', this.mouseenter_handler.bind(this)); 

				this.el.addEventListener('mouseleave', this.mouseleave_handler.bind(this)); 

				this.handler = this.mouse_wheel_handler.bind(this);

				window.listenerset = false;
		},


		mouseenter_handler: function(e) {

				if (window.listenerset == false) {

						/* IE9, Chrome, Safari, Opera */
						window.addEventListener('mousewheel', this.handler, false);
						/* Firefox */
						window.addEventListener('DOMMouseScroll', this.handler, false);

						window.listenerset = true;
				}
		},


		mouseleave_handler: function(e) {

				if (window.listenerset == true) {

						/* IE9, Chrome, Safari, Opera */
						window.removeEventListener('mousewheel', this.handler, false);
						/* Firefox */
						window.removeEventListener('DOMMouseScroll', this.handler, false);

						window.listenerset = false;
				}
		},

		
		mouse_wheel_handler: function(e) {

				var e = window.event || e; 
		    var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
				delta = delta / 2;

				var pos = this.el.getAttribute('position');
				var height = this.el.getAttribute('height');

				/* bottom end */
				if (((height / 2) - 1) > pos.y) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + delta), z: pos.z });
				} else {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y - 0.5), z: pos.z });
				}

				/* top end */
				if (-((height / 2) - 0.5) < pos.y) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + delta), z: pos.z });
				} else {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + 0.5), z: pos.z });
				}

    		return false;
		}

});

