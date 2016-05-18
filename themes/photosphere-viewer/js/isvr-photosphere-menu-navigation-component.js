AFRAME.registerComponent('isvr-photosphere-menu-navigation', {

    schema: {
      url: {
        default: ''
      }
    },

    init: function() {

        this.el.addEventListener('click', this.onClick.bind(this));

        /* hover */
        this.el.addEventListener('mouseenter', (function() {
          var children = this.el.childNodes;
          for (var i = 0; i < children.length; i++) {
            if (children[i].tagName == 'A-PLANE') {
              children[i].setAttribute('color', '#FFFFFF');
            }
          }
        }).bind(this));

        /* hover */
        this.el.addEventListener('mouseleave', (function() {
          var children = this.el.childNodes;
          for (var i = 0; i < children.length; i++) {
            if (children[i].tagName == 'A-PLANE') {
              children[i].setAttribute('color', '#0080e5');
            }
          }
        }).bind(this));

    },

    onClick: function(evt) {

        if (this.el.getAttribute('visible') === true) {

            this.xmlhttp = new XMLHttpRequest();
            this.xmlhttp.onreadystatechange = this.responseHandler.bind(this);
            this.xmlhttp.open('GET', this.data.url, true);
            this.xmlhttp.send();

        }

    },

    responseHandler: function() {

        var image_thumb_elems = document.getElementsByClassName('img-photosphere-thumb');
        for (var i=0; i<image_thumb_elems.length; i++) {
          image_thumb_elems[i].setAttribute('visible', false);
        }

        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);
            for (var i=0; i<obj.data.length; i++) {

                var id = obj.from + i; 

                var t = document.querySelector('#photosphere-thumb-' + (i+1));
  
                if (document.querySelector('#img-photosphere-thumb-' + id) == null) {

                    /* start anim */
                    var anim = document.querySelector('#photosphere-loading-anim-' + (i+1));
                    anim.start();
                    var animEl = document.querySelector('#photosphere-loading-' + (i+1));
                    animEl.setAttribute('visible', true);

                    var photosphere_thumb_image = new Image();
                    photosphere_thumb_image.onload = (function(id, i) {
                        return function() {
                            var image_elem = document.createElement('img');
                            image_elem.setAttribute('id', 'img-photosphere-thumb-' + id);
                            image_elem.setAttribute('src', this.src);
                            var assets = document.querySelector('a-assets');
                            assets.appendChild(image_elem);

                            var thumb = document.querySelector('#photosphere-thumb-' + (i+1));

                            /* load photo sphere images */
                            if (document.querySelector('#img-photosphere-' + id) == null) {

                                var image = new Image();
                                image.onload = (function(id, thumb) {
                                    return function() {
                                        var image_elem = document.createElement('img');
                                        image_elem.setAttribute('id', 'img-photosphere-' + id);
                                        image_elem.setAttribute('src', image.src);
                                        var assets = document.querySelector('a-assets');
                                        assets.appendChild(image_elem);

                                        /* stop anim */
                                        var animEl = document.querySelector('#photosphere-loading-' + (i+1));
                                        animEl.setAttribute('visible', false);
                                        var anim = document.querySelector('#photosphere-loading-anim-' + (i+1));
                                        anim.stop();

                                        /* show thumbnails if thumb and its photo sphere have been loaded */
                                        thumb.setAttribute('material', 'src', '#img-photosphere-thumb-' + id);
                                        thumb.setAttribute('data-image-id', id);
                                        thumb.setAttribute('visible', true);
                                    }
                                }(id, thumb));
                                image.src = obj.data[i]['image'];
                            } /* if */

                        }
                    }(id, i));
                    photosphere_thumb_image.src = obj.data[i]['image-thumbnail'];

                } else {

                    t.setAttribute('material', 'src', '#img-photosphere-thumb-' + id);
                    t.setAttribute('data-image-id', id); 
                    t.setAttribute('visible', true); 

                } /* if */

            } /* for */

            /* menu arrow up */
            var arrow_up_elem = document.querySelector('#menu-arrow-up');
            if (obj.prev_page_url != null) {
              arrow_up_elem.setAttribute('visible', true);
              arrow_up_elem.components['isvr-photosphere-menu-navigation'].data.url = obj.prev_page_url;
            } else {
              arrow_up_elem.setAttribute('visible', false);
            }

            /* menu arrow down */
            var arrow_down_elem = document.querySelector('#menu-arrow-down');
            if (obj.next_page_url != null) {
              arrow_down_elem.setAttribute('visible', true);
              arrow_down_elem.components['isvr-photosphere-menu-navigation'].data.url = obj.next_page_url;
            } else {
              arrow_down_elem.setAttribute('visible', false);
            }
        }
        
    },

    update: function(oldData) {},

    remove: function() {}

});
