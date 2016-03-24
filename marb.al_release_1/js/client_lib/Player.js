
var Player = function(x,y,z,skin,player_name,id, kill, death){

	this.lastProcessed = 0;
	this.name = player_name;

	this.id = id;

	this.kill = kill;
	this.death = death;
	this.point = this.kill - this.death;

	this.x = x;
	this.y = y;
	this.z = z;

	this.skin = skin;

	var texture_loader = new THREE.TextureLoader();
	texture_loader.crossOrigin = '';	

	if (skin == 1)
		this.material = new THREE.MeshBasicMaterial({map: texture_loader.load('https://googledrive.com/host/0B2TF8tYSrr7aSVhIRExCZER2RUU')});
	if (skin == 2)
		this.material = new THREE.MeshBasicMaterial({map: texture_loader.load('https://googledrive.com/host/0B2TF8tYSrr7aUW1hcHlIS3AwcEE')});
	if (skin == 3)
		this.material = new THREE.MeshBasicMaterial({map: texture_loader.load('https://googledrive.com/host/0B2TF8tYSrr7aZ3IwN21FODFvLWM')});
	if (skin == 4)
		this.material = new THREE.MeshBasicMaterial({map: texture_loader.load('https://googledrive.com/host/0B2TF8tYSrr7adjdKdzhFUDF4MTA')});

	this.player_name = player_name;

	this.serverPositCounter = 0;
	this.lastServerPositRecieved = new CANNON.Vec3(this.x,this.y,this.z);

	this.initShape();
	this.initPhysics();
	this.addToScene();

};

Player.prototype.initShape = function(){

	this.geometry = new THREE.SphereGeometry(10, 8, 8);
	this.object = new THREE.Mesh(this.geometry, this.material);

	this.object.position.x = this.x;
	this.object.position.y = this.y;
	this.object.position.z = this.z;

	this.object.health = 100;
	
};

Player.prototype.addToScene = function(){

	scene.add(this.object);
};

Player.prototype.initPhysics = function(){

	this.object.phy_shape = new CANNON.Sphere(10);
	this.object.phy_body = new CANNON.Body({ mass: 2 });
	this.object.phy_body.addShape(this.object.phy_shape);
	this.object.phy_body.position.set(this.x,this.y,this.z);
	this.object.phy_body.linearDamping = 0.9;
	phy_world.addBody(this.object.phy_body);

};

Player.prototype.updatePosition = function(){

	this.object.position.copy(this.object.phy_body.position);
	this.object.quaternion.copy(this.object.phy_body.quaternion);

};

