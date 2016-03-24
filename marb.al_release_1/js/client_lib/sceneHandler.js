var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 0.1, 1000 );
scene.add(camera);

var phy_world = new CANNON.World();
phy_world.quatNormalizeSkip = 0;
phy_world.quatNormalizeFast = false;
var phy_solver = new CANNON.GSSolver();
phy_world.defaultContactMaterial.contactEquationStiffness = 1e9;
phy_world.defaultContactMaterial.contactEquationRelaxation = 4;
phy_solver.iterations = 7;
phy_solver.tolerance = 0.1;
phy_world.solver = new CANNON.SplitSolver(phy_solver);
phy_world.gravity.set(0,-900,0);		   
phy_world.broadphase = new CANNON.NaiveBroadphase();

var renderer = new THREE.WebGLRenderer({alpha:true});
renderer.setClearColor( 0x000000, 0 );
renderer.setSize( window.innerWidth, window.innerHeight );
renderer.shadowMapType = THREE.PCFSoftShadowMap;

scene.fog = new THREE.Fog( 0x000000, 300, 1000 );

var light	= new THREE.AmbientLight( 0x222222 );
scene.add( light );

var point_light = new THREE.PointLight( 0xffffff, 1.5, 100 );
scene.add(point_light);

camera.position.set(0,50,0);
camera.lookAt(new THREE.Vector3(0,0,5));

var night_arena;

var initScene = function(trees){
	document.body.appendChild( renderer.domElement );
	night_arena = new night_arena();
	night_arena.initScene(trees);
};
