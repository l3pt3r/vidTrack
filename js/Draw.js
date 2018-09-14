// initialize the timer variables and start the animation
function startAnimating(fps) {
    framerate = 1000 / fps;
    then = Date.now();
    startTime = then;
    animate();
}

function animate() {

    // request another frame
    requestAnimationFrame(animate);

    // calc elapsed time since last loop
    now = Date.now();
    elapsed = now - then;

    // if enough time has elapsed, draw the next frame
    if (elapsed > framerate) {

        // Get ready for next frame by setting then=now, but also adjust for
        // specified framerate not being a multiple of RAF's interval (16.7ms)
        then = now - (elapsed % framerate);

        moveAvatars();

        renderer.render(scene, camera);

    }
}