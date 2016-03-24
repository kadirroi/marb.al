var Rocket = function(x, y, z, dir){

	this.x = x;
	this.y = y;
	this.z = z;

	this.counter = 0;

	this.dir = dir;

	this.causeExplosion = false;

	this.rayCaster = new THREE.Raycaster(new THREE.Vector3(x,y,z),dir,0,2000);
	var intersects = this.rayCaster.intersectObjects(scene.children);
	if (intersects.length>0){
		var curintersection = intersects[0];
		var curintersectionpoint = curintersection.point;
		this.expX = curintersectionpoint.x;
		this.expY = curintersectionpoint.y;
		this.expZ = curintersectionpoint.z;
		this.causeExplosion = true;	
	}


	this.initShape();
	this.shoot();

};

Rocket.prototype.initShape = function(){

	this.particles = new THREE.Geometry();
	this.particles2 = new THREE.Geometry();
	this.material = new THREE.ParticleBasicMaterial ({color: 0xff0000, size: 2.5, transparent:true, opacity:0.5});
	this.material.side = THREE.DoubleSide;
	this.material2 = new THREE.ParticleBasicMaterial ({size: 2.5, transparent:true, opacity:0.5, color:0x090909});
	this.material2.side = THREE.DoubleSide;
	for (var i=0;i<1000;i++){

		var cx = this.x + 2*Math.random();
		var cy = this.y + 10*Math.random();
		var cz = this.z + 2*Math.random();

    	var particle = new THREE.Vector3(cx, cy, cz);
		for (var i2=0;i2<50;i2++)
			particle.add(this.dir);
		particle.y -=10;
  		this.particles.vertices.push(particle);
	};

	this.particleSystem = new THREE.ParticleSystem(this.particles,this.material2);
	this.particleSystem.frustumCulled = false;
	scene.add(this.particleSystem);
	
	if (this.causeExplosion){
		for (var i=0;i<500;i++){

			var cx = this.expX + 5*Math.random();
			var cy = this.expY + 5*Math.random();
			var cz = this.expZ + 5*Math.random();

    		var particle = new THREE.Vector3(cx, cy, cz);
  			this.particles2.vertices.push(particle);
		}
		this.particleSystem2 = new THREE.ParticleSystem(this.particles2,this.material);
		this.particleSystem2.frustumCulled = false;
		scene.add(this.particleSystem2);		
	}


};

Rocket.prototype.shoot = function(){

	this.counter ++;

	if (this.causeExplosion)
		this.particleSystem2.material.color.setRGB(1,1,Math.random());

	for (var i=0; i<this.particles.vertices.length; i++){
		var curVertex = this.particles.vertices[i];
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

	this.particleSystem.geometry.verticesNeedUpdate = true;


	if (this.causeExplosion){
		for (var i=0; i<this.particles2.vertices.length; i++){
			var curVertex = this.particles2.vertices[i];
			var rand = Math.floor(Math.random()*2500);
			if (rand % 2 == 0)
				curVertex.x += 3*Math.random() ;
			else
				curVertex.x -= 3 * Math.random();
			var rand = Math.floor(Math.random()*2500);
			if (rand % 2 == 0)
				curVertex.z +=3 * Math.random() ;
			else
				curVertex.z -= 3 * Math.random() ;
			var rand = Math.floor(Math.random()*2500);
			if (rand % 2 == 0)
				curVertex.y += 5 * Math.random();
			else
				curVertex.y -= 10 * Math.random();
		}

		this.particleSystem2.geometry.verticesNeedUpdate = true;
	}

	var that = this;
	if (this.counter <= 150)
		window.setTimeout(function(){ that.shoot(); }, 10);
	else{
		scene.remove(this.particleSystem);
		if (this.causeExplosion)
			scene.remove(this.particleSystem2);
	}
};
