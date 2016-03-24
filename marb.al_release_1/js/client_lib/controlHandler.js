var keyMap = [];
var keyCount = 0;

var handleKeys = function(){

	for (var ki=0;ki<keyMap.length;ki++)			
		switch ( keyMap[ki] ) {
	
			case "w": //W
				keyCount++;
				player.object.phy_body.applyForce(new CANNON.Vec3(-550*Math.cos(yawRad),0,-550*Math.sin(yawRad)),new CANNON.Vec3(player.object.position.x,player.object.position.y,player.object.position.z));
				var msg = '{"id":"'+id+'","key":"w","yaw":'+yawRad.toString()+',"count":'+keyCount.toString()+'}';
				socket.emit("new_move",msg);
			break;

			case "s": //S
				keyCount++;
				player.object.phy_body.applyForce(new CANNON.Vec3(550*Math.cos(yawRad),0,550*Math.sin(yawRad)),new CANNON.Vec3(player.object.position.x,player.object.position.y,player.object.position.z));
				var msg = '{"id":"'+id+'","key":"s","yaw":'+yawRad.toString()+',"count":'+keyCount.toString()+'}';
				socket.emit("new_move",msg);
			break;

			case "a": //A
				keyCount++;
				player.object.phy_body.applyForce(new CANNON.Vec3(-550*Math.sin(yawRad),0,550*Math.cos(yawRad)),new CANNON.Vec3(player.object.position.x,player.object.position.y,player.object.position.z));	
				var msg = '{"id":"'+id+'","key":"a","yaw":'+yawRad.toString()+',"count":'+keyCount.toString()+'}';
				socket.emit("new_move",msg);
			break;

			case "d": //D
				keyCount++;
				player.object.phy_body.applyForce(new CANNON.Vec3(550*Math.sin(yawRad),0,-550*Math.cos(yawRad)),new CANNON.Vec3(player.object.position.x,player.object.position.y,player.object.position.z));	
				var msg = '{"id":"'+id+'","key":"d","yaw":'+yawRad.toString()+',"count":'+keyCount.toString()+'}';
				socket.emit("new_move",msg);
			break;


		}

};

function moveCallback (event){

	var movementX = event.movementX || event.mozMovementX || event.webkitMovementX || 0;	
	var movementY = event.movementY || event.mozMovementY || event.webkitMovementY || 0;

	var movX = false;
	
	if (Math.abs(movementX)>=Math.abs(movementY))
		movX = true;

	if (movX){

		if (movementX<0)
			yawRad -= 0.02;
		else
			yawRad += 0.02;
	}
	else{
		if (movementY<0)
				if (camera_y_ref>-35)
					camera_y_ref -= 1; 
		if (movementY>0)
				if (camera_y_ref<35)
					camera_y_ref += 1;
	}

};

var onKeyDown = function ( event ) {

	event.preventDefault();

	switch ( event.keyCode ) {

		case 87: //W
			var index = keyMap.indexOf("w");
			if (index == -1) {
				keyMap.push("w");
				//player.decW = false;
			}
			break;
		case 83: //S
			var index = keyMap.indexOf("s");
			if (index == -1) {
				keyMap.push("s");
				//player.decS = false;
			}
			break;

		case 65: // A
			var index = keyMap.indexOf("a");
			if (index == -1) {
				keyMap.push("a");
				//player.decA = false;
			}
			break;		
		case 68: // D
			var index = keyMap.indexOf("d");
			if (index == -1) {
				keyMap.push("d");
				//player.decD = false;
			}
			break;	

		case 32: // space		
			if (player.object.phy_body.velocity.y>=-1 && player.object.phy_body.velocity.y<=1){
				keyCount++;			
				player.object.phy_body.velocity.y = 300;
				var msg = '{"id":"'+id+'","key":"j","yaw":'+yawRad.toString()+',"count":'+keyCount.toString()+'}';
				socket.emit("new_move",msg);
			}
			break;

	}

};

var onKeyUp = function ( event ) {

	switch ( event.keyCode ) {

		case 87:
			var index = keyMap.indexOf("w");
			if (index > -1) {
				//player.decW = true;
				keyMap.splice(index, 1);
			}
			break;

		case 83:
			var index = keyMap.indexOf("s");
			if (index > -1) {
				//player.decS = true;
				keyMap.splice(index, 1);
			}
			break;
		case 65: // A
			var index = keyMap.indexOf("a");
			if (index > -1) {
				//player.decA = true;
				keyMap.splice(index, 1);
			}
			break;	
		case 68: // D
			var index = keyMap.indexOf("d");
			if (index > -1) {
				//player.decD = true;
				keyMap.splice(index, 1);
			}
			break;	

		case 88: // X
			requestPointerLock();
		break;

		case 81: // Q
			weapon --;
			if (weapon<0) weapon = 2;	

		if (weapon == 0){
			weapondiv.style.color = '#d4f0ff';
			weapondiv.style.left = (window.innerWidth/2)-35;
			weapondiv.innerHTML = 'Aqua Beam ['+aqua_ammo.toString()+']';
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

		break;

		case 69: // E
			weapon ++;
			weapon%=3;

		if (weapon == 0){
			weapondiv.style.color = '#d4f0ff';
			weapondiv.style.left = (window.innerWidth/2)-35;
			weapondiv.innerHTML = 'Aqua Beam ['+aqua_ammo.toString()+']';
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

		break;
	}

};

function requestPointerLock(){

	document.body.requestPointerLock = document.body.requestPointerLock || document.body.mozRequestPointerLock || 	   document.body.webkitRequestPointerLock;
	document.body.requestPointerLock();

};

