AFRAME.registerComponent('isvr-init-assets', {

    schema: {
        url: {
            default: ''
        }
    },

    init: function() {

        this.xmlhttp = new XMLHttpRequest();
        this.xmlhttp.onreadystatechange = this.responseHandler.bind(this);
        this.xmlhttp.open('GET', this.data.url, true);
        this.xmlhttp.send();

    },

    responseHandler: function() {

        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);

            /* 1st photo sphere asset, to show immediately */
            var photosphere_image = new Image();
            photosphere_image.onload = (function() {
                return function() {
                    var image_elem = document.createElement('img');
                    image_elem.setAttribute('id', 'img-photosphere-1');
                    image_elem.setAttribute('src', this.src);
                    var assets = document.querySelector('a-assets');
                    assets.appendChild(image_elem);

                    document.querySelector('#photosphere-loading').setAttribute('visible', false);
                    document.querySelector('#photosphere-loading-anim').stop();

                    var sphere = document.querySelector('#photosphere');
                    sphere.setAttribute('material', 'src', '#img-photosphere-1');
                    sphere.setAttribute('material', 'color', '#FFFFFF');
                }
            }());
            photosphere_image.src = obj.data[0]['image'];


            /* photo sphere thumbnail assets */
            for (var i=0; i<obj.data.length; i++) {

                var id = obj.from + i;

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

                            var photosphere_image = new Image();
                            photosphere_image.onload = (function(id, thumb) {
                                return function() {
                                    var image_elem = document.createElement('img');
                                    image_elem.setAttribute('id', 'img-photosphere-' + id);
                                    image_elem.setAttribute('src', this.src);
                                    var assets = document.querySelector('a-assets');
                                    assets.appendChild(image_elem);

                                    /* stop anim */
                                    document.querySelector('#photosphere-loading-' + (i+1)).setAttribute('visible', false);
                                    document.querySelector('#photosphere-loading-anim-' + (i+1)).stop();
                        
                                    thumb.setAttribute('material', 'src', '#img-photosphere-thumb-' + id);
                                    thumb.setAttribute('visible', true);
                                }
                            }(id, thumb));
                            photosphere_image.src = obj.data[i]['image'];

                        } else {

                          /* stop anim */
                          document.querySelector('#photosphere-loading-' + (i+1)).setAttribute('visible', false);
                          document.querySelector('#photosphere-loading-anim-' + (i+1)).stop();

                          thumb.setAttribute('material', 'src', '#img-photosphere-thumb-' + id);
                          thumb.setAttribute('visible', true);
                        } /* if */
                    }
                }(id, i));
                photosphere_thumb_image.src = obj.data[i]['image-thumbnail'];

            } /* for */ 


        } /* if */

    }

});


