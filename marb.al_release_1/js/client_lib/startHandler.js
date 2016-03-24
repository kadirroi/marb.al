var player_name;
var player;
var players = [];
var labels = [];
var beams = [];
var grenades = [];
var treats = [];
var disconnectBodies = [];
var id;
var startTime;
var pingdiv;
var syncdiv;
var weapondiv;
var scorediv;
var scoretable;
var recentdiv;
var latency=1;

var grenadeObject;
var heartObject;
var ammoObject;

var loader = new THREE.JSONLoader();
loader.load('https://googledrive.com/host/0B2TF8tYSrr7aUi16NTI1Y0d6T3M', function(geometry){
	grenadeObject = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({color:0x4b5320,transparent:true,opacity:0.6}));
	grenadeObject.scale.set(5,5,5);
});

var loader2 = new THREE.JSONLoader();
loader2.load('https://googledrive.com/host/0B2TF8tYSrr7abHdtcEpaLUNCNFE', function(geometry){
	heartObject = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({color:0xff69b4, transparent:true, opacity:0.6}));
	heartObject.scale.set(0.03, 0.03, 0.03);
	// y = 15
});

var loader3 = new THREE.JSONLoader();
loader3.load('https://googledrive.com/host/0B2TF8tYSrr7acl9zU3UwUVFVR2s', function(geometry){
	ammoObject = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({color:0x4b5320, transparent:true, opacity:0.6}));
	ammoObject.scale.set(3,3,3);
	// y = 20
});

