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
            for (var i=0; i<obj.data.length; i++) {

                var id = obj.from + i;

                /* create asset */
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

            } /* for */

        } /* if */

    }

});


