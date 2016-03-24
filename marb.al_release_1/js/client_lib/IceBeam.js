var IceBeam = function(pos, dir){

	this.pos = pos;
	this.dir = dir;
	this.removed = false;
	this.initScene();


};

IceBeam.prototype.initScene = function(){

	this.particles = new THREE.Geometry();
	this.particles2 = new THREE.Geometry();	
	this.particles3 = new THREE.Geometry();
	this.particle_material = new THREE.ParticleBasicMaterial ({size: 2.5, transparent:true, opacity:0.7, color:0xd4f0ff});
	this.particle_material.side = THREE.DoubleSide;
	for (var i=0;i<500;i++){

		var cx = this.pos.x + 2*Math.random();
		var cy = this.pos.y + 2*Math.random();
		var cz = this.pos.z + 2*Math.random();

    	var particle = new THREE.Vector3(cx, cy, cz);
		for (var i2=0;i2<50;i2++)
			particle.add(this.dir);
  		this.particles.vertices.push(particle);
	}

	this.particleSystem = new THREE.ParticleSystem(this.particles,this.particle_material);
	this.particleSystem.frustumCulled = false;
	scene.add(this.particleSystem);

	for (var i=0;i<500;i++){

		var cx = this.pos.x + 2*Math.random();
		var cy = this.pos.y + 2*Math.random();
		var cz = this.pos.z + 2*Math.random();

    	var particle = new THREE.Vector3(cx, cy, cz);
		for (var i2=0;i2<50;i2++)
			particle.add(this.dir);
  		this.particles2.vertices.push(particle);
	}

	this.particleSystem2 = new THREE.ParticleSystem(this.particles2,this.particle_material);
	this.particleSystem2.frustumCulled = false;
	scene.add(this.particleSystem2);

	for (var i=0;i<500;i++){

		var cx = this.pos.x + 2*Math.random();
		var cy = this.pos.y + 2*Math.random();
		var cz = this.pos.z + 2*Math.random();

    	var particle = new THREE.Vector3(cx, cy, cz);
		for (var i2=0;i2<50;i2++)
			particle.add(this.dir);
  		this.particles3.vertices.push(particle);
	}

	this.particleSystem3 = new THREE.ParticleSystem(this.particles3,this.particle_material);
	this.particleSystem3.frustumCulled = false;
	scene.add(this.particleSystem3);

};

IceBeam.prototype.render = function(){

	for (var i=0; i<this.particles.vertices.length; i++){
		var curVertex = this.particles.vertices[i];
		var rand = Math.floor(10*Math.random());
		if (rand%2 ==0)
			curVertex.y += 2*Math.random();
		else
			curVertex.y -= 2*Math.random();	
		for (var i2=0;i2<15;i2++)
			curVertex.add(this.dir);
	}
	this.particleSystem.geometry.verticesNeedUpdate = true;

	for (var i=0; i<this.particles2.vertices.length; i++){
		var curVertex = this.particles2.vertices[i];
		var rand = Math.floor(10*Math.random());
		if (rand%2 ==0)
			curVertex.x += 2*Math.random();
		else
			curVertex.x -= 2*Math.random();	
		for (var i2=0;i2<15;i2++)
			curVertex.add(this.dir);
	}
	this.particleSystem2.geometry.verticesNeedUpdate = true;

	for (var i=0; i<this.particles3.vertices.length; i++){
		if (!this.removed){
			var curVertex = this.particles3.vertices[i];
			var rand = Math.floor(10*Math.random());
			if (rand%2 ==0)
				curVertex.z += 2*Math.random();
			else
				curVertex.z -= 2*Math.random();	
			for (var i2=0;i2<15;i2++)
				curVertex.add(this.dir);
			if (curVertex.x >1000 || curVertex.y>200 || curVertex.z>1000 || curVertex.z<-1000 || curVertex.x<-1000 || curVertex.y<0){
				scene.remove(this.particleSystem);
				scene.remove(this.particleSystem2);
				scene.remove(this.particleSystem3);
				beams.splice(beams.indexOf(this), 1);
				this.removed = true;
			}
		}
	}
	this.particleSystem3.geometry.verticesNeedUpdate = true;

};
