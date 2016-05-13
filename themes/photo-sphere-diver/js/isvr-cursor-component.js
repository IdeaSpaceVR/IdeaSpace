AFRAME.registerComponent('isvr-cursor', {

    schema: {},

      init: function() {

        /* show cursor */
        this.el.addEventListener('stateadded', function(evt) {

            /* only show cursor in home position */
            if (evt.detail.state == 'hovered' && document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {
              document.querySelector('#cursor').setAttribute('visible', true);
            }
        });

        /* hide cursor */
        this.el.addEventListener('stateremoved', function(evt) {

            /* only hide cursor in home position */
            if (evt.detail.state == 'hovered' && document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {
                document.querySelector('#cursor').setAttribute('visible', false);
            }
        });

        /* trigger animation */
        this.el.addEventListener('click', function(evt) {

            if (document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {

                document.querySelector('#cursor').setAttribute('visible', false);
                document.querySelector('#camera-wrapper').emit('in-' + evt.target.id);

            } else if (document.querySelector('#camera-wrapper').getAttribute('position').z === -20000) {

                document.querySelector('#cursor').setAttribute('visible', false);
                document.querySelector('#camera-wrapper').emit('out-' + evt.target.id);
            }
        });

        /* show cursor at end of out event */
        document.addEventListener('animationend', function() {

            if (document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {
                document.querySelector('#cursor').setAttribute('visible', true);
            }
        });
    },

    remove: function() {}

});


