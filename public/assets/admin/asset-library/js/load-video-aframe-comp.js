AFRAME.registerComponent('load-video', {

    schema: {
    },

    init: function() {

        var video = document.querySelector('#video');
        video.addEventListener('canplaythrough', function(el) {
            document.querySelector('#image-loading').setAttribute('visible', false);
            document.querySelector('#image-loading-anim').stop();
            el.setAttribute('src', '#video');
            /* default camera distance to video: -4 */
            el.setAttribute('position', '0 2 -4');
            el.setAttribute('visible', true);
        }(this.el));
        video.play();

    }
  

});


