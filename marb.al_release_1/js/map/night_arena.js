var night_arena = function(){

	this.spot_light_roof_center = new THREE.SpotLight(0xff0000);
	this.spot_light_roof_center.position.set( 0, 300, 0 );

	scene.add(this.spot_light_roof_center);

	
	this.spot_light_roof_left = new THREE.SpotLight(0x00ffff);
	this.spot_light_roof_left.position.set( -500, 30, -300 );
	var targ = new THREE.Object3D();
	targ.position.set(-500,400,-800);
	scene.add(targ);
	this.spot_light_roof_left.target = targ;
	scene.add(this.spot_light_roof_left);

	
	this.spot_light_roof_right = new THREE.SpotLight(0x00ffff);
	this.spot_light_roof_right.position.set( 500, 30, -300 );
	var targ = new THREE.Object3D();
	targ.position.set(500,400,-800);
	scene.add(targ);
	this.spot_light_roof_right.target = targ;
	scene.add(this.spot_light_roof_right);

	
	this.spot_light_2 = new THREE.SpotLight(0xffffff);
	this.spot_light_2.position.set( 0, 0, -500 );
	this.target_obj = new THREE.Object3D();
	this.target_obj.position.set(0,100,-1000);
	scene.add(this.target_obj);
	this.spot_light_2.target = this.target_obj;

	scene.add(this.spot_light_2);

	/*
	this.spot_light_3 = new THREE.SpotLight(0xff0000);
	this.spot_light_3.position.set( 0, 0, -500 );
	this.target_obj2 = new THREE.Object3D();
	this.target_obj2.position.set(0,200,-500);
	scene.add(this.target_obj2);
	this.spot_light_3.target = this.target_obj2;

	scene.add(this.spot_light_3);
	*/

	/*
	this.spot_light_4 = new THREE.SpotLight(0xffffff);
	this.spot_light_4.position.set( 0, 50, -600 );
	this.target_obj3 = new THREE.Object3D();
	this.target_obj3.position.set(0,5,-610);
	scene.add(this.target_obj3);
	this.spot_light_4.target = this.target_obj3;

	scene.add(this.spot_light_4);
	*/

	/*	
	this.spot_light_6 = new THREE.SpotLight(0xff0000);
	this.spot_light_6.position.set( 0, 400, -1200 );
	this.target_obj5 = new THREE.Object3D();
	this.target_obj5.position.set(0,0,-1200);
	scene.add(this.target_obj5);
	this.spot_light_6.target = this.target_obj5;

	scene.add(this.spot_light_6);
	*/
	
	this.initSnow();

};

night_arena.prototype.initSnow = function(){

	this.particleCount = 4500,
	this.particles = new THREE.Geometry();
	this.pMaterial = new THREE.ParticleBasicMaterial({ color: 0xdddddd, size: 2.5 });

	for (var i = 0; i < this.particleCount; i++) {
		var px = Math.random() * 2000 - 1000;
    	var py = Math.random() * 500 + 100;
    	var pz = Math.random() * 2000 - 1000;
    	var particle = new THREE.Vector3(px, py, pz);
  		this.particles.vertices.push(particle);
	}

	this.particleSystem = new THREE.ParticleSystem(this.particles,this.pMaterial);
	scene.add(this.particleSystem);

};

night_arena.prototype.snow = function(){
	for (var i=0; i<this.particles.vertices.length; i++){
		this.particles.vertices[i].y -= 3;
		if (this.particles.vertices[i].z > -700){
			if (this.particles.vertices[i].y < 0)
				this.particles.vertices[i].y = Math.random() * 500 + 100;
		}
		else
			if (this.particles.vertices[i].y <250)
				this.particles.vertices[i].y = Math.random() * 500 + 100;
	};
	this.particleSystem.geometry.verticesNeedUpdate = true;
};

