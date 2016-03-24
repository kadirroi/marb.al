var Grenade = function(mesh, pos, dir){
	this.mesh = mesh;
	this.pos = pos;
	this.dir = dir;
	this.mesh.position.copy(pos);
	scene.add(this.mesh);
	this.initPhysics();
	this.tick = 0;
	this.smoke_tick = 0;
	this.setCountDown();	
};

Grenade.prototype.initPhysics = function(){

	this.mesh.phy_shape = new CANNON.Box(new CANNON.Vec3(7/2,11/2,7/2));
	this.mesh.phy_body = new CANNON.Body({mass : 130});
	this.mesh.phy_body.addShape(this.mesh.phy_shape);
	this.mesh.phy_body.position.x = this.pos.x;
	this.mesh.phy_body.position.y = this.pos.y+6;
	this.mesh.phy_body.position.z = this.pos.z+10;
	//for (var i=0; i<150; i++)
	//	this.mesh.phy_body.position.vadd(new CANNON.Vec3(this.dir.x,this.dir.y,this.dir.z));
	this.mesh.phy_body.velocity.x = 780 * this.dir.x;
	this.mesh.phy_body.velocity.y = 780 * this.dir.y;
	this.mesh.phy_body.velocity.z = 780 * this.dir.z;
	phy_world.add(this.mesh.phy_body);

};

Grenade.prototype.render = function(){

	this.mesh.position.copy(this.mesh.phy_body.position);	
		
};

Grenade.prototype.setCountDown = function(){

	this.tick++;
	var that = this;
	if (this.tick<=2)
		window.setTimeout(function(){ that.setCountDown(); }, 1000);
	else
		this.explode();
};

Grenade.prototype.explode = function(){
	
//	for (var i=0;i<phy_world.bodies.length;i++){
//		var curBody = phy_world.bodies[i];
//		var curPosition = curBody.position;
//		var expPosition = this.mesh.phy_body.position;
//		var dist = expPosition.distanceTo(curPosition);
//		if (dist <= 180 ){
//			curBody.applyImpulse(new CANNON.Vec3(210,210,210),expPosition);
//			if (typeof curBody.health !== 'undefined') {
//				var damage = Math.floor(180 - dist);
//				curBody.health -= damage;
//			}
//		}
//	};

	scene.remove(this.mesh);
	phy_world.removeBody(this.mesh.phy_body);
	grenades.splice(grenades.indexOf(this),1);

	this.smoke_particles = new THREE.Geometry();
	this.smoke_material = new THREE.ParticleBasicMaterial ({size: 10, transparent:true, opacity:0.5, color:0x090909});
	this.smoke_material.side = THREE.DoubleSide;

	this.explosion_particles = new THREE.Geometry();
	this.explosion_material = new THREE.ParticleBasicMaterial ({size: 2, transparent:true, opacity:0.5, color:0xb22222});
	this.explosion_material.side = THREE.DoubleSide;

	for (var i=0;i<1000;i++){

		var cx = this.mesh.position.x + 2*Math.random();
		var cy = this.mesh.position.y + 10*Math.random();
		var cz = this.mesh.position.z + 2*Math.random();

    	var particle = new THREE.Vector3(cx, cy, cz);
  		this.smoke_particles.vertices.push(particle);
	};

	for (var i=0; i<200;i++){

		var cx = this.mesh.position.x + 5*Math.random();
		var cy = this.mesh.position.y + 5*Math.random();
		var cz = this.mesh.position.z + 5*Math.random();
		var particle = new THREE.Vector3(this.mesh.position.x,this.mesh.position.y,this.mesh.position.z);
		this.explosion_particles.vertices.push(particle);	

	};

	this.smoke_particleSystem = new THREE.ParticleSystem(this.smoke_particles,this.smoke_material);
	this.smoke_particleSystem.frustumCulled = false;
	scene.add(this.smoke_particleSystem);
	this.explosion_particleSystem = new THREE.ParticleSystem(this.explosion_particles,this.explosion_material);
	this.explosion_particleSystem.frustumCulled = false;
	scene.add(this.explosion_particleSystem);
	
	this.doTheSmokeyThing();
};

Grenade.prototype.doTheSmokeyThing = function(){

	this.smoke_tick ++;
	var that = this;

	for (var i=0; i<this.smoke_particles.vertices.length; i++){
		var curVertex = this.smoke_particles.vertices[i];
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.x += 3 *Math.random() ;
		else
			curVertex.x -= 3 * Math.random();
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.z +=3  * Math.random() ;
		else
			curVertex.z -= 3 * Math.random() ;
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.y += 3 * Math.random();
		else
			curVertex.y += 3 * Math.random();
	}

	for (var i=0; i<this.explosion_particles.vertices.length; i++){
		var curVertex = this.explosion_particles.vertices[i];
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.x += 13*Math.random() ;
		else
			curVertex.x -= 13 * Math.random();
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.z +=13 * Math.random() ;
		else
			curVertex.z -= 13 * Math.random() ;
		var rand = Math.floor(Math.random()*2500);
		if (rand % 2 == 0)
			curVertex.y += 15 * Math.random();
		else
			curVertex.y -= 20 * Math.random();
	};

	this.smoke_particleSystem.geometry.verticesNeedUpdate = true;
	this.explosion_particleSystem.geometry.verticesNeedUpdate = true;

	if (this.smoke_tick<=150)
		window.setTimeout(function(){ that.doTheSmokeyThing(); }, 10);
	else{
		scene.remove(this.smoke_particleSystem);
		scene.remove(this.explosion_particleSystem);
	}
};
