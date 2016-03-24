var yawRad = 0;
var camera_y_ref = 0;


function updateTable(){

	scorediv.removeChild(scoretable);
	
	scoretable =  document.createElement('table');
	scoretable.style.color = '#ffffff';
	scoretable.style.fontFamily = 'Courier';
	scoretable.style.fontSize = '12px';	


	var tr = document.createElement('tr');   

    var td1 = document.createElement('td');
    var td2 = document.createElement('td');
	var td3 = document.createElement('td');

	td1.innerHTML = '<span> Name </span>';
	td2.innerHTML = '<span style = "color:#00ff00"> Kills </span>';
	td3.innerHTML = '<span style = "color:#ff0000"> Deaths </span>';

	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);

	scoretable.appendChild(tr);

	players.sort(function(a,b){ return b.point - a.point; });
	
	for (var i=0; i<players.length; i++){
		var tr = document.createElement('tr');   

   	 	var td1 = document.createElement('td');
   		var td2 = document.createElement('td');
		var td3 = document.createElement('td');	

		td2.style.textAlign="right";
		td3.style.textAlign="right";

		td1.innerHTML = '<span> '+players[i].name+' </span>';
		td2.innerHTML = '<span style = "color:#00ff00"> '+players[i].kill.toString()+' </span>';
		td3.innerHTML = '<span style = "color:#ff0000"> '+players[i].death.toString()+' </span>';

		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);

		scoretable.appendChild(tr);
	}

	scorediv.appendChild(scoretable);

	setTimeout(updateTable, 1000);
};

function render(){

	handleKeys();

	for (var i=0; i<disconnectBodies.length; i++)
		phy_world.removeBody(disconnectBodies[i]);
	disconnectBodies = [];


	phy_world.step(1/60);

	var frustum = new THREE.Frustum();
	var cameraViewProjectionMatrix = new THREE.Matrix4();
	camera.updateMatrixWorld();
	camera.matrixWorldInverse.getInverse(camera.matrixWorld);
	cameraViewProjectionMatrix.multiplyMatrices(camera.projectionMatrix, camera.matrixWorldInverse);
	frustum.setFromMatrix(cameraViewProjectionMatrix);

	for (var i=0; i<players.length; i++) players[i].updatePosition();
	for (var i=0; i<labels.length; i++){
		if (frustum.intersectsObject(labels[i].obj)){	
			labels[i].div.style.visibility = 'visible';	
			labels[i].update();
		}
		else
			labels[i].div.style.visibility='hidden';
	}

	for (var i=0; i<beams.length; i++) beams[i].render();
	for (var i=0; i<grenades.length;i++) grenades[i].render();
	for (var i=0; i<treats.length; i++) treats[i].rotateY(0.03);

	night_arena.snow();				


	camera.position.x = player.object.position.x + 70 * Math.cos(yawRad);
	camera.position.z = player.object.position.z + 70 * Math.sin(yawRad);
	camera.position.y = player.object.position.y+camera_y_ref+35;

	camera.lookAt(new THREE.Vector3(player.object.position.x,player.object.position.y+20,player.object.position.z+5));

	point_light.position.set(player.object.position.x,player.object.position.y,player.object.position.z);
	
	renderer.render(scene, camera);
	requestAnimationFrame( render );

};
