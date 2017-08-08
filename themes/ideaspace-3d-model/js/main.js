
var scene = document.querySelector('a-scene');
if (scene.hasLoaded) {
    run();
} else {
    scene.addEventListener('loaded', run);
}

function run() {

    // ORBIT CAMERA DRAG START / END EVENT LISTENERS
    document.querySelector('#camera').addEventListener('start-drag-orbit-controls', handleDragStart );
    document.querySelector('#camera').addEventListener('end-drag-orbit-controls', handleDragEnd );
}

function handleDragStart(event) {
    document.querySelector('canvas').classList.add('grabbable');
}

function handleDragEnd(event) {
    document.querySelector('canvas').classList.remove('grabbable');
}



var loading_indicator = document.querySelector('#loading-indicator');
var all_assets = document.querySelectorAll('.model-asset');
var loaded_bytes = 0;

for (var i=0; i<all_assets.length; i++) {

    all_assets[i].addEventListener('progress', function(xhr) {

        loaded_bytes = loaded_bytes + xhr.detail.loadedBytes;
        loading_indicator.setAttribute('width', (((loaded_bytes * 100) / xhr.detail.totalBytes) * 4.8) / 100);
//console.log(xhr.detail);
//console.log((((loaded_bytes * 100) / xhr.detail.totalBytes) * 4.8) / 100);
    });
}




