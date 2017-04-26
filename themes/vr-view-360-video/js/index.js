/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
var vrView;

// All the scenes for the experience
var scenes = {};


function onLoad() {

  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = responseHandler; 
  xmlhttp.open('GET', space_url, true);
  xmlhttp.send();

  console.log('onLoad');
}


function responseHandler() {

  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

    obj = JSON.parse(xmlhttp.responseText);

    if (typeof obj['video-spheres'] !== 'undefined') {
      for (var i=0; i<obj['video-spheres'].length; i++) {

        var videosphere_hotspots = {};
        if (typeof obj['video-spheres'][i]['navigation-hotspots'] !== 'undefined') {
          for (var j=0; j<obj['video-spheres'][i]['navigation-hotspots']['#positions'].length; j++) {

            var hotspot = {
              pitch: 0,
              yaw: parseFloat(obj['video-spheres'][i]['navigation-hotspots']['#positions'][j]['#rotation']['#y']),
              radius: 0.05,
              distance: 1 
            };
            videosphere_hotspots[obj['video-spheres'][i]['navigation-hotspots']['#positions'][j]['#content-id']] = hotspot;
          }
        }

        var videosphere = {
          video: obj['video-spheres'][i]['video-sphere']['#uri']['#value'],
          hotspots: videosphere_hotspots 
        };
        scenes[obj['video-spheres'][i]['video-sphere']['#content-id']] = videosphere;
      } 
    } 

  
    if (typeof obj['video-spheres'] !== 'undefined' && obj['video-spheres'].length > 0) {

      var width = document.body.clientWidth;
      var height = document.body.clientHeight;

      vrView = new VRView.Player('#vrview', {
        video: obj['video-spheres'][0]['video-sphere']['#uri']['#value'],
        default_yaw: 0,
        is_debug: false,
        width: width,
        height: height,
        is_stereo: false,
        is_autopan_off: true
      });

      vrView.on('ready', onVRViewReady);
      vrView.on('modechange', onModeChange);
      vrView.on('click', onHotspotClick);
      vrView.on('error', onVRViewError);
    }
  }
}


function onVRViewReady(e) {

  console.log('onVRViewReady');
  loadScene(obj['video-spheres'][0]['video-sphere']['#content-id']);
}

function onModeChange(e) {
  console.log('onModeChange', e.mode);
}

function onHotspotClick(e) {
  console.log('onHotspotClick', e.id);
  if (e.id) {
    loadScene(e.id);
  }
}

function loadScene(id) {
  console.log('loadScene', id);

  vrView.setContent({
    video: scenes[id].video,
    is_stereo: false,
    is_autopan_off: true
  });

  // Add all the hotspots for the scene
  var newScene = scenes[id];
  var sceneHotspots = Object.keys(newScene.hotspots);

  for (var i = 0; i < sceneHotspots.length; i++) {

    var hotspotKey = sceneHotspots[i];
    var hotspot = newScene.hotspots[hotspotKey];

    vrView.addHotspot(hotspotKey, {
      pitch: hotspot.pitch,
      yaw: hotspot.yaw,
      radius: hotspot.radius,
      distance: hotspot.distance
    });
  }
}

function onVRViewError(e) {
  console.log('Error! %s', e.message);
}

window.addEventListener('load', onLoad);

