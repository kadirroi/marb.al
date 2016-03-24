var THREE = require("three");
var express = require("express");
var http = require("http");
var socketIO = require("socket.io");
var CANNON = require("cannon");


var getClientIp = function(req) {
  var ipAddress = null;
  var forwardedIpsStr = req.headers['x-forwarded-for'];
  if (forwardedIpsStr) {
    ipAddress = forwardedIpsStr[0];
  }
  if (!ipAddress) {
    ipAddress = req.connection.remoteAddress;
  }
  return ipAddress;
};

app = express();
app.get("/", function(req, res){
	var datetime = new Date();
	console.log("["+datetime+"] New request from : "+getClientIp(req));
	res.sendFile(__dirname + "/client.html");
});
app.use(express.static('./'));
server = http.Server(app);
server.listen(80);
console.log("_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*__-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_");
console.log(" ");
console.log("||		Welcome to the server of marb.al (v1)		^ ^");
console.log("||		This server is coded by Oguz Eroglu in 2016   	===");
console.log(" ");
console.log("_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*__-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_-*_");
console.log(" ");
console.log("Waiting for the master");


var trees; 
var phy_socket;
var positions; // COMES FROM TICK_BITCH MESSAGE OF THE SERVER-PHYSICS ENGINE PROTOCOL
var players = []; // AN ARRAY HOLDING EACH PLAYERS SOCKETS
var sockets = [];
var MAX_PLAYER_SIZE = 10;

io = socketIO(server);
io.on("connection", function(socket){

	console.log("A new connection : ["+socket.id+"]");

	sockets.push(socket);

	socket.on("i_am_the_physics", function(msg){
		var json = JSON.parse(msg);
		var trees_json = json.trees;
		console.log (" RECIEVED "+trees_json.length.toString()+" TREES");
		phy_socket = socket;
		trees = msg;
		socket.emit("start_ticking", {});
		sendPositions();
		doAsISay();
	});
	socket.on("tick_bitch", function(msg){
		positions = msg;
	});
	socket.on("hello", function(){
		if (players.length>= MAX_PLAYER_SIZE){	
			var index = sockets.indexOf(socket);
			sockets.splice(index, 1);		
			socket.emit("sorry_bruh");
		}
		else {
			var json = trees.substring(0, trees.length - 1);
				json += ',"id":"'+socket.id+'"';			
			json += '}';
			socket.emit("welcome", json);
		}
	});
	socket.on("who_am_i", function(msg){
		var json = JSON.parse(msg);		
		console.log(json.name + "("+socket.id+") wants to join.");
		var param = '{';
			param += '"id":"'+socket.id+'",';
			param += '"name":"'+json.name+'"';
		param += '}';
		phy_socket.emit("who_is_he", param);
	});
	socket.on("he_is", function(msg){
		var json = JSON.parse(msg);
		var new_player_id = json.new;
		console.log("NEW : "+new_player_id);
		var index = msg.lastIndexOf("new"); 
		var new_pos = msg.substring(0,index-2);
		new_pos += '}';
		positions = new_pos;
		console.log(JSON.parse(positions));
		//console.log(new_pos);
		//console.log(new_player_id);
		for (var i=0; i<sockets.length; i++){
			if (sockets[i].id == new_player_id){
				players.push(sockets[i]);
				console.log("_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_");
				console.log("||");
				console.log("||	Pushed a new socket to players");
				console.log("||	Current player count : "+players.length.toString());
				console.log("_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_");
				sockets[i].emit("you_are", positions);
			}
			else
				sockets[i].emit("a_new_player_in_da_town",positions);
		}
	});
	socket.on("new_move", function(msg){
		phy_socket.emit("new_move", msg);
		var json = JSON.parse(msg);
		for (var i=0; i<players.length; i++)
			if (players[i].id != json.id)
				players[i].emit("a_new_move", msg);
	});
	socket.on("ice_beam", function(msg){
		phy_socket.emit("new_ice_beam", msg);
		for (var i=0; i<players.length; i++)
			if (players[i].id != socket.id)
				players[i].emit("new_ice_beam", msg);
	});
	socket.on("new_ice_beam_shot", function(msg){
		for (var i=0; i<players.length; i++)
			players[i].emit("new_ice_beam_shot", msg);
	});
	socket.on("shotgun", function(msg){
		phy_socket.emit("new_shotgun", msg);
		for (var i=0; i<players.length; i++)
			if (players[i].id != socket.id)
				players[i].emit("new_shotgun", msg);
	});
	socket.on("shotgun_explosion", function(msg){
		var json = JSON.parse(msg);
		console.log(json);
		if (json.explosion.length > 0)
			for (var i=0; i<players.length; i++)
				players[i].emit("new_shotgun_explosion",msg);
	});
	socket.on("grenade", function(msg){
		var json = JSON.parse(msg);
		phy_socket.emit("a_new_grenade", msg);
		for (var i=0; i<players.length; i++)
			if (players[i].id != json.id)
				players[i].emit("a_new_grenade", msg);
	});
	socket.on("a_death", function(msg){
		for (var i=0; i<players.length; i++)
			players[i].emit("a_new_death", msg);
	});
	socket.on("new_treat", function(msg){
		for (var i=0; i<players.length; i++) players[i].emit("a_new_treat", msg);
	});	
	socket.on("a_new_treat_intersection", function(msg){
		for (var i=0; i<players.length; i++) 
			players[i].emit("a_new_treat_intersection", msg);
	});
	socket.on('disconnect', function() {
		console.log("["+socket.id+"] disconnected");
		var index1 = sockets.indexOf(socket);
    	var index2 = players.indexOf(socket);
		if (index1 != -1)
			sockets.splice(index1, 1);
		if (index2 != -1)
			players.splice(index2, 1);
		console.log("Current number of players : "+players.length.toString());
		var param = '{"id":"'+socket.id+'"}';
		phy_socket.emit("a_disconnection", param);
		for (var i=0; i<players.length; i++)
			players[i].emit("a_disconnection", param);
	});
	socket.on("pingreq", function(){ socket.emit("pongresp"); });

});

function sendPositions(){
	for (var i=0; i<players.length;i++) players[i].emit("update", positions);
	setTimeout(sendPositions,1000);
};

function doAsISay(){
	for (var i=0; i<players.length; i++)
		players[i].emit("do_as_i_say", positions);
	setTimeout(doAsISay, 500);
};