function start(){

	requestPointerLock();

	player_name = document.getElementById("player_name").value;
	if (player_name == "") player_name = "anonymous";

	document.getElementById("blocker").style.display = "none";
	document.getElementById("loadingScreen").style.visibility = "visible";
	document.getElementById("loadingDIV").style.top = (window.innerHeight/2)-250;
	document.getElementById("loadingDIV").style.left = (window.innerWidth/2)-150;
	document.getElementById("loadingINFO").innerHTML = "Connecting to the server";

	

	socket = io("http://46.196.18.28:80");	

	socket.on("connect", function(){
		socket.emit("hello",{});		
	});

	socket.on("welcome", function(msg){
		document.getElementById("loadingINFO").innerHTML = "<span style='color:#00ff00'>Connected to the server</span><br/>";
		document.getElementById("loadingINFO").innerHTML += "Creating the scene<br/>";
		var json = JSON.parse(msg);
		id = json.id;
		initScene(json);
		document.getElementById("loadingINFO").innerHTML = "<span style='color:#00ff00'>Connected to the server</span><br/>";
		document.getElementById("loadingINFO").innerHTML += "<span style='color:#00ff00'>Created the scene</span><br/>";
		document.getElementById("loadingINFO").innerHTML += "Starting the game<br/>";
		var param = '{"name":"'+player_name+'"}';
		socket.emit("who_am_i",param);
	});	

	socket.on("you_are", function(msg){
		var json = JSON.parse(msg);
		var positions = json.positions;
		for (var i=0; i<positions.length; i++){
			var create_id = positions[i].id;
			var create_name = positions[i].name;
			var create_lastProcessed = positions[i].last;
			var create_x = positions[i].x;
			var create_y = positions[i].y;
			var create_z = positions[i].z;
			var kill = positions[i].kill;
			var death = positions[i].death;
			var new_player = new Player(create_x,create_y,create_z,((i%4)+1),create_name,create_id,kill,death);
			new_player.lastProcessed = create_lastProcessed;
			players.push(new_player);
			if (create_id == id)		
				player = new_player;
			var label = new Label(new_player.object, new_player.name, new_player.id);
			labels.push(label);
		}
		document.getElementById("loadingScreen").style.display = 'none';
		document.getElementById("crosshair").style.left = (window.innerWidth/2)-12.5;
		document.getElementById("crosshair").style.top = (window.innerHeight/2)-12.5;
		renderer.setSize( window.innerWidth, window.innerHeight );
		document.body.appendChild( renderer.domElement );
		document.addEventListener("keydown", onKeyDown);
		document.addEventListener("keyup", onKeyUp);
		document.addEventListener("mousemove", moveCallback);
		document.addEventListener("click", shoot);
		document.addEventListener("wheel", changeWeapon);
		pingdiv = document.createElement("div");
		pingdiv.style.position = 'absolute';
		pingdiv.style.top = window.innerHeight-10;
		pingdiv.style.left = 0;
		pingdiv.style.fontFamily = 'DJB';
		pingdiv.style.fontSize = '10px';
		pingdiv.style.color = '#00ff00';
		pingdiv.style.backgroundColor = "rgba(0,0,0,0.4)";
		document.body.appendChild(pingdiv);
		syncdiv = document.createElement("div");
		syncdiv.style.position = 'absolute';
		syncdiv.style.top = window.innerHeight-15;
		syncdiv.style.left = window.innerWidth-50;
		syncdiv.style.fontFamily = 'DJB';
		syncdiv.style.fontSize = '10px';
		syncdiv.style.color = '#00ff00';
		syncdiv.style.backgroundColor = "rgba(0,0,0,0.4)";
		document.body.appendChild(syncdiv);
		weapondiv = document.createElement("div");
		weapondiv.style.position = 'absolute';
		weapondiv.style.top = window.innerHeight-20;
		weapondiv.style.left = (window.innerWidth/2)-35;
		weapondiv.style.fontFamily = 'DJB';
		weapondiv.style.fontSize = '15px';
		weapondiv.style.color = '#d4f0ff';
		weapondiv.style.backgroundColor = "rgba(0,0,0,0.4)";
		weapondiv.innerHTML = 'Ice Beam [50]';
		document.body.appendChild(weapondiv);
		recentdiv = document.createElement("div");
		recentdiv.style.position = 'absolute';
		recentdiv.style.top = 0;
		recentdiv.style.left = 0;
		recentdiv.style.fontFamily = 'Courier';
		recentdiv.style.fontSize = '12px';
		recentdiv.style.color = '#ffffff';
		recentdiv.style.backgroundColor = "rgba(0,0,0,0.4)";
		recentdiv.style.overflow = 'hidden';
		recentdiv.style.maxWidth = window.innerWidth / 3;
		recentdiv.style.maxHeight = '50px';
		document.body.appendChild(recentdiv);
		scorediv = document.createElement("div");
		scorediv.style.position = 'absolute';
		scorediv.style.top = 0;
		scorediv.style.right = 0;
		scorediv.style.fontFamily = 'Courier';
		scorediv.style.fontSize = '12px';
		scorediv.style.color = '#ffffff';
		scorediv.style.backgroundColor = "rgba(0,0,0,0.4)";
		scorediv.style.overflow = 'hidden';
		scoretable = document.createElement('table');
		scorediv.appendChild(scoretable);
		document.body.appendChild(scorediv);
		updateTable();
		ping();
		render();
	});

	socket.on("a_new_player_in_da_town", function(msg){
		var json = JSON.parse(msg);
		var positions = json.positions;
		var new_player_infos = positions[positions.length-1];
		var create_id = new_player_infos.id;
		var create_name = new_player_infos.name;
		var create_lastProcessed = new_player_infos.last;
		var create_x = new_player_infos.x;
		var create_y = new_player_infos.y;
		var create_z = new_player_infos.z;
		var kill = new_player_infos.kill;
		var death = new_player_infos.death;
		var new_player = new Player(create_x,create_y,create_z,((players.length%4)+1),create_name,create_id,kill,death);
		new_player.lastProcessed = create_lastProcessed;
		players.push(new_player);
		var label = new Label(new_player.object, new_player.name, new_player.id);
		labels.push(label);
		recentdiv.innerHTML = "<br/><i style='color:#00ff00' class='fa fa-user-plus'></i> "+create_name+" joined" + recentdiv.innerHTML;
	});

	socket.on("sorry_bruh", function(){
		document.getElementById("loadingScreen").style.display = "none";
		document.getElementById("fullServerScreen").style.visibility = "visible";
	});

	socket.on("pongresp", function(){
		latency = Date.now() - startTime;
		pingdiv.innerHTML = "Ping : "+latency.toString()+" ms";
	});

	socket.on("update", function(msg){
		var json = JSON.parse(msg);
		var posits = json.positions;
		for (var i=0; i<posits.length; i++){
			var curID = posits[i].id;
			var curPlayer;
			for (var i2=0; i2<players.length; i2++)
				if (curID == players[i2].id)
					curPlayer = players[i2]
			if (curPlayer.id == id){
				// its me
				syncdiv.innerHTML = '';
				if (posits[i].last == keyCount){
					player.serverPositCounter ++;
					player.lastServerPositRecieved = new CANNON.Vec3(posits[i].x,posits[i].y,posits[i].z);
					if (player.serverPositCounter == 2){
						player.serverPositCounter = 0; 
						syncdiv.innerHTML = '[sync]';
						player.object.phy_body.position.set(posits[i].x,posits[i].y,posits[i].z);
					}
				}
				else{
					player.serverPositCounter = 0;
					var interpolationFactor = (0.1);
					var v = new CANNON.Vec3(posits[i].x,posits[i].y,posits[i].z);
					var u = player.object.phy_body.position;
					u.lerp(v, interpolationFactor, player.object.phy_body.position);
					syncdiv.innerHTML = '[lerp]';
					
					var dist = player.object.phy_body.position.distanceTo(new CANNON.Vec3(posits[i].x,posits[i].y,posits[i].z));
					if (dist > 250){
						player.object.phy_body.position.set(posits[i].x,posits[i].y,posits[i].z);
						syncdiv.innerHTML = '[sync]';
					}
					
				}
			}
			else{
				// its somebody else
				curPlayer.serverPositCounter ++;
				curPlayer.lastServerPositRecieved = new CANNON.Vec3(posits[i].x,posits[i].y,posits[i].z);
				if (curPlayer.serverPositCounter == 2){
					curPlayer.serverPositCounter = 0;
					curPlayer.object.phy_body.position.set(posits[i].x,posits[i].y,posits[i].z);
				}
			}
		}
	});

	socket.on("a_new_move", function(msg){
		var json = JSON.parse(msg);
		for (var i=0; i<players.length;i++)
			if (players[i].id == json.id){
				var which_key = json.key;
				if (which_key == "w")
					players[i].object.phy_body.applyForce(new CANNON.Vec3(-550*Math.cos(json.yaw),0,-550*Math.sin(json.yaw)),new CANNON.Vec3(players[i].object.position.x,players[i].object.position.y,players[i].object.position.z));	
				if (which_key == "s")
					players[i].object.phy_body.applyForce(new CANNON.Vec3(550*Math.cos(json.yaw),0,550*Math.sin(json.yaw)),new CANNON.Vec3(players[i].object.position.x,players[i].object.position.y,players[i].object.position.z));
				if (which_key == "a")
					players[i].object.phy_body.applyForce(new CANNON.Vec3(-550*Math.sin(json.yaw),0,550*Math.cos(json.yaw)),new CANNON.Vec3(players[i].object.position.x,players[i].object.position.y,players[i].object.position.z));	
				if (which_key == "d")	
					players[i].object.phy_body.applyForce(new CANNON.Vec3(550*Math.sin(json.yaw),0,-550*Math.cos(json.yaw)),new CANNON.Vec3(players[i].object.position.x,players[i].object.position.y,players[i].object.position.z));	
				if (which_key =="j")
					players[i].object.phy_body.velocity.y = 300;
			}
	});

	socket.on("new_ice_beam", function(msg){
		var json = JSON.parse(msg);	
		beams.push(new IceBeam(new THREE.Vector3(json.camx,json.camy,json.camz), new THREE.Vector3(json.dirx,json.diry,json.dirz)));	
	});

	socket.on("new_ice_beam_shot", function(msg){
		var json = JSON.parse(msg);
		for (var i=0; i<players.length; i++){
			if (players[i].id == json.id){
				//players[i].object.phy_body.applyImpulse(new CANNON.Vec3(300,300,300), players[i].object.phy_body.position);
				if (players[i].object.health != json.health)
					players[i].object.health = json.health;
			}
		}
	});	
	socket.on("new_shotgun", function(msg){
		var json = JSON.parse(msg);	
		var dir = new THREE.Vector3(parseFloat(json.dirx),parseFloat(json.diry),parseFloat(json.dirz));
		new Rocket(parseFloat(json.camx),parseFloat(json.camy),parseFloat(json.camz),dir);
		for (var i=0; i<players.length; i++)
			if (players[i].id == json.id)
				players[i].object.phy_body.applyForce(new CANNON.Vec3(10000*Math.cos(parseFloat(json.yaw)),0,10000*Math.sin(parseFloat(json.yaw))),new CANNON.Vec3(players[i].object.position.x,players[i].object.position.y+1,players[i].object.position.z));
	});
	socket.on("new_shotgun_explosion", function(msg){
		console.log(JSON.parse(msg));
		var json = JSON.parse(msg);
		var ary = json.explosion;	
		for (var i=0; i<ary.length; i++){
			var curid = ary[i].id;
			for (var i2=0; i2<players.length; i2++)
				if (players[i2].id == curid){
					//var expPosition = new CANNON.Vec3(parseFloat(ary[i].x), parseFloat(ary[i].y), parseFloat(ary[i].z));
					//players[i2].object.phy_body.applyImpulse(new CANNON.Vec3(50,50,50), expPosition);
					players[i2].object.phy_body.velocity.y += 200;				
				}
		}
	});	
	socket.on("a_new_grenade", function(msg){
		if (typeof grenadeObject !== 'undefined'){
			var json = JSON.parse(msg);
			var clone_grenade = grenadeObject.clone();
			var dirVector = new THREE.Vector3(json.dirx, json.diry, json.dirz);
			var posVector = new THREE.Vector3(json.px, json.py, json.pz);
			grenades.push(new Grenade(clone_grenade, posVector, dirVector));
		}
	});
	socket.on("a_new_death", function(msg){
		var json = JSON.parse(msg);
		var victimName = '';
		var killerName = '';
		for (var i=0; i<players.length; i++)
			if (players[i].id == json.victimID){
				players[i].object.phy_body.force.set(0,0,0);
				players[i].object.phy_body.velocity.set(0,0,0);
				players[i].object.phy_body.angularVelocity.set(0,0,0);
				players[i].object.phy_body.position.set(json.new_x,json.new_y,json.new_z);	
				players[i].object.phy_body.torque.set(0,0,0);			
				players[i].object.health = 100;	
				victimName = players[i].name;
				players[i].death ++;
				players[i].point = players[i].kill - players[i].death;
				if (players[i].id == id){
					aqua_ammo = 100;	
					shotgun_ammo = 20;
					grenade_ammo = 10;
					player.object.health = 100;
					weapon = 0;
					weapondiv.style.color = '#d4f0ff';
					weapondiv.style.left = (window.innerWidth/2)-35;
					weapondiv.innerHTML = 'Ice Beam ['+aqua_ammo.toString()+']';
				}	
				
			}

		for (var i=0; i<players.length; i++) 
			if (players[i].id == json.killerID){
				killerName = players[i].name;
				players[i].kill ++;
				players[i].point = players[i].kill - players[i].death;
			}

			if (json.weapon == 0){
				recentdiv.innerHTML = "<br/>"+killerName+" <i style='color:#a5f2f3' class='fa fa-asterisk'></i> "+victimName+recentdiv.innerHTML;
			}
			if (json.weapon == 1){
				recentdiv.innerHTML = "<br/>"+killerName+" <i style='color:#fffe00' class='fa fa-bolt'></i> "+victimName+recentdiv.innerHTML;
			}
			if (json.weapon == 2){
				recentdiv.innerHTML = "<br/>"+killerName+" <i style='color:#4b5320' class='fa fa-bomb'></i> "+victimName+recentdiv.innerHTML;
			}		

	});
	socket.on("a_new_treat", function(msg){
		var json = JSON.parse(msg);
		if (json.type == 0){
			if (typeof heartObject !== 'undefined'){
				var cloneHeart = heartObject.clone();
				cloneHeart.position.set(json.x, json.y-5, json.z);
				cloneHeart.treatID = json.id;
				scene.add(cloneHeart);
				treats.push(cloneHeart);
			}	
		}
		if (json.type ==1){
			if (typeof ammoObject !== 'undefined'){
				var cloneAmmo = ammoObject.clone();
				cloneAmmo.position.set(json.x, json.y, json.z);
				cloneAmmo.treatID = json.id;
				scene.add(cloneAmmo);
				treats.push(cloneAmmo);
			}
		}
	});
	socket.on("a_new_treat_intersection", function(msg){
		var json = JSON.parse(msg);
		var treatID = json.treatID;
		var index;
		var treatOBJ;
		for (var i=0; i<treats.length; i++)
			if (treats[i].treatID == treatID){
				index = i;
				treatOBJ = treats[i];
			}

		if (typeof treatOBJ !== 'undefined') scene.remove(treatOBJ);
		if (typeof index !== 'undefined') treats.splice(index, 1);
		if (json.playerID == id && json.type == 1){
			aqua_ammo += 50;
			shotgun_ammo += 20;
			grenade_ammo += 10;
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
		}
	});
	socket.on("do_as_i_say", function(msg){
		var json = JSON.parse(msg);
		var ary = json.positions;
		for (var i=0; i<ary.length; i++){
			for (var i2=0; i2<players.length; i2++){
				if (players[i2].id == ary[i].id){
					//players[i2].object.phy_body.position.set(ary[i].x,ary[i].y,ary[i].z); --> THIS SINGLE FKING LINE MAKES THE GAME UNPLAYABLE FOR THOSE WHO HAVE A LAG AROUND 400-500 ms
					players[i2].object.health = ary[i].health;
				}
			}
		}
	});

	socket.on("a_disconnection", function(msg){
		var disc_id = JSON.parse(msg).id;
		var disc_name = '';
		var disc_player = false;
		var disc_label = false;
		for (var i=0; i<players.length; i++)
			if (players[i].id == disc_id){
				scene.remove(players[i].object);
				disconnectBodies.push(players[i].object.phy_body);
				disc_player = players[i];
				disc_name = players[i].name;
			} 
		if (disc_player != false)
			players.splice(players.indexOf(disc_player), 1);
		for (var i=0; i<labels.length; i++)
			if (labels[i].div.id == disc_id)
				disc_label = labels[i];
		if (disc_label != false){
			document.body.removeChild(disc_label.div);
			labels.splice(labels.indexOf(disc_label),1);
		}

		recentdiv.innerHTML = "<br/><i style='color:#ff0000' class='fa fa-user-times'></i> "+disc_name+" left" + recentdiv.innerHTML;
	});

	function ping(){
		startTime = Date.now();
  		socket.emit("pingreq",{});
		setTimeout(ping,2000);
	};

};
