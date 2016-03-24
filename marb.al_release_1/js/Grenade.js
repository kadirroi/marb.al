var Grenade = function(pos, dir, throwerID){
	this.throwerID = throwerID;
	this.pos = pos;
	this.dir = dir;
	this.initPhysics();
	this.tick = 0;
	this.setCountDown();	
};

Grenade.prototype.initPhysics = function(){

	this.phy_shape = new CANNON.Box(new CANNON.Vec3(7/2,11/2,7/2));
	this.phy_body = new CANNON.Body({mass : 130});
	this.phy_body.addShape(this.phy_shape);
	this.phy_body.position.x = this.pos.x;
	this.phy_body.position.y = this.pos.y+6;
	this.phy_body.position.z = this.pos.z+10;
	this.phy_body.velocity.x = 780 * this.dir.x;
	this.phy_body.velocity.y = 780 * this.dir.y;
	this.phy_body.velocity.z = 780 * this.dir.z;
	phy_world.add(this.phy_body);

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

	var damageCounter = 0;	
	var params = '{"explosion":[';

	for (var i=0;i<players.length;i++){
		var curPlayer = players[i];
		var expPosition = this.phy_body.position;
		var dist = expPosition.distanceTo(curPlayer.object.phy_body.position);
		if (dist <= 180 ){
			var damage = Math.floor(180 - dist);
			curPlayer.object.phy_body.health -= damage;

			if (curPlayer.object.phy_body.health <=0){
				var victimID = curPlayer.id;
				var weapon = 2;
				var killerID = this.throwerID;
				deathOf(victimID, killerID, weapon);
			}
			else{
				if (damageCounter == 0)
					params += '{';
				else
					params += ',{';
					
					params += '"id":"'+curPlayer.id+'",';
					params += '"health":'+curPlayer.object.phy_body.health.toString();
				params += '}';
				damageCounter ++;
			}
		}
	};

	phy_world.removeBody(this.phy_body);
	grenades.splice(grenades.indexOf(this),1);

	params += ']}';

	socket.emit("grenade_explosion",params);
};

