AFRAME.registerComponent('isvr-nav-cursor', {

    schema: {
        url: {
            default: ''
        }
    },

    init: function() {

        /* show cursor */
        this.el.addEventListener('stateadded', function(evt) {

            /* only show cursor in home position */
            if (evt.detail.state == 'hovered' && document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {
                document.querySelector('#cursor').setAttribute('visible', true);
                this.setAttribute('material', 'color', '#FFFFFF');
            }
        });

        /* hide cursor */
        this.el.addEventListener('stateremoved', function(evt) {

            /* only hide cursor in home position */
            if (evt.detail.state == 'hovered' && document.querySelector('#camera-wrapper').getAttribute('position').z === 10000) {
                document.querySelector('#cursor').setAttribute('visible', false);
                this.setAttribute('material', 'color', '#0080e5');
            }
        });

        /* trigger navigation */
        this.el.addEventListener('click', this.onClick.bind(this));

    },

    update: function() {},

    remove: function() {},

    onClick: function(evt) {

        if (document.querySelector('#camera-wrapper').getAttribute('position').z === 10000 && this.el.getAttribute('visible') === true) {

            this.xmlhttp = new XMLHttpRequest();
            this.xmlhttp.onreadystatechange = this.responseHandler.bind(this);
            this.xmlhttp.open('GET', this.data.url, true);
            this.xmlhttp.send();

        }

    },

    responseHandler: function() {

        var sphere_elems = document.getElementsByClassName('sphere');
        for (var i=0; i<sphere_elems.length; i++) {
            sphere_elems[i].setAttribute('visible', false);
        }

        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);
            for (var i=0; i<obj.data.length; i++) {

                var id = obj.from + i;

                document.querySelector('#sphere-' + (i+1)).setAttribute('material', 'src', '#loading-sphere');
                document.querySelector('#loading-anim-' + (i+1)).start();
                document.querySelector('#sphere-' + (i+1)).setAttribute('visible', true);

                /* create asset */
                if (document.querySelector('#img-photosphere-' + id) == null) {

                    var image = new Image();
                    image.onload = (function(id, i) {
                        return function() {
                            var image_elem = document.createElement('img');
                            image_elem.setAttribute('id', 'img-photosphere-' + id);
                            image_elem.setAttribute('src', this.src);
                            var assets = document.querySelector('a-assets');
                            assets.appendChild(image_elem);
                            document.querySelector('#loading-anim-' + (i+1)).stop();
                            var sphere = document.querySelector('#sphere-' + (i+1));
                            sphere.setAttribute('rotation', sphere.getAttribute('data-default-rotation'));
                            sphere.setAttribute('material', 'src', '#img-photosphere-' + id);
                        }
                    }(id, i));

                    image.src = obj.data[i]['image'];

                } else {

                    document.querySelector('#loading-anim-' + (i+1)).stop();
                    var sphere = document.querySelector('#sphere-' + (i+1));
                    sphere.setAttribute('rotation', sphere.getAttribute('data-default-rotation'));
                    sphere.setAttribute('material', 'src', '#img-photosphere-' + id);
                }

            } /* for */

            /* nav left */
            var nav_left_elem = document.querySelector('#nav-left-sphere');
            if (obj.prev_page_url != null) {
              nav_left_elem.setAttribute('visible', true);
              nav_left_elem.components['isvr-nav-cursor'].data.url = obj.prev_page_url;
            } else {
              nav_left_elem.setAttribute('visible', false);
            }

            /* nav right */
            var nav_right_elem = document.querySelector('#nav-right-sphere');
            if (obj.next_page_url != null) {
              nav_right_elem.setAttribute('visible', true);
              nav_right_elem.components['isvr-nav-cursor'].data.url = obj.next_page_url;
            } else {
              nav_right_elem.setAttribute('visible', false);
            }
        }

    }

});


