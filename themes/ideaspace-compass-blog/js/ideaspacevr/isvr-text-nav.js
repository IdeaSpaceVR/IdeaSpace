AFRAME.registerComponent('isvr-text-nav', {


		bindMethods: function () {
				
				/* mouse nav */
				this.mouse_wheel_handler = this.mouse_wheel_handler.bind(this);
				this.mouseenter_handler = this.mouseenter_handler.bind(this);
				this.mouseleave_handler = this.mouseleave_handler.bind(this);

				/* touch screen nav */
				this.touch_start_handler = this.touch_start_handler.bind(this);
				this.touch_move_handler = this.touch_move_handler.bind(this);
				this.touch_end_handler = this.touch_end_handler.bind(this);
				this.touch_cancel_handler = this.touch_cancel_handler.bind(this);

				/* thumbpads / thumbsticks vr controller nav */
				this.thumbupstart_handler = this.thumbupstart_handler.bind(this);
				this.thumbupend_handler = this.thumbupend_handler.bind(this);
				this.thumbdownstart_handler = this.thumbdownstart_handler.bind(this);
				this.thumbdownend_handler = this.thumbdownend_handler.bind(this);

				/* trackpad oculus go controller nav */
				this.trackpadtouchstart_handler = this.trackpadtouchstart_handler.bind(this);
				this.trackpadmoved_handler = this.trackpadmoved_handler.bind(this);
				this.trackpadtouchend_handler = this.trackpadtouchend_handler.bind(this);
		},


    init: function () {

				this.bindMethods();

				/* set top end position for text boxes higher than 3 */
				var offset = 0;
				if ((this.el.getAttribute('height') / 2) > 3) {
						offset = -(this.el.getAttribute('height') / 2) + 1;
				}
				this.el.setAttribute('position', { x: this.el.getAttribute('position').x, y: offset, z: this.el.getAttribute('position').z });
				

				this.tcup_delta = -0.05; 
				this.tcdown_delta = 0.05; 
				this.thumbupstart = false;
				this.thumbdownstart = false;
				this.last_time = 0;
				this.touchdown = false;
				this.previousTouchY = 0;

				this.el.addEventListener('mouseenter', this.mouseenter_handler); 
				this.el.addEventListener('mouseleave', this.mouseleave_handler); 

				window.isvr_text_nav_mw_listenerset = false;
				window.isvr_text_nav_tc_listenerset = false;
		},


		thumbupstart_handler: function (e) {
				this.thumbupstart = true;
		},


		thumbupend_handler: function (e) {
				this.thumbupstart = false;
		},


		thumbdownstart_handler: function (e) {
				this.thumbdownstart = true;
		},


		thumbdownend_handler: function (e) {
				this.thumbdownstart = false;
		},


		trackpadtouchstart_handler: function (e) {
				this.trackpadtouchstart = true;
		},


		trackpadtouchend_handler: function (e) {
				this.trackpadtouchstart = false;
		},


		trackpadmoved_handler: function (e) {

				if (Math.abs(e.detail.y) > 0.5) {

						this.trackpadmoveup = true;
						this.trackpadmovedown = false;

				} else if (Math.abs(e.detail.y) < 0.5) {

						this.trackpadmoveup = false;
						this.trackpadmovedown = true;
				}
		},


		tick: function (time) {

				if (!this.last_time || time - this.last_time >= 30) {

						this.last_time = time;

						if ((this.thumbupstart == true && this.thumbdownstart == false) || (this.trackpadtouchstart == true && this.trackpadmoveup == true && this.trackpadmovedown == false)) {

								var positionTmp = this.positionTmp = this.positionTmp || {x: 0, y: 0, z: 0};

								var pos = this.el.getAttribute('position');
								var height = this.el.getAttribute('height');

								/* top end */
								if (-((height / 2) - 0.5) < pos.y) {
										positionTmp.x = pos.x; 
										positionTmp.y = (pos.y + this.tcup_delta); 
										positionTmp.z = pos.z; 
										this.el.setAttribute('position', positionTmp);
								}
						}

						if ((this.thumbdownstart == true && this.thumbupstart == false) || (this.trackpadtouchstart == true && this.trackpadmovedown == true && this.trackpadmoveup == false)) {

								var positionTmp = this.positionTmp = this.positionTmp || {x: 0, y: 0, z: 0};

								var pos = this.el.getAttribute('position');
								var height = this.el.getAttribute('height');

								/* bottom end */
								if (((height / 2) - 0.5) > pos.y) {
										positionTmp.x = pos.x; 
										positionTmp.y = (pos.y + this.tcdown_delta); 
										positionTmp.z = pos.z; 
										this.el.setAttribute('position', positionTmp);
								}
						}
				}
		},


		mouseenter_handler: function (e) {

				if (window.isvr_text_nav_mw_listenerset == false) {

						/* IE9, Chrome, Safari, Opera */
						window.addEventListener('mousewheel', this.mouse_wheel_handler, false);
						/* Firefox */
						window.addEventListener('DOMMouseScroll', this.mouse_wheel_handler, false);
						/* touch devices */
						var canvasEl = this.el.sceneEl.canvas;
						canvasEl.addEventListener('touchstart', this.touch_start_handler, false);
						canvasEl.addEventListener('touchmove', this.touch_move_handler, false);
						canvasEl.addEventListener('touchend', this.touch_end_handler, false);
						canvasEl.addEventListener('touchcancel', this.touch_cancel_handler, false);

						window.isvr_text_nav_mw_listenerset = true;
				}

				if (this.el.sceneEl.is('entered-vr') && window.isvr_text_nav_tc_listenerset == false) {

						var laser_controls = document.querySelectorAll('.laser-controls');
						if (laser_controls != null) {
								for (var i = 0; i < laser_controls.length; i++) {

										laser_controls[i].addEventListener('thumbupstart', this.thumbupstart_handler, false);
										laser_controls[i].addEventListener('thumbupend', this.thumbupend_handler, false);
										laser_controls[i].addEventListener('thumbdownstart', this.thumbdownstart_handler, false);
										laser_controls[i].addEventListener('thumbdownend', this.thumbdownend_handler, false);

										laser_controls[i].addEventListener('trackpadtouchstart', this.trackpadtouchstart_handler, false);
										laser_controls[i].addEventListener('trackpadtouchend', this.trackpadtouchend_handler, false);
										laser_controls[i].addEventListener('trackpadmoved', this.trackpadmoved_handler, false);

										window.isvr_text_nav_tc_listenerset = true;
								}
						}
				}
		},


		mouseleave_handler: function (e) {

				if (window.isvr_text_nav_mw_listenerset == true) {

						/* IE9, Chrome, Safari, Opera */
						window.removeEventListener('mousewheel', this.mouse_wheel_handler, false);
						/* Firefox */
						window.removeEventListener('DOMMouseScroll', this.mouse_wheel_handler, false);
						/* touch devices */
						var canvasEl = this.el.sceneEl.canvas;
						canvasEl.removeEventListener('touchstart', this.touch_start_handler, false);
						canvasEl.removeEventListener('touchmove', this.touch_move_handler, false);
						canvasEl.removeEventListener('touchend', this.touch_end_handler, false);
						canvasEl.removeEventListener('touchcancel', this.touch_cancel_handler, false);

						window.isvr_text_nav_mw_listenerset = false;
				}

				if (this.el.sceneEl.is('entered-vr') && window.isvr_text_nav_tc_listenerset == true) {

						var laser_controls = document.querySelectorAll('.laser-controls');
						if (laser_controls != null) {
								for (var i = 0; i < laser_controls.length; i++) {

										laser_controls[i].removeEventListener('thumbupstart', this.thumbupstart_handler, false);
										laser_controls[i].removeEventListener('thumbupend', this.thumbupend_handler, false);
										laser_controls[i].removeEventListener('thumbdownstart', this.thumbdownstart_handler, false);
										laser_controls[i].removeEventListener('thumbdownend', this.thumbdownend_handler, false);

										laser_controls[i].removeEventListener('trackpadtouchstart', this.trackpadtouchstart_handler, false);
										laser_controls[i].removeEventListener('trackpadtouchend', this.trackpadtouchend_handler, false);
										laser_controls[i].removeEventListener('trackpadmoved', this.trackpadmoved_handler, false);

										window.isvr_text_nav_tc_listenerset = false;
								}
						}
				}
		},


		touch_start_handler: function (e) {

				this.touchdown = true;
				this.previousTouchY = e.touches[0].screenY;
		},


		touch_move_handler: function (e) {

				if (!this.touchdown) {
						return;
				}

				var touch = e.touches[0];
				var movementY = (touch.screenY - this.previousTouchY) * -1;

				var pos = this.el.getAttribute('position');
				var height = this.el.getAttribute('height');

				/* top end */
				if (-((height / 2) - 0.5) < pos.y && Math.sign(movementY) == -1) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y - 0.10), z: pos.z });
				}

				/* bottom end */
				if (((height / 2) - 0.5) > pos.y && Math.sign(movementY) == 1) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + 0.10), z: pos.z });
				}

				this.previousTouchY = touch.screenY;
		},


		touch_end_handler: function (e) {

				this.touchdown = false;
		},


		touch_cancel_handler: function (e) {

				this.touchdown = false;
		},

		
		mouse_wheel_handler: function (e) {

				var e = window.event || e; 
		    var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
				delta = delta / 4;
				delta *= -1; /* change scroll direction */

				var pos = this.el.getAttribute('position');
				var height = this.el.getAttribute('height');

				/* top end */
				if (-((height / 2) - 0.5) < pos.y && Math.sign(delta) == -1) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + delta), z: pos.z });
				}

				/* bottom end */
				if (((height / 2) - 0.5) > pos.y && Math.sign(delta) == 1) {
						this.el.setAttribute('position', { x: pos.x, y: (pos.y + delta), z: pos.z });
				}

    		return false;
		}

});

