function positionsToJSON(players){

	var json ='{';
		json += '"positions":[';
			for (var i=0; i<players.length;i++){
				if (i==0) json += '{';
				else 	  json += ',{';
					json += '"id":"'+players[i].id+'",'; 
					json += '"name":"'+players[i].name+'",';
					json += '"health":'+players[i].object.phy_body.health.toString()+',';
					json += '"kill":'+players[i].kill.toString()+',';
					json += '"death":'+players[i].death.toString()+',';
					json += '"last":'+players[i].lastProcessed.toString()+',';
					json += '"x":'+players[i].object.position.x.toString()+',';
					json += '"y":'+players[i].object.position.y.toString()+',';
					json += '"z":'+players[i].object.position.z;
				json += '}';
			};
		json += ']';
	json +='}';

	return json;

};


function treesToJSON(trees){

	// EACH TREE IS A THREEJS MESH WHICH ALSO CONTAINS A CANNONJS PHYSICAL BODY

	var json_data = '{';

		json_data += '"trees":';
		json_data += '[';

			for (var i=0; i<trees.length;i++){
				var mesh_x = trees[i].position.x;
				var mesh_y = trees[i].position.y;
				var mesh_z = trees[i].position.z;
				if (i!=0) { json_data += ','; }
				json_data += '{';
					json_data += '"x":'+mesh_x.toString();
					json_data += ',"y":'+mesh_y.toString();
					json_data += ',"z":'+mesh_z.toString();
				json_data += '}';	
			}

		json_data += ']';

	json_data += '}';

	return json_data;

};
