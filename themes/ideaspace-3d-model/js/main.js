
var scene = document.querySelector('a-scene');
if (scene.hasLoaded) {
    run();
} else {
    var cam = document.querySelector('#camera');
    if (cam) {
        scene.addEventListener('loaded', run);
    }
}

function run() {

    // ORBIT CAMERA DRAG START / END EVENT LISTENERS
    document.querySelector('#camera').addEventListener('start-drag-orbit-controls', handleDragStart );
    document.querySelector('#camera').addEventListener('end-drag-orbit-controls', handleDragEnd );

		if (scene.is('vr-mode')) {
				scene.emit('enter-vr');				
		}	
}

function handleDragStart(event) {
    document.querySelector('canvas').classList.add('grabbable');
}

function handleDragEnd(event) {
    document.querySelector('canvas').classList.remove('grabbable');
}


var all_assets_ready = [];
var all_assets = document.querySelectorAll('.model-asset');

for (var i=0; i<all_assets.length; i++) {
    all_assets_ready[all_assets[i].id] = false;
}

for (var i=0; i<all_assets.length; i++) {

    all_assets[i].addEventListener('progress', function(xhr) {

        if (xhr.detail.loadedBytes == xhr.detail.totalBytes) {
            all_assets_ready[xhr.target.id] = true;
        }

    });
}

var interval = setInterval(function() {
    var done = false;
    for (var k in all_assets_ready) {
        if (all_assets_ready[k] == true) {
            done = true;
        } else {
            done = false;
        }
    }
    if (done) {
        clearInterval(interval); 
        document.getElementById('loader').style.display = 'none';
    }
}, 1000);


