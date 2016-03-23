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
              children[i].setAttribute('color', '#5b00f4');
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
          image_thumb_elems[i].setAttribute('opacity', 0);
        }

        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);
            for (var i=0; i<obj.data.length; i++) {

                var image_thumb_elem = document.getElementsByClassName('img-photosphere-thumb')[i];
                var id = obj.from + i; 
                image_thumb_elem.setAttribute('data-image-id', id);

                var image_thumb = new Image();
                image_thumb.onload = (function(elem) {
                  return function() {
                    elem.setAttribute('visible', true); 
                    elem.emit('fade');
                  }
                }(image_thumb_elem));
                image_thumb.src = obj.data[i]['image-thumbnail'];
                image_thumb_elem.setAttribute('src', image_thumb.src);

                if (document.querySelector('#img-photosphere-' + id) == null) {
                  var image = new Image();
                  image.src = obj.data[i]['image'];
                  var image_elem = document.createElement('img');
                  image_elem.setAttribute('id', 'img-photosphere-' + id);
                  image_elem.setAttribute('src', image.src);
                  var assets = document.querySelector('a-assets');
                  assets.appendChild(image_elem);
                }

            }

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

    update: function(oldData) {
    },

    remove: function() {
    }

});