night_arena.prototype.initScene = function(scene,phy_world){

	this.ground_geometry = new THREE.BoxGeometry(3000,1,3000);
	this.ground_material = new THREE.MeshPhongMaterial({color: 0xdddddd});
	this.ground_object = new THREE.Mesh( this.ground_geometry, this.ground_material );
	scene.add(this.ground_object);
	this.ground_object.phy_shape = new CANNON.Plane();
	this.ground_object.phy_body = new CANNON.Body({mass: 0});
	this.ground_object.phy_body.addShape(this.ground_object.phy_shape);
	this.ground_object.phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(1,0,0),-Math.PI/2);
	phy_world.addBody(this.ground_object.phy_body);

	this.center_geometry = new THREE.BoxGeometry(50,160,50);
	this.center_object_1 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.center_object_1.position.set(-100,80,100);
	scene.add(this.center_object_1);
	this.center_object_1.phy_shape = new CANNON.Box(new CANNON.Vec3(25,80,25));
	this.center_object_1.phy_body = new CANNON.Body({mass : 0});
	this.center_object_1.phy_body.addShape(this.center_object_1.phy_shape);
	this.center_object_1.phy_body.position.set(-100,80,100);
	phy_world.addBody(this.center_object_1.phy_body);

	this.center_object_2 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.center_object_2.position.set(-100,80,-100);
	scene.add(this.center_object_2);
	this.center_object_2.phy_body = new CANNON.Body({mass : 0});
	this.center_object_2.phy_body.addShape(this.center_object_1.phy_shape);
	this.center_object_2.phy_body.position.set(-100,80,-100);
	phy_world.addBody(this.center_object_2.phy_body);

	this.center_object_3 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.center_object_3.position.set(100,80,-100);
	scene.add(this.center_object_3);
	this.center_object_3.phy_body = new CANNON.Body({mass : 0});
	this.center_object_3.phy_body.addShape(this.center_object_1.phy_shape);
	this.center_object_3.phy_body.position.set(100,80,-100);
	phy_world.addBody(this.center_object_3.phy_body);

	this.center_object_4 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.center_object_4.position.set(100,80,100);
	scene.add(this.center_object_4);
	this.center_object_4.phy_body = new CANNON.Body({mass : 0});
	this.center_object_4.phy_body.addShape(this.center_object_1.phy_shape);
	this.center_object_4.phy_body.position.set(100,80,100);
	phy_world.addBody(this.center_object_4.phy_body);

	this.center_roof_geometry = new THREE.SphereGeometry(180,32,32,Math.PI/2,Math.PI,0,Math.PI);
	this.center_roof_object = new THREE.Mesh(this.center_roof_geometry, this.ground_material);
	this.center_roof_object.position.set(0,120,0);
	this.center_roof_object.rotation.set(0,0,Math.PI/2);
	this.center_roof_object.material.side = THREE.DoubleSide;
	scene.add(this.center_roof_object);

	this.cross_geometry1 = new THREE.BoxGeometry(10,150,10);
	this.cross_material = new THREE.MeshBasicMaterial({color: 0xff0000, fog: false});
	this.cross_object1 = new THREE.Mesh(this.cross_geometry1, this.cross_material);
	this.cross_object1.position.set(0,180+195,0);
	scene.add(this.cross_object1);

	this.cross_geometry2 = new THREE.BoxGeometry(75,10,10);
	this.cross_object2 = new THREE.Mesh(this.cross_geometry2, this.cross_material);
	this.cross_object2.position.set(0,180+195-15,0);
	scene.add(this.cross_object2);

	this.left_object_1 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.left_object_1.position.set(-800,80,100);
	scene.add(this.left_object_1);
	this.left_object_1.phy_body = new CANNON.Body({mass : 0});
	this.left_object_1.phy_body.addShape(this.center_object_1.phy_shape);
	this.left_object_1.phy_body.position.set(-800,80,100);
	phy_world.addBody(this.left_object_1.phy_body);

	this.left_object_2 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.left_object_2.position.set(-800,80,-100);
	scene.add(this.left_object_2);
	this.left_object_2.phy_body = new CANNON.Body({mass : 0});
	this.left_object_2.phy_body.addShape(this.center_object_1.phy_shape);
	this.left_object_2.phy_body.position.set(-800,80,-100);
	phy_world.addBody(this.left_object_2.phy_body);

	this.left_object_3 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.left_object_3.position.set(-600,80,-100);
	scene.add(this.left_object_3);
	this.left_object_3.phy_body = new CANNON.Body({mass : 0});
	this.left_object_3.phy_body.addShape(this.center_object_1.phy_shape);
	this.left_object_3.phy_body.position.set(-600,80,-100);
	phy_world.addBody(this.left_object_3.phy_body);

	this.left_object_4 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.left_object_4.position.set(-600,80,100);
	scene.add(this.left_object_4);
	this.left_object_4.phy_body = new CANNON.Body({mass : 0});
	this.left_object_4.phy_body.addShape(this.center_object_1.phy_shape);
	this.left_object_4.phy_body.position.set(-600,80,100);
	phy_world.addBody(this.left_object_4.phy_body);

	this.left_roof_object = new THREE.Mesh(this.center_roof_geometry, this.ground_material);
	this.left_roof_object.position.set(-700,120,0);
	this.left_roof_object.rotation.set(0,0,Math.PI/2);
	scene.add(this.left_roof_object);

	/*
	this.cross_material_left = new THREE.MeshBasicMaterial({color: 0xff0000, fog: false});
	this.cross_object_left_1 = new THREE.Mesh(this.cross_geometry1, this.cross_material_left);
	this.cross_object_left_1.position.set(-700,180+195,0);
	scene.add(this.cross_object_left_1);

	this.cross_object_left_2 = new THREE.Mesh(this.cross_geometry2, this.cross_material_left);
	this.cross_object_left_2.position.set(-700,180+195-15,0);
	scene.add(this.cross_object_left_2);
	*/

	this.right_object_1 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.right_object_1.position.set(600,80,100);
	scene.add(this.right_object_1);
	this.right_object_1.phy_body = new CANNON.Body({mass : 0});
	this.right_object_1.phy_body.addShape(this.center_object_1.phy_shape);
	this.right_object_1.phy_body.position.set(600,80,100);
	phy_world.addBody(this.right_object_1.phy_body);

	this.right_object_2 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.right_object_2.position.set(600,80,-100);
	scene.add(this.right_object_2);
	this.right_object_2.phy_body = new CANNON.Body({mass : 0});
	this.right_object_2.phy_body.addShape(this.center_object_1.phy_shape);
	this.right_object_2.phy_body.position.set(600,80,-100);
	phy_world.addBody(this.right_object_2.phy_body);

	this.right_object_3 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.right_object_3.position.set(800,80,-100);
	scene.add(this.right_object_3);
	this.right_object_3.phy_body = new CANNON.Body({mass : 0});
	this.right_object_3.phy_body.addShape(this.center_object_1.phy_shape);
	this.right_object_3.phy_body.position.set(800,80,-100);
	phy_world.addBody(this.right_object_3.phy_body);

	this.right_object_4 = new THREE.Mesh(this.center_geometry, this.ground_material );
	this.right_object_4.position.set(800,80,100);
	scene.add(this.right_object_4);
	this.right_object_4.phy_body = new CANNON.Body({mass : 0});
	this.right_object_4.phy_body.addShape(this.center_object_1.phy_shape);
	this.right_object_4.phy_body.position.set(800,80,100);
	phy_world.addBody(this.right_object_4.phy_body);

	this.right_roof_object = new THREE.Mesh(this.center_roof_geometry, this.ground_material);
	this.right_roof_object.position.set(700,120,0);
	this.right_roof_object.rotation.set(0,0,Math.PI/2);
	scene.add(this.right_roof_object);

	var loader = new THREE.JSONLoader();
	loader.load( './js/map/grave.json', function ( geometry ) {
		for (var i=0;i<1000;i+=200){
			for (var i2=300;i2<900;i2+=200){
				var graveMesh = new THREE.Mesh( geometry, new THREE.MeshPhongMaterial({color : 0xdddddd}) );
				graveMesh.position.set(i,-20,i2);
				graveMesh.scale.set(20,20,20);
				graveMesh.rotateY(Math.PI/2);
				scene.add(graveMesh);
				graveMesh.phy_shape = new CANNON.Box(new CANNON.Vec3(24,40,7.5));
				graveMesh.phy_body = new CANNON.Body({mass : 0});
				graveMesh.phy_body.addShape(graveMesh.phy_shape);
				graveMesh.phy_body.position.set(i,40,i2+72);
				phy_world.addBody(graveMesh.phy_body);
				var graveMesh2 = new THREE.Mesh( geometry, new THREE.MeshPhongMaterial({color : 0xdddddd}) );
				graveMesh2.position.set(-1*i,-20,i2);
				graveMesh2.scale.set(20,20,20);
				graveMesh2.rotateY(Math.PI/2);
				scene.add(graveMesh2);
				graveMesh2.phy_body = new CANNON.Body({mass : 0});
				graveMesh2.phy_body.addShape(graveMesh.phy_shape);
				graveMesh2.phy_body.position.set(-1*i,40,i2+72);
				phy_world.addBody(graveMesh2.phy_body);
			}
		}
	});
	
	var loader2 = new THREE.JSONLoader();
	loader2.load('./js/map/tree.json', function ( geometry ) {
		var rot = 0;
		for (var i=0; i<50; i++){
			var rand_x = Math.floor(Math.random() * (980  + 1)) ;
			var rand_z = Math.floor(Math.random() * (980  + 1)) ;
			var rand_c = Math.floor(Math.random() * (10)) + 1;
			var rand_rot = Math.floor(Math.random() * (100)) +1;
			var rand_push = Math.floor(Math.random() * (20)) ;
			if (rand_c % 2 == 0)
				rand_x = -1 * rand_x;
			var treeMesh = new THREE.Mesh(geometry, new THREE.MeshPhongMaterial({color : 0x6f4242}));
			treeMesh.rotation.y = rot;
			treeMesh.position.set(rand_x,0,rand_z);
			treeMesh.scale.set(20,10+rand_push,20);
			treeMesh.isTree = true;
			scene.add(treeMesh);
			rot += 500 * rand_rot;
			if (rand_z%3==0){
				var testMesh = new THREE.Mesh(new THREE.BoxGeometry(20,100,20), new THREE.MeshPhongMaterial({color:0xffffff,transparent:true,opacity:0.8}));
				testMesh.position.set(rand_x,50,rand_z);
				testMesh.rotation.y = rot;
				scene.add(testMesh);
			}
			treeMesh.phy_shape = new CANNON.Box(new CANNON.Vec3(15,100,15));
			treeMesh.phy_body = new CANNON.Body({mass : 0});
			treeMesh.phy_body.addShape(treeMesh.phy_shape);
			treeMesh.phy_body.position.set(rand_x,50,rand_z);
			phy_world.addBody(treeMesh.phy_body);
		}
		for (var i=0; i<20; i++){
			var rand_x = Math.floor(Math.random() * (980  + 1)) ;
			var rand_z = -1 * Math.floor(Math.random() * (500  + 1)) ;
			var rand_c = Math.floor(Math.random() * (10)) + 1;
			var rand_rot = Math.floor(Math.random() * (100)) +1;
			var rand_push = Math.floor(Math.random() * (20)) ;
			if (rand_c % 2 == 0)
				rand_x = -1 * rand_x;
			var treeMesh = new THREE.Mesh(geometry, new THREE.MeshPhongMaterial({color : 0x6f4242}));
			treeMesh.rotation.y = rot;
			treeMesh.position.set(rand_x,0,rand_z);
			treeMesh.scale.set(20,10+rand_push,20);
			treeMesh.isTree = true;
			scene.add(treeMesh);
			rot += 500 * rand_rot;
			if (rand_x%3==0){
				var testMesh = new THREE.Mesh(new THREE.BoxGeometry(20,100,20), new THREE.MeshPhongMaterial({color:0xffffff,transparent:true,opacity:0.8}));
				testMesh.position.set(rand_x,50,rand_z);
				testMesh.rotation.y = rot;
				scene.add(testMesh);
			}
			treeMesh.phy_shape = new CANNON.Box(new CANNON.Vec3(15,100,15));
			treeMesh.phy_body = new CANNON.Body({mass : 0});
			treeMesh.phy_body.addShape(treeMesh.phy_shape);
			treeMesh.phy_body.position.set(rand_x,50,rand_z);
			phy_world.addBody(treeMesh.phy_body);
		};
	});

	/*	
	var loader3 = new THREE.JSONLoader();
	loader3.load('./js/map/cathedral.json', function (geometry){
		var cathedralMesh = new THREE.Mesh(geometry, new THREE.MeshPhongMaterial({color : 0xdddddd}));
		cathedralMesh.scale.set(20,20,20);
		cathedralMesh.rotateY(Math.PI/2);
		cathedralMesh.position.set(0,300,-1000);
		scene.add(cathedralMesh);
	});
	*/

	var loader4 = new THREE.JSONLoader();
	loader4.load('./js/map/casuta.json', function(geometry){
		var casutaMesh_left = new THREE.Mesh(geometry, new THREE.MeshPhongMaterial({color : 0xdddddd}));
		casutaMesh_left.scale.set(5,5,5);
		casutaMesh_left.position.set(-700,-295,-900);
		scene.add(casutaMesh_left);

		var wall_1_1_phy_shape = new CANNON.Box(new CANNON.Vec3(13,50,5));
		var wall_1_1_phy_body = new CANNON.Body({mass : 0});
		wall_1_1_phy_body.addShape(wall_1_1_phy_shape);
		wall_1_1_phy_body.position.set(-662,50,-701);
		phy_world.addBody(wall_1_1_phy_body);

		var wall_1_2_phy_shape = new CANNON.Box(new CANNON.Vec3(13,50,5));
		var wall_1_2_phy_body = new CANNON.Body({mass : 0});
		wall_1_2_phy_body.addShape(wall_1_2_phy_shape);
		wall_1_2_phy_body.position.set(-662+309,50,-701);
		phy_world.addBody(wall_1_2_phy_body);

		var wall_1_3_phy_shape = new CANNON.Box(new CANNON.Vec3(12,50,5));
		var wall_1_3_phy_body = new CANNON.Body({mass : 0});
		wall_1_3_phy_body.addShape(wall_1_3_phy_shape);
		wall_1_3_phy_body.position.set(-662+104,50,-701);
		phy_world.addBody(wall_1_3_phy_body);

		var wall_1_4_phy_shape = new CANNON.Box(new CANNON.Vec3(11,50,5));
		var wall_1_4_phy_body = new CANNON.Body({mass : 0});
		wall_1_4_phy_body.addShape(wall_1_4_phy_shape);
		wall_1_4_phy_body.position.set(-662+104+102,50,-701);
		phy_world.addBody(wall_1_4_phy_body);

		var wall_1_5_phy_shape = new CANNON.Box(new CANNON.Vec3(5,50,100));
		var wall_1_5_phy_body = new CANNON.Body({mass : 0});
		wall_1_5_phy_body.addShape(wall_1_5_phy_shape);
		wall_1_5_phy_body.position.set(-671,50,-800);
		phy_world.addBody(wall_1_5_phy_body);

		var wall_1_6_phy_shape = new CANNON.Box(new CANNON.Vec3(5,50,100));
		var wall_1_6_phy_body = new CANNON.Body({mass : 0});
		wall_1_6_phy_body.addShape(wall_1_6_phy_shape);
		wall_1_6_phy_body.position.set(-671+309+17,50,-800);
		phy_world.add(wall_1_6_phy_body);

		var wall_1_7_phy_shape = new CANNON.Box(new CANNON.Vec3(336/2,200/2,(13/2)-2));
		var wall_1_7_phy_body = new CANNON.Body({mass : 0});
		wall_1_7_phy_body.addShape(wall_1_7_phy_shape);
		wall_1_7_phy_body.position.set(-508,100,-899);
		phy_world.add(wall_1_7_phy_body);		
		
		var wall_1_8_phy_shape = new CANNON.Box(new CANNON.Vec3(10/2,7/2,310/2));
		var wall_1_8_phy_body = new CANNON.Body({mass : 0});
		wall_1_8_phy_body.addShape(wall_1_8_phy_shape);
		wall_1_8_phy_body.position.set(-696,20,-747);
		phy_world.addBody(wall_1_8_phy_body);

		var wall_1_9_phy_shape = new CANNON.Box(new CANNON.Vec3(10/2,7/2,310/2));
		var wall_1_9_phy_body = new CANNON.Body({mass : 0});
		wall_1_9_phy_body.addShape(wall_1_9_phy_shape);
		wall_1_9_phy_body.position.set(-696+376,20,-747);
		phy_world.addBody(wall_1_9_phy_body);

		var wall_x_phy_shape = new CANNON.Box(new CANNON.Vec3(7.5/2,17/2,7.5/2));
		var wall_x_1_phy_body = new CANNON.Body({mass : 0});
		var wall_x_2_phy_body = new CANNON.Body({mass : 0});
		var wall_x_3_phy_body = new CANNON.Body({mass : 0});
		var wall_x_4_phy_body = new CANNON.Body({mass : 0});	
		var wall_x_5_phy_body = new CANNON.Body({mass : 0});
		var wall_x_6_phy_body = new CANNON.Body({mass : 0});
		var wall_x_7_phy_body = new CANNON.Body({mass : 0});
		var wall_x_8_phy_body = new CANNON.Body({mass : 0});
		var wall_x_9_phy_body = new CANNON.Body({mass : 0});
		var wall_x_10_phy_body = new CANNON.Body({mass : 0});	
		var wall_x_11_phy_body = new CANNON.Body({mass : 0});
		var wall_x_12_phy_body = new CANNON.Body({mass : 0});
		var wall_x_13_phy_body = new CANNON.Body({mass : 0});
		var wall_x_14_phy_body = new CANNON.Body({mass : 0});

		wall_x_1_phy_body.addShape(wall_x_phy_shape);
		wall_x_2_phy_body.addShape(wall_x_phy_shape);
		wall_x_3_phy_body.addShape(wall_x_phy_shape);
		wall_x_4_phy_body.addShape(wall_x_phy_shape);	
		wall_x_5_phy_body.addShape(wall_x_phy_shape);
		wall_x_6_phy_body.addShape(wall_x_phy_shape);
		wall_x_7_phy_body.addShape(wall_x_phy_shape);
		wall_x_8_phy_body.addShape(wall_x_phy_shape);
		wall_x_9_phy_body.addShape(wall_x_phy_shape);
		wall_x_10_phy_body.addShape(wall_x_phy_shape);	
		wall_x_11_phy_body.addShape(wall_x_phy_shape);
		wall_x_12_phy_body.addShape(wall_x_phy_shape);
		wall_x_13_phy_body.addShape(wall_x_phy_shape);
		wall_x_14_phy_body.addShape(wall_x_phy_shape);

		var reff = 377;

		wall_x_1_phy_body.position.set(-696,10,-597);
		wall_x_2_phy_body.position.set(-696,10,-597-49);
		wall_x_3_phy_body.position.set(-696,10,-597-49-54);
		wall_x_4_phy_body.position.set(-696,10,-597-49-54-49);
		wall_x_5_phy_body.position.set(-696,10,-597-49-54-49-49);
		wall_x_6_phy_body.position.set(-696,10,-597-49-54-49-49-52);
		wall_x_7_phy_body.position.set(-696,10,-597-49-54-49-49-52-47);
		wall_x_8_phy_body.position.set(-696+reff,10,-597);
		wall_x_9_phy_body.position.set(-696+reff,10,-597-49);
		wall_x_10_phy_body.position.set(-696+reff,10,-597-49-54);
		wall_x_11_phy_body.position.set(-696+reff,10,-597-49-54-49);
		wall_x_12_phy_body.position.set(-696+reff,10,-597-49-54-49-49);
		wall_x_13_phy_body.position.set(-696+reff,10,-597-49-54-49-49-52);
		wall_x_14_phy_body.position.set(-696+reff,10,-597-49-54-49-49-52-47);

		phy_world.addBody(wall_x_1_phy_body);
		phy_world.addBody(wall_x_2_phy_body);
		phy_world.addBody(wall_x_3_phy_body);
		phy_world.addBody(wall_x_4_phy_body);
		phy_world.addBody(wall_x_5_phy_body);
		phy_world.addBody(wall_x_6_phy_body);
		phy_world.addBody(wall_x_7_phy_body);
		phy_world.addBody(wall_x_8_phy_body);
		phy_world.addBody(wall_x_9_phy_body);
		phy_world.addBody(wall_x_10_phy_body);
		phy_world.addBody(wall_x_11_phy_body);
		phy_world.addBody(wall_x_12_phy_body);
		phy_world.addBody(wall_x_13_phy_body);
		phy_world.addBody(wall_x_14_phy_body);
	
		var casutaMesh_right = new THREE.Mesh(geometry, new THREE.MeshPhongMaterial({color : 0xdddddd}));
		casutaMesh_right.scale.set(5,5,5);
		casutaMesh_right.position.set(300,-295,-900);
		scene.add(casutaMesh_right);

		var ref = 1000;

		var wall_2_1_phy_shape = new CANNON.Box(new CANNON.Vec3(13,50,5));
		var wall_2_1_phy_body = new CANNON.Body({mass : 0});
		wall_2_1_phy_body.addShape(wall_2_1_phy_shape);
		wall_2_1_phy_body.position.set(-662+ref,50,-701);
		phy_world.addBody(wall_2_1_phy_body);

		var wall_2_2_phy_shape = new CANNON.Box(new CANNON.Vec3(13,50,5));
		var wall_2_2_phy_body = new CANNON.Body({mass : 0});
		wall_2_2_phy_body.addShape(wall_2_2_phy_shape);
		wall_2_2_phy_body.position.set(-662+309+ref,50,-701);
		phy_world.addBody(wall_2_2_phy_body);

		var wall_2_3_phy_shape = new CANNON.Box(new CANNON.Vec3(12,50,5));
		var wall_2_3_phy_body = new CANNON.Body({mass : 0});
		wall_2_3_phy_body.addShape(wall_2_3_phy_shape);
		wall_2_3_phy_body.position.set(-662+104+ref,50,-701);
		phy_world.addBody(wall_2_3_phy_body);

		var wall_2_4_phy_shape = new CANNON.Box(new CANNON.Vec3(11,50,5));
		var wall_2_4_phy_body = new CANNON.Body({mass : 0});
		wall_2_4_phy_body.addShape(wall_2_4_phy_shape);
		wall_2_4_phy_body.position.set(-662+104+102+ref,50,-701);
		phy_world.addBody(wall_2_4_phy_body);

		var wall_2_5_phy_shape = new CANNON.Box(new CANNON.Vec3(5,50,100));
		var wall_2_5_phy_body = new CANNON.Body({mass : 0});
		wall_2_5_phy_body.addShape(wall_2_5_phy_shape);
		wall_2_5_phy_body.position.set(-671+ref,50,-800);
		phy_world.addBody(wall_2_5_phy_body);

		var wall_2_6_phy_shape = new CANNON.Box(new CANNON.Vec3(5,50,100));
		var wall_2_6_phy_body = new CANNON.Body({mass : 0});
		wall_2_6_phy_body.addShape(wall_2_6_phy_shape);
		wall_2_6_phy_body.position.set(-671+309+17+ref,50,-800);
		phy_world.add(wall_2_6_phy_body);

		var wall_2_7_phy_shape = new CANNON.Box(new CANNON.Vec3(336/2,200/2,(13/2)-2));
		var wall_2_7_phy_body = new CANNON.Body({mass : 0});
		wall_2_7_phy_body.addShape(wall_2_7_phy_shape);
		wall_2_7_phy_body.position.set(-508+ref,100,-899);
		phy_world.add(wall_2_7_phy_body);		

		var wall_2_8_phy_shape = new CANNON.Box(new CANNON.Vec3(10/2,7/2,310/2));
		var wall_2_8_phy_body = new CANNON.Body({mass : 0});
		wall_2_8_phy_body.addShape(wall_2_8_phy_shape);
		wall_2_8_phy_body.position.set(-696+ref,20,-747);
		phy_world.addBody(wall_2_8_phy_body);

		var wall_2_9_phy_shape = new CANNON.Box(new CANNON.Vec3(10/2,7/2,310/2));
		var wall_2_9_phy_body = new CANNON.Body({mass : 0});
		wall_2_9_phy_body.addShape(wall_2_9_phy_shape);
		wall_2_9_phy_body.position.set(-696+376+ref,20,-747);
		phy_world.addBody(wall_2_9_phy_body);

		var wall_xx_1_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_2_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_3_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_4_phy_body = new CANNON.Body({mass : 0});	
		var wall_xx_5_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_6_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_7_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_8_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_9_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_10_phy_body = new CANNON.Body({mass : 0});	
		var wall_xx_11_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_12_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_13_phy_body = new CANNON.Body({mass : 0});
		var wall_xx_14_phy_body = new CANNON.Body({mass : 0});

		wall_xx_1_phy_body.addShape(wall_x_phy_shape);
		wall_xx_2_phy_body.addShape(wall_x_phy_shape);
		wall_xx_3_phy_body.addShape(wall_x_phy_shape);
		wall_xx_4_phy_body.addShape(wall_x_phy_shape);	
		wall_xx_5_phy_body.addShape(wall_x_phy_shape);
		wall_xx_6_phy_body.addShape(wall_x_phy_shape);
		wall_xx_7_phy_body.addShape(wall_x_phy_shape);
		wall_xx_8_phy_body.addShape(wall_x_phy_shape);
		wall_xx_9_phy_body.addShape(wall_x_phy_shape);
		wall_xx_10_phy_body.addShape(wall_x_phy_shape);	
		wall_xx_11_phy_body.addShape(wall_x_phy_shape);
		wall_xx_12_phy_body.addShape(wall_x_phy_shape);
		wall_xx_13_phy_body.addShape(wall_x_phy_shape);
		wall_xx_14_phy_body.addShape(wall_x_phy_shape);

		var reff = 377;

		wall_xx_1_phy_body.position.set(-696+ref,10,-597);
		wall_xx_2_phy_body.position.set(-696+ref,10,-597-49);
		wall_xx_3_phy_body.position.set(-696+ref,10,-597-49-54);
		wall_xx_4_phy_body.position.set(-696+ref,10,-597-49-54-49);
		wall_xx_5_phy_body.position.set(-696+ref,10,-597-49-54-49-49);
		wall_xx_6_phy_body.position.set(-696+ref,10,-597-49-54-49-49-52);
		wall_xx_7_phy_body.position.set(-696+ref,10,-597-49-54-49-49-52-47);
		wall_xx_8_phy_body.position.set(-696+ref+reff,10,-597);
		wall_xx_9_phy_body.position.set(-696+ref+reff,10,-597-49);
		wall_xx_10_phy_body.position.set(-696+ref+reff,10,-597-49-54);
		wall_xx_11_phy_body.position.set(-696+ref+reff,10,-597-49-54-49);
		wall_xx_12_phy_body.position.set(-696+ref+reff,10,-597-49-54-49-49);
		wall_xx_13_phy_body.position.set(-696+ref+reff,10,-597-49-54-49-49-52);
		wall_xx_14_phy_body.position.set(-696+ref+reff,10,-597-49-54-49-49-52-47);

		phy_world.addBody(wall_xx_1_phy_body);
		phy_world.addBody(wall_xx_2_phy_body);
		phy_world.addBody(wall_xx_3_phy_body);
		phy_world.addBody(wall_xx_4_phy_body);
		phy_world.addBody(wall_xx_5_phy_body);
		phy_world.addBody(wall_xx_6_phy_body);
		phy_world.addBody(wall_xx_7_phy_body);
		phy_world.addBody(wall_xx_8_phy_body);
		phy_world.addBody(wall_xx_9_phy_body);
		phy_world.addBody(wall_xx_10_phy_body);
		phy_world.addBody(wall_xx_11_phy_body);
		phy_world.addBody(wall_xx_12_phy_body);
		phy_world.addBody(wall_xx_13_phy_body);
		phy_world.addBody(wall_xx_14_phy_body);

	});

	var side_wall_geo = new THREE.PlaneGeometry(200,200,32);
	var side_wall_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/building_text1.jpg',THREE.SphericalRefractionMapping)});
	for (var i=900; i>=-900; i=i-200){
		var side_wall_object = new THREE.Mesh(side_wall_geo, side_wall_material);
		side_wall_object.position.set(-1000,50,i);
		side_wall_object.rotateY(Math.PI/2);
		side_wall_object.material.side = THREE.DoubleSide;
		scene.add(side_wall_object);
		var side_wall_object = new THREE.Mesh(side_wall_geo, side_wall_material);
		side_wall_object.position.set(-1000,250,i);
		side_wall_object.rotateY(Math.PI/2);
		side_wall_object.material.side = THREE.DoubleSide;
		scene.add(side_wall_object);
		var side_wall_object = new THREE.Mesh(side_wall_geo, side_wall_material);
		side_wall_object.position.set(1000,50,i);
		side_wall_object.rotateY(Math.PI/2);
		side_wall_object.material.side = THREE.DoubleSide;
		scene.add(side_wall_object);
		var side_wall_object = new THREE.Mesh(side_wall_geo, side_wall_material);
		side_wall_object.position.set(1000,250,i);
		side_wall_object.rotateY(Math.PI/2);
		side_wall_object.material.side = THREE.DoubleSide;
		scene.add(side_wall_object);
	};

	this.wall1_geometry = new THREE.PlaneGeometry(200,100,32);
	this.wall1_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf1.jpg',THREE.SphericalRefractionMapping)});
	this.wall1_object = new THREE.Mesh(this.wall1_geometry, this.wall1_material);
	this.wall1_object.position.set(900,50,1000);
	this.wall1_object.material.side = THREE.DoubleSide;
	scene.add(this.wall1_object);
	this.wall1_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall1_material);
	this.wall1_object_2.position.set(900,50,-1000);
	this.wall1_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall1_object_2);

	this.wall2_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf2.jpg',THREE.SphericalRefractionMapping)});
	this.wall2_object = new THREE.Mesh(this.wall1_geometry, this.wall2_material);
	this.wall2_object.position.set(700,50,1000);
	this.wall2_object.material.side = THREE.DoubleSide;
	scene.add(this.wall2_object);
	this.wall2_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall2_material);
	this.wall2_object_2.position.set(700,50,-1000);
	this.wall2_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall2_object_2);

	this.wall3_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf3.jpg',THREE.SphericalRefractionMapping)});
	this.wall3_object = new THREE.Mesh(this.wall1_geometry, this.wall3_material);
	this.wall3_object.position.set(500,50,1000);
	this.wall3_object.material.side = THREE.DoubleSide;
	scene.add(this.wall3_object);
	this.wall3_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall3_material);
	this.wall3_object_2.position.set(500,50,-1000);
	this.wall3_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall3_object_2);

	this.wall4_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf4.jpg',THREE.SphericalRefractionMapping)});
	this.wall4_object = new THREE.Mesh(this.wall1_geometry, this.wall4_material);
	this.wall4_object.position.set(300,50,1000);
	this.wall4_object.material.side = THREE.DoubleSide;
	scene.add(this.wall4_object);
	this.wall4_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall4_material);
	this.wall4_object_2.position.set(300,50,-1000);
	this.wall4_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall4_object_2);

	this.wall5_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf5.jpg',THREE.SphericalRefractionMapping)});
	this.wall5_object = new THREE.Mesh(this.wall1_geometry, this.wall5_material);
	this.wall5_object.position.set(100,50,1000);
	this.wall5_object.material.side = THREE.DoubleSide;
	scene.add(this.wall5_object);

	this.wall6_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf6.jpg',THREE.SphericalRefractionMapping)});
	this.wall6_object = new THREE.Mesh(this.wall1_geometry, this.wall6_material);
	this.wall6_object.position.set(-100,50,1000);
	this.wall6_object.material.side = THREE.DoubleSide;
	scene.add(this.wall6_object);

	this.wall7_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf7.jpg',THREE.SphericalRefractionMapping)});
	this.wall7_object = new THREE.Mesh(this.wall1_geometry, this.wall7_material);
	this.wall7_object.position.set(-300,50,1000);
	this.wall7_object.material.side = THREE.DoubleSide;
	scene.add(this.wall7_object);
	this.wall7_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall7_material);
	this.wall7_object_2.position.set(-300,50,-1000);
	this.wall7_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall7_object_2);

	this.wall8_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf8.jpg',THREE.SphericalRefractionMapping)});
	this.wall8_object = new THREE.Mesh(this.wall1_geometry, this.wall8_material);
	this.wall8_object.position.set(-500,50,1000);
	this.wall8_object.material.side = THREE.DoubleSide;
	scene.add(this.wall8_object);
	this.wall8_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall8_material);
	this.wall8_object_2.position.set(-500,50,-1000);
	this.wall8_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall8_object_2);

	this.wall9_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/graf9.jpg',THREE.SphericalRefractionMapping)});
	this.wall9_object = new THREE.Mesh(this.wall1_geometry, this.wall9_material);
	this.wall9_object.position.set(-700,50,1000);
	this.wall9_object.material.side = THREE.DoubleSide;
	scene.add(this.wall9_object);
	this.wall9_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall9_material);
	this.wall9_object_2.position.set(-700,50,-1000);
	this.wall9_object_2.material.side = THREE.DoubleSide;
	scene.add(this.wall9_object_2);

	this.wall10_object = new THREE.Mesh(this.wall1_geometry, this.wall3_material);
	this.wall10_object.position.set(-900,50,1000);
	scene.add(this.wall10_object);
	this.wall10_object_2 = new THREE.Mesh(this.wall1_geometry, this.wall3_material);
	this.wall10_object_2.position.set(-900,50,-1000);
	scene.add(this.wall10_object_2);

	var credits_object = new THREE.Mesh(new THREE.PlaneGeometry(200,200,32), new THREE.MeshPhongMaterial({color:0xdddddd,map:THREE.ImageUtils.loadTexture('./js/map/credit.png',THREE.SphericalRefractionMapping)}));
	credits_object.material.side = THREE.DoubleSide;
	credits_object.position.set(-500,50,-904);
	credits_object.rotateY(Math.PI);
	scene.add(credits_object);


	var loader = new THREE.OBJMTLLoader();
	loader.load('./js/map/WoodenCabinObj.obj','./js/map/WoodenCabinObj.mtl',
		function ( object ) {
			object.scale.set(8,5,8);
			object.position.set(0,-26.5,-1000);
			scene.add(object);
						
			var wall_1_phy_shape = new CANNON.Box(new CANNON.Vec3(210/2,100/2,10/2));
			var wall_1_phy_body = new CANNON.Body({mass : 0});
			wall_1_phy_body.addShape(wall_1_phy_shape);
			wall_1_phy_body.position.set(90,50,-733);
			phy_world.addBody(wall_1_phy_body);

			var wall_2_phy_shape = new CANNON.Box(new CANNON.Vec3(95/2,200/2,10/2));
			var wall_2_phy_body = new CANNON.Body({mass : 0});
			wall_2_phy_body.addShape(wall_2_phy_shape);
			wall_2_phy_body.position.set(-147,50,-733);
			phy_world.addBody(wall_2_phy_body);

			var wall_3_phy_shape = new CANNON.Box(new CANNON.Vec3(17/2,200/2,17/2));
			var wall_3_phy_body = new CANNON.Body({mass : 0});
			wall_3_phy_body.addShape(wall_3_phy_shape);
			wall_3_phy_body.position.set(0,100,-1000);
			phy_world.addBody(wall_3_phy_body);

			var wall_4_phy_shape = new CANNON.Box(new CANNON.Vec3(500/2,400/2,100/2));
			var wall_4_phy_body = new CANNON.Body({mass : 0});
			wall_4_phy_body.addShape(wall_4_phy_shape);
			wall_4_phy_body.position.set(0,200,-1310);
			phy_world.addBody(wall_4_phy_body);			

			var wall_5_phy_shape = new CANNON.Box(new CANNON.Vec3(20/2,200/2,600/2));
			var wall_6_phy_body = new CANNON.Body({mass : 0});
			var wall_7_phy_body = new CANNON.Body({mass : 0});
			wall_6_phy_body.addShape(wall_5_phy_shape);
			wall_7_phy_body.addShape(wall_5_phy_shape);
			wall_6_phy_body.position.set(-185,100,-975-50);
			wall_7_phy_body.position.set(-185+372,100,-975-50);			
			phy_world.addBody(wall_6_phy_body);
			phy_world.addBody(wall_7_phy_body);				

		}, function(xhr){},function(xhr){});

		var loader = new THREE.OBJMTLLoader();
		loader.load('./js/map/klupa117.obj','./js/map/klupa117.mtl',
		function(object){
			var seat1 = object.clone();
			seat1.rotateY(Math.PI/2);
			seat1.scale.set(1,1,3);
			seat1.position.set(-510,0,-850);
			scene.add(seat1);
			var seat2 = object.clone();
			seat2.rotateY(Math.PI/2);
			seat2.scale.set(1,1,3);
			seat2.position.set(-510+1000,0,-850);
			scene.add(seat2);

			var phy_shp_1 = new CANNON.Box(new CANNON.Vec3(136/2,10/2,14/2));
			var phy_body_1 = new CANNON.Body({mass : 0});
			var phy_body_2 = new CANNON.Body({mass : 0});
			phy_body_1.addShape(phy_shp_1);
			phy_body_2.addShape(phy_shp_1);
			phy_body_1.position.set(-510,8,-848);
			phy_body_2.position.set(-510+1000,8,-848);
			phy_world.addBody(phy_body_1);
			phy_world.addBody(phy_body_2);

			var phy_shp_2 = new CANNON.Box(new CANNON.Vec3(136/2,20/2,3/2));
			var phy_body_3 = new CANNON.Body({mass : 0});
			var phy_body_4 = new CANNON.Body({mass : 0});
			phy_body_3.addShape(phy_shp_2);
			phy_body_4.addShape(phy_shp_2);
			phy_body_3.position.set(-510,20,-858);
			phy_body_4.position.set(-510+1000,20,-858);
			phy_world.addBody(phy_body_3);
			phy_world.addBody(phy_body_4);
	
		}, function(xhr){},function(xhr){});



		var crate_phy_shape = new CANNON.Box(new CANNON.Vec3(15,15,15));

		var crate_geo = new THREE.BoxGeometry(30,30,30);
		var crate_material = new THREE.MeshPhongMaterial({color:0xdddddd, map:THREE.ImageUtils.loadTexture('./js/map/crate.jpg',THREE.SphericalRefractionMapping)});
		var crate_mesh_1 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_1.position.set(100,15,-800);
		scene.add(crate_mesh_1);
		var crate_mesh_2 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_2.position.set(-100,15,-900);
		crate_mesh_2.rotateY(Math.PI/7);
		scene.add(crate_mesh_2);
		var crate_mesh_3 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_3.position.set(-150,15,-970);
		crate_mesh_3.rotateY(Math.PI/3);
		scene.add(crate_mesh_3);
		var crate_mesh_4 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_4.position.set(50,15,-970);
		crate_mesh_4.rotateY(Math.PI/6);
		scene.add(crate_mesh_4);
		var crate_mesh_5 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_5.position.set(80,15,-990);
		crate_mesh_5.rotateY(Math.PI/4);
		scene.add(crate_mesh_5);
		var crate_mesh_5_2 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_5_2.position.set(-150,45,-980);
		crate_mesh_5_2.rotateY(Math.PI/6);
		scene.add(crate_mesh_5_2);
		var crate_mesh_6 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_6.position.set(-130,15,-995);
		scene.add(crate_mesh_6);
		var crate_mesh_6_2 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_6_2.position.set(50,45,-980);
		crate_mesh_6_2.rotateY(Math.PI/9);
		scene.add(crate_mesh_6_2);
		var crate_mesh_7 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_7.position.set(10,15,-1100);
		crate_mesh_7.rotateY(Math.PI/6);
		scene.add(crate_mesh_7);
		var crate_mesh_8 = new THREE.Mesh(crate_geo,crate_material);
		crate_mesh_8.position.set(-50,15,-1200);
		crate_mesh_8.rotateY(Math.PI/7);
		scene.add(crate_mesh_8);

		var crate_1_phy_body = new CANNON.Body({mass : 0});
		var crate_2_phy_body = new CANNON.Body({mass : 0});
		var crate_3_phy_body = new CANNON.Body({mass : 0});
		var crate_4_phy_body = new CANNON.Body({mass : 0});
		var crate_5_phy_body = new CANNON.Body({mass : 0});
		var crate_5_2_phy_body = new CANNON.Body({mass : 0});
		var crate_6_phy_body = new CANNON.Body({mass : 0});
		var crate_6_2_phy_body = new CANNON.Body({mass : 0});
		var crate_7_phy_body = new CANNON.Body({mass : 0});
		var crate_8_phy_body = new CANNON.Body({mass : 0});

		crate_1_phy_body.addShape(crate_phy_shape); 
		crate_2_phy_body.addShape(crate_phy_shape); 
		crate_3_phy_body.addShape(crate_phy_shape);  
		crate_4_phy_body.addShape(crate_phy_shape);  
		crate_5_phy_body.addShape(crate_phy_shape); 
		crate_5_2_phy_body.addShape(crate_phy_shape); 
		crate_6_phy_body.addShape(crate_phy_shape); 
		crate_6_2_phy_body.addShape(crate_phy_shape); 
		crate_7_phy_body.addShape(crate_phy_shape); 
		crate_8_phy_body.addShape(crate_phy_shape); 

		crate_1_phy_body.position.set(100,15,-800);
		crate_2_phy_body.position.set(-100,15,-900);
		crate_3_phy_body.position.set(-150,15,-970);
		crate_4_phy_body.position.set(50,15,-970);
		crate_5_phy_body.position.set(80,15,-990);
		crate_5_2_phy_body.position.set(-150,45,-980);
		crate_6_phy_body.position.set(-130,15,-995);
		crate_6_2_phy_body.position.set(50,45,-980);
		crate_7_phy_body.position.set(10,15,-1100);
		crate_8_phy_body.position.set(-50,15,-1200);

		crate_2_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/7);
		crate_3_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/3);
		crate_4_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/6);
		crate_5_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/4);
		crate_5_2_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/6);
		crate_6_2_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/9);
		crate_7_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/6);
		crate_8_phy_body.quaternion.setFromAxisAngle(new CANNON.Vec3(0,1,0),Math.PI/7);

		phy_world.addBody(crate_1_phy_body);
		phy_world.addBody(crate_2_phy_body);
		phy_world.addBody(crate_3_phy_body);
		phy_world.addBody(crate_4_phy_body);
		phy_world.addBody(crate_5_phy_body);
		phy_world.addBody(crate_5_2_phy_body);
		phy_world.addBody(crate_6_phy_body);
		phy_world.addBody(crate_6_2_phy_body);
		phy_world.addBody(crate_7_phy_body);
		phy_world.addBody(crate_8_phy_body);

		var w1_phy_shape = new CANNON.Box(new CANNON.Vec3(1000/2,100/2,3/2));
		var w1_phy_body = new CANNON.Body({mass : 0});
		w1_phy_body.addShape(w1_phy_shape);
		w1_phy_body.position.set(-700,50,-1000);
		phy_world.addBody(w1_phy_body);

		var w2_phy_shape = new CANNON.Box(new CANNON.Vec3(1000/2,100/2,3/2));
		var w2_phy_body = new CANNON.Body({mass : 0});
		w2_phy_body.addShape(w2_phy_shape);
		w2_phy_body.position.set(-700+1400,50,-1000);
		phy_world.addBody(w2_phy_body);

		var w3_phy_shape = new CANNON.Box(new CANNON.Vec3(2000/2,100/2,3/2));
		var w3_phy_body = new CANNON.Body({mass : 0});
		w3_phy_body.addShape(w3_phy_shape);
		w3_phy_body.position.set(0,50,1000);
		phy_world.addBody(w3_phy_body);		

		var w4_phy_shape = new CANNON.Box(new CANNON.Vec3(3/2,100/2,2000/2));
		var w4_phy_body = new CANNON.Body({mass : 0});
		w4_phy_body.addShape(w4_phy_shape);
		w4_phy_body.position.set(1000,50,0);
		phy_world.addBody(w4_phy_body);	

		var w5_phy_shape = new CANNON.Box(new CANNON.Vec3(3/2,100/2,2000/2));
		var w5_phy_body = new CANNON.Body({mass : 0});
		w5_phy_body.addShape(w5_phy_shape);
		w5_phy_body.position.set(-1000,50,0);
		phy_world.addBody(w5_phy_body);	


};

