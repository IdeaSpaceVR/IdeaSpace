/*
* ~ SCHEMA ~
*  color       <String>: color of the stars
*  radius      <Number>: distance from center of sphere to first star sphere
*  depth       <Number>: distance between star spheres
*  starSize    <Number>: size of each individual star
*  starCount   <Number>: number of stars per star sphere
*  sphereCount <Number>: number of star spheres
*  texture     <Asset>:  sprite used for individual stars
*/

AFRAME.registerComponent('star-system', {
  schema: {
    color: {
      type: 'string',
      default: "#FFF"
    },
    radius: {
      type: 'number',
      default: 300,
      min: 0,
    },
    depth: {
      type: 'number',
      default: 300,
      min: 0,
    },
    starSize: {
      type: 'number',
      default: 1,
      min: 0,
    },
    count: {
      type: 'number',
      default: 10000,
      min: 0,
    },
    texture: {
      type: 'asset',
      default: ''
    }
  },

  update: function() {
    // Check for and load star sprite
    let texture = {};
    if (this.data.texture) {
      texture.transparent = true;
      texture.map = new THREE.TextureLoader().load(this.data.texture);
    }

    const stars = new THREE.Geometry();

    // Randomly create the vertices for the stars
    while (stars.vertices.length < this.data.count) {
        stars.vertices.push(this.randomVectorBetweenSpheres(this.data.radius, this.data.depth));
    }

    // Set the star display options
    const starMaterial = new THREE.PointsMaterial(Object.assign(texture, {
      color: this.data.color,
      size: this.data.starSize
    }));

    // Add the star particles to the element
    this.el.setObject3D('particle-system', new THREE.Points(stars, starMaterial));
  },

  // Returns a random vector between the inner sphere
  // and the outer sphere created with radius + depth
  randomVectorBetweenSpheres: function(radius, depth) {
    const randomRadius = Math.floor(Math.random() * (radius + depth - radius + 1) + radius);
    return this.randomSphereSurfaceVector(randomRadius);
  },

  // Returns a vector on the face of sphere with given radius
  randomSphereSurfaceVector: function(radius) {
    const theta = 2 * Math.PI * Math.random();
    const phi = Math.acos(2 * Math.random() - 1);
    const x = radius * Math.sin(phi) * Math.cos(theta);
    const y = radius * Math.sin(phi) * Math.sin(theta);
    const z = radius * Math.cos(phi);
    return new THREE.Vector3(x, y, z);
  }
});
