AFRAME.registerSystem('isvr-scene-helper', {

    showCursor: function () {

    },

    hideCursor: function () {

    },

});

AFRAME.registerComponent('isvr-scene', {
  
    init: function () {

        this.el.addEventListener('enter-vr', function() {

						if (AFRAME.utils.device.checkHeadsetConnected()) {
                document.querySelector('#camera-wrapper').setAttribute('position', {x: 0, y: 0, z: 0});
								/* more space to menu in VR mode (more comfortable) */
								if (document.querySelector('#menu-wrapper') !== null) {
                		document.querySelector('#menu-wrapper').setAttribute('position', {
												x: document.querySelector('#menu-wrapper').getAttribute('position').x, 
												y: document.querySelector('#menu-wrapper').getAttribute('position').y, z: (document.querySelector('#menu-wrapper').getAttribute('position').z - 0.7)
										});
								}
            }


						var sceneEl = document.querySelector('a-scene');

						var lcLeftEl = document.createElement('a-entity');
						lcLeftEl.setAttribute('laser-controls', {hand: 'left'});
						lcLeftEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcLeftEl.setAttribute('line', {color: '#FFFFFF'});
						lcLeftEl.setAttribute('class', 'laser-controls');
						sceneEl.appendChild(lcLeftEl);

						var lcRightEl = document.createElement('a-entity');
						lcRightEl.setAttribute('laser-controls', {hand: 'right'});
						lcRightEl.setAttribute('raycaster', {objects: '.collidable', near: 0.5});
						lcRightEl.setAttribute('line', {color: '#FFFFFF'});
						lcRightEl.setAttribute('class', 'laser-controls');
						sceneEl.appendChild(lcRightEl);

            document.querySelector('a-scene').addState('entered-vr');

        });

        this.el.addEventListener('exit-vr', function() {

            //location.reload();

        });


				/* workaround: it we don't wait, the first menu item mouseenter event is triggered and it causes wrong animation behaviour for that menu item */
				setTimeout(function() {

						/* trigger custom events */
						var soundClick = document.querySelector('#sound-click');
						var collidables = document.querySelectorAll('.collidable');
						for (var j = 0; j < collidables.length; j++) {

								collidables[j].addEventListener('mouseenter', function(e) {

										e.target.emit('isvr_mouseenter');

										/*for (var i = 0; i < e.target.parentNode.childNodes.length; i++) {
												if (e.target.parentNode.childNodes[i].className == "title") {
														e.target.parentNode.childNodes[i].emit('isvr_titlein');
														//e.target.parentNode.childNodes[i].setAttribute('visible', true);
														break;
												}        
										}*/

										if (e.target.classList.contains('wrapper')) {
												soundClick.components.sound.stopSound();
												soundClick.components.sound.playSound();
										}

								});

								collidables[j].addEventListener('mouseleave', function(e) {

										e.target.emit('isvr_mouseleave');

										/*for (var i = 0; i < e.target.parentNode.childNodes.length; i++) {
												if (e.target.parentNode.childNodes[i].className == "title") {
														//e.target.parentNode.childNodes[i].emit('isvr_titleout');
														//e.target.parentNode.childNodes[i].setAttribute('visible', true);
														break;
												}        
										}*/
								});

						}

						/* workaround: in case google fonts have not been loaded yet, update material html shader */
						var top_title = document.querySelector('#top-title');
						top_title.components.material.shader.__render();

						var titles = document.querySelectorAll('.title');
						for (var k = 0; k < titles.length; k++) {
								titles[k].components.material.shader.__render();
						}

				}, 2000);

    }

});

