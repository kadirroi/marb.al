var weapon = 0;

var aqua_ammo = 100;
var shotgun_ammo = 20;
var grenade_ammo = 10;

var can_fire_icebeam = true;
var can_fire_shotgun = true;
var can_throw_grenade = true;
function shoot(){
	
	if (weapon == 0){
		if (aqua_ammo > 0 && can_fire_icebeam){
			can_fire_icebeam = false;
			var pos = camera.position;
			var dir = camera.getWorldDirection();
			var params = '{';
				params += '"id":"'+id+'",';
				params += '"camx":'+pos.x.toString()+',';
				params += '"camy":'+pos.y.toString()+',';
				params += '"camz":'+pos.z.toString()+',';
				params += '"dirx":'+dir.x.toString()+',';
				params += '"diry":'+dir.y.toString()+',';
				params += '"dirz":'+dir.z.toString();
			params += '}';
			socket.emit("ice_beam", params);
			aqua_ammo --;
			beams.push(new IceBeam(pos,dir));
			weapondiv.style.color = '#d4f0ff';
			weapondiv.style.left = (window.innerWidth/2)-35;
			weapondiv.innerHTML = 'Ice Beam ['+aqua_ammo.toString()+']';
			setTimeout(icebeam_wait, 500);
			// CLIENT-SIDE ICE BEAM SHOOTING EFFECT PREDICTION	
		//	var objary = [];
		//	for (var i=0;i<players.length; i++) objary.push(players[i].object);		
		//	var from = new THREE.Vector3(pos.x,pos.y,pos.z);
		//	var to = new THREE.Vector3(dir.x,dir.y,dir.z);
		//	var raycaster = new THREE.Raycaster(from, to);
		//	var intersects = raycaster.intersectObjects(objary);
		//	if (intersects.length > 0){
		//		var p = intersects[0].object.phy_body.position;
		//		intersects[0].object.phy_body.applyImpulse(new CANNON.Vec3(300,300,300),p);
				// HEALTH PREDICTION
				//intersects[0].object.health -= 10;
		//	}
		}	
	}
	if (weapon == 1){
		// shotgun
		if ((shotgun_ammo > 0) && can_fire_shotgun){
			var params = '{';
				params += '"id":"'+id+'",';
				params += '"yaw":'+yawRad.toString()+',';
				params += '"camx":'+camera.position.x.toString()+',';
				params += '"camy":'+camera.position.y.toString()+',';
				params += '"camz":'+camera.position.z.toString()+',';
				params += '"dirx":'+camera.getWorldDirection().x.toString()+',';
				params += '"diry":'+camera.getWorldDirection().y.toString()+',';
				params += '"dirz":'+camera.getWorldDirection().z.toString();	
			params +='}';
			socket.emit("shotgun", params);
			shotgun_ammo --;
			new Rocket(camera.position.x,camera.position.y,camera.position.z,camera.getWorldDirection());
			player.object.phy_body.applyForce(new CANNON.Vec3(10000*Math.cos(yawRad),0,10000*Math.sin(yawRad)),new CANNON.Vec3		(player.object.position.x,player.object.position.y+1,player.object.position.z));
			player.object.phy_body.velocity.y = 100;
			can_fire_shotgun = false;
			setTimeout(shotgun_wait, 1000);
			weapondiv.style.color = '#fffe00';
			weapondiv.style.left = (window.innerWidth/2)-60;
			weapondiv.innerHTML = 'Electric Shotgun ['+shotgun_ammo.toString()+']';
		}
	}
	if (weapon ==2){
		// grenade
		var camVec = camera.getWorldDirection();
		var params = '{';
			params += '"id":"'+id+'",';
			params += '"px":'+player.object.position.x.toString()+',';
			params += '"py":'+(player.object.position.y+10).toString()+',';
			params += '"pz":'+player.object.position.z.toString()+',';
			params += '"dirx":'+camVec.x+',';
			params += '"diry":'+camVec.y+',';
			params += '"dirz":'+camVec.z;
		params += '}';
		socket.emit("grenade", params);
		if (grenade_ammo > 0 && can_throw_grenade && typeof grenadeObject !== 'undefined'){
			grenade_ammo--;
			var clone_grenade = grenadeObject.clone();
			grenades.push(new Grenade(clone_grenade, new THREE.Vector3(player.object.position.x,player.object.position.y+10
,player.object.position.z), camera.getWorldDirection()));
			can_throw_grenade = false;
			setTimeout(grenade_wait, 1500);	
			weapondiv.style.color = '#e4183a';
			weapondiv.style.left = (window.innerWidth/2)-25;
			weapondiv.innerHTML = 'Grenade ['+grenade_ammo.toString()+']';
		}
	}

};

function changeWeapon(e){

	if(e.deltaY < 0) {
		weapon ++;
		weapon%=3;	

	}
    else{
 		weapon --;
		if (weapon<0) weapon = 2;	      
    }

	if (weapon == 0){
		weapondiv.style.color = '#d4f0ff';
		weapondiv.style.left = (window.innerWidth/2)-35;
		weapondiv.innerHTML = 'Ice Beam ['+aqua_ammo.toString()+']';
	}
	if (weapon == 1){
		weapondiv.style.color = '#fffe00';
		weapondiv.style.left = (window.innerWidth/2)-60;
		weapondiv.innerHTML = 'Electric Shotgun ['+shotgun_ammo.toString()+']';
	}
	if (weapon == 2){
		weapondiv.style.color = '#e4183a';
		weapondiv.style.left = (window.innerWidth/2)-25;
		weapondiv.innerHTML = 'Grenade ['+grenade_ammo.toString()+']';
	}
};

function icebeam_wait(){
	can_fire_icebeam = true;
};

function grenade_wait(){
	can_throw_grenade = true;
};

function shotgun_wait (){
	can_fire_shotgun = true;
};
