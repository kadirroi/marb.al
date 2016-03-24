
var Player = function(x,y,z,id,name){

	this.lastProcessed = 0;
	this.name = name;
	this.x = x;
	this.y = y;
	this.z = z;
	this.id = id;

	this.kill = 0;
	this.death = 0;
	this.point = 0;

	this.initShape();
	this.initPhysics();
	this.addToScene();

};

Player.prototype.initShape = function(){

	this.geometry = new THREE.SphereGeometry(10, 8, 8);
	this.material = new THREE.MeshBasicMaterial({});
	this.object = new THREE.Mesh(this.geometry, this.material);
	this.object.position.set(this.x, this.y, this.z);	

};

Player.prototype.addToScene = function(){

	scene.add(this.object);

};

Player.prototype.initPhysics = function(){

	this.object.phy_shape = new CANNON.Sphere(10);
	this.object.phy_body = new CANNON.Body({ mass: 2 });
	this.object.phy_body.addShape(this.object.phy_shape);
	this.object.phy_body.linearDamping = 0.9;
	this.object.phy_body.health = 100;
	this.object.phy_body.position.set(this.x, this.y, this.z);
	this.object.phy_body.id = this.id;
	phy_world.addBody(this.object.phy_body);

};

Player.prototype.updatePosition = function(){

	this.object.position.copy(this.object.phy_body.position);
	this.object.quaternion.copy(this.object.phy_body.quaternion);

};
