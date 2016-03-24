var Label = function(obj, context, playerID){
	this.obj = obj;
	this.context = context;
	this.playerID = playerID;
	this.div = document.createElement('div');
	this.div.id = this.playerID;
	this.div.className = "label";
	var coords = toScreenPosition(this.obj,camera);
	this.div.style.left = coords.x + 'px';
	this.div.style.top = coords.y + 'px';
	document.getElementsByTagName('body')[0].appendChild(this.div);

	this.innerDiv = document.createElement('div');
	this.innerDiv.innerHTML = context;
	this.healthSpan = document.createElement('span');
	this.healthSpan.style.color = '#b60027';
	this.healthIcon = document.createElement('i');
	this.healthIcon.className="fa fa-heart";
	this.healthSpan.innerHTML = ' '+this.obj.health.toString()+' ';
	this.healthSpan.appendChild(this.healthIcon);
	this.innerDiv.appendChild(this.healthSpan);
	this.div.appendChild(this.innerDiv);	

};

Label.prototype.update = function(){

	var coords = toScreenPosition(this.obj,camera);
	this.div.style.left = coords.x + 'px';
	this.div.style.top = coords.y + 'px';
	this.healthSpan.innerHTML = ' '+this.obj.health.toString()+' ';
	this.healthSpan.appendChild(this.healthIcon);

};

