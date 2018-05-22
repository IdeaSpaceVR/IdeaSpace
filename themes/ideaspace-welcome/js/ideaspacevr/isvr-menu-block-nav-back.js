AFRAME.registerComponent('isvr-menu-block-nav-back', {


		schema: {
				inactivecolor: {
						type: 'string'
				},
				activecolor: {
						type: 'string'
				}
		},

  
    init: function () {

				var self = this;
				var data = this.data;
				var all = document.querySelectorAll('.nav-circle');


				this.el.addEventListener('mouseenter', function(evt) {

						if (!all[0].is('active')) {
								self.el.setAttribute('color', data.activecolor);
						}
        });


        this.el.addEventListener('mouseleave', function() {

						self.el.setAttribute('color', data.inactivecolor);
        });


				var j = 0;

        this.el.addEventListener('click', function() {

						if (all[0].is('active')) {
								return;
						}

						var activeEl = null;

            for (var i=(all.length - 1); i>=0; i--) {
								if (all[i].is('active')) {
										all[i].removeState('active');
										all[i].setAttribute('color', data.inactivecolor);
										activeEl = all[i];
										j = i;
										j--;
								}
						}

						while (j >= 0) {
								var current_number = activeEl.getAttribute('isvr-menu-block-nav').show.slice(-1);
                var next_number = parseInt(current_number) - 1;

                document.querySelector('#item-wrapper').emit('from_' + current_number + '_to_' + next_number);

								/* show next menu block */
                setTimeout(function() {
										document.querySelector('#menu-block-' + next_number).setAttribute('visible', true);
                }, 300);

								 /* workaround to hide current menu block */
                setTimeout(function() {
                    document.querySelector('#' + activeEl.getAttribute('isvr-menu-block-nav').show.replace(/_/g, '-')).setAttribute('visible', false);
                }, 500);

								all[j].setAttribute('color', data.activecolor);
								all[j].addState('active');
								return;
            }

				});
	
		}

});

