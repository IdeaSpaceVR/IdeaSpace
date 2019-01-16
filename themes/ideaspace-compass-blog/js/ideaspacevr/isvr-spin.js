AFRAME.registerComponent('isvr-spin', {

  
    init: function () {

				var self = this;
				this.rotate = false;
				//this.initialRotation = this.el.object3D.rotation;
				this.rot = {}; //this.laser.object3D.rotation;


				document.querySelectorAll('.laser-controls')[0].addEventListener('controllerconnected', function (e) {
						self.laser = document.querySelectorAll('.laser-controls')[0];
						self.laser.addEventListener('mousedown', function (e) {
								self.rotate = true;
								self.rot.y = (self.laser.object3D.rotation.y - self.el.object3D.rotation.y) + self.laser.object3D.rotation.y;
						});
						self.laser.addEventListener('mouseup', function (e) {
								self.rotate = false;
						});
				});


				document.querySelectorAll('.laser-controls')[1].addEventListener('controllerconnected', function (e) {
						self.laser = document.querySelectorAll('.laser-controls')[1];
						self.laser.addEventListener('mousedown', function (e) {
								self.rotate = true;
								self.rot.y = (self.laser.object3D.rotation.y - self.el.object3D.rotation.y) + self.laser.object3D.rotation.y;
						});
						self.laser.addEventListener('mouseup', function (e) {
								self.rotate = false;
						});
				});


//var axisY = new THREE.Vector3(0, 1, 0);
//var quatY = new THREE.Quaternion();
//var existingQuatY = new THREE.Quaternion();
		},


		tick: function () {

				if (this.rotate) {

//this.existingQuatY(this.axisY, THREE.Math.degToRad(this.el.object3D.rotation.y));
//this.quatY.setFromAxisAngle(this.axisY, THREE.Math.degToRad(this.laser.object3D.rotation.y));
//this.existingQuatY.multiply(this.quatY);
//this.el.object3D.mesh.quaternion.copy(this.existingQuatY);
//if (Math.sign(this.laser.object3D.rotation.y) == 1) {

						this.el.object3D.rotation.y = this.rot.y; // + this.laser.object3D.rotation.y;

						//this.el.object3D.rotation.y = this.initialRotation.y + this.laser.object3D.rotation.y;
						//this.initialRotation.y = this.el.object3D.rotation.y;
//} else {
//						this.el.object3D.rotation.y = this.laser.object3D.rotation.y - this.el.object3D.rotation.y;
						//this.el.object3D.rotation.y = this.initialRotation.y - this.laser.object3D.rotation.y;
						//this.initialRotation.y = this.el.object3D.rotation.y;
//}
				}
		}

});

