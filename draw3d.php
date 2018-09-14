<?php 
    session_start();
    echo session_id();
?>

<html>

<head>
	<title>3D Football Emulator</title>

	<!-- <link href="css/style.css" type="text/css" rel="stylesheet" /> -->
	<style>
		body {
			margin: 0;
			overflow: hidden;
		}

		canvas {
			width: 100%;
			height: 100%;
		}
	</style>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

	<script src="js/three.js"></script>
	<script src="js/OrbitControls.js"></script>
	<script src="js/JSONLoader.js"></script>
	<script src="js/ObjectLoader.js"></script>
	<script src="js/FileLoader.js"></script>
	<script src="js/Object3D.js"></script>
	<script src="js/Draw.js"></script>
	<script src="js/Loading.js"></script>
	<script src="js/Initialize.js"></script>
	<script src="js/Moving.js"></script>
</head>

<body>

	<div class="jumbotron text-center" style="margin-bottom:0">
		<h1>Video Tracker & 3D Visualizer</h1>
	</div>


	<div class="row">
		<div class="col-sm-3">
			<div class="slidecontainer">
				<input type="range" min="1" max="60" value="30" class="slider" id="myRange" style="width: 100%">
				<p style="margin:auto; width: 50%">FPS:
					<span id="demo"></span>
				</p>
			</div>
		</div>
		<div class="col-sm-3">
			<button class="btn btn-warning btn-block" id="resanim">
				<i class="fa fa-refresh" style="color:white"></i>
				<i class="fa fa-street-view" style="color:white"></i>
			</button>
		</div>
		<div class="col-sm-3">
			<button class="btn btn-primary btn-block" id="button">
				<i class="fa fa-refresh" style="color:white"></i>
				<i class="fa fa-video-camera" style="color:white"></i>
			</button>
		</div>
		<div class="col-sm-3">
			<button class="btn btn-success btn-block" id="playanim">
				<i class="fa fa-play" style="color:white"></i>
				<i class="fa fa-futbol-o" style="color:white"></i>
			</button>
		</div>
	</div>


	<script>

		//============================ Declaring Variables ============================
		var scene = new THREE.Scene();
		var camera = new THREE.PerspectiveCamera(90, window.innerWidth / window.innerHeight, 0.1, 1000);
		var renderer = new THREE.WebGLRenderer({ preserveDrawingBuffer: true });
		var player = new THREE.ObjectLoader();
		var avatar;
		var field = new THREE.ObjectLoader();
		var posdata = new THREE.FileLoader();
		var avatars = [];
		var jsondata;
		var Dx = 15;
		var Dz = 25;
		var posx = 0;
		var posz = 0;
		var avcnt = 0;
		var poscnt = 0;
		var fps, framerate, startTime, now, then, elapsed;
		var slider = document.getElementById("myRange");
		var output = document.getElementById("demo");
		var sesId = "<?php 'echo session_id()' ?>";
		alert(sesId); 


		//============================ Initializing scene ============================
		initScene();

		//============================ load object function ============================
		loadAvatar(sesId);

		//============================ Buttons control functions ============================

		//reset camera function
		document.getElementById('button').onclick = function () {
			camera.position.set(0, 37, 68.5);
			controls.update();
			renderer.render(scene, camera);
		}

		//play animation function
		document.getElementById('playanim').onclick = function () {
			for (var i = 0; i < avatars.length; i++) {
				avatars[i].position.set(jsondata.Players[i].x[0] - Dx, 0, jsondata.Players[i].z[0] - Dz);
				scene.add(avatars[i]);
			}

			//============================ Animating function ============================
			console.log(slider.value);
			startAnimating(slider.value);
		}

		//reset animation function
		document.getElementById('resanim').onclick = function () {
			for (var i = 0; i < avatars.length; i++) {
				avatars[i].position.set(jsondata.Players[i].x[0] - Dx, 0, jsondata.Players[i].z[0] - Dz);
			}
			poscnt = 0;

			//============================ Animating function ============================
			console.log(slider.value);
			startAnimating(slider.value);
		}

		output.innerHTML = slider.value;
		slider.oninput = function () {
			output.innerHTML = this.value;
		}

		function setRandomColor() {
			var letters = '0123456789ABCDEF';
			var color = '#';
			for (var i = 0; i < 6; i++) {
				color += letters[Math.floor(Math.random() * 16)];
			}
			return color;
		}

	</script>
</body>

</html>