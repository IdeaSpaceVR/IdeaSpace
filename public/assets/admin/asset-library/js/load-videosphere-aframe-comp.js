AFRAME.registerComponent('load-videosphere', {

    schema: {
    },

    init: function() {

        var video = document.querySelector('#videosphere');
        video.addEventListener('canplaythrough', function(el) {
            document.querySelector('#image-loading').setAttribute('visible', false);
            document.querySelector('#image-loading').emit('stop');
            el.setAttribute('src', '#videosphere');
            document.querySelector('#default-sky').setAttribute('visible', false);
            el.setAttribute('visible', true);
        }(this.el));
        video.play();

    }
  

});


