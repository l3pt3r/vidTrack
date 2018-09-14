function initScene() {
    //set up scene, geometry and camera
    camera.position.set(0, 37, 65);

    // scene.add(new THREE.AxesHelper(10));

    // set up the renderer
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    //resize window function 
    window.addEventListener('resize', function () {
        var width = window.innerWidth;
        var height = window.innerHeight;
        renderer.setSize(width, height);
        camera.aspect = width / height;
        camera.updateProjectionMatrix;
    });

    //create Orbit Controller for changing viewpoint
    controls = new THREE.OrbitControls(camera, renderer.domElement);

    //create the light
    var light = new THREE.AmbientLight(0x777777, 1); // soft white light
    scene.add(light);
}