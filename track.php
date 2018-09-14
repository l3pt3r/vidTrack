<?php 
    session_start();
    echo session_id();
?>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="content">

        <div id="overlay">
            <div id="text">Tracking...</div>
            <div class="loader"></div>
        </div>

        <div class="jumbotron text-center" style="margin-bottom:0">
            <h1>Video Tracker & 3D Visualizer</h1>
        </div>

        <div class="container" style="margin-top:30px; margin-left: 0; margin-right: 0;">
            <div class="row" id="controls">
                <div class="col-sm-6">
                    <button class="btn btn-success" id="playButton" onclick="play()">
                        <i class="fa fa-play" style="color:white"></i>
                    </button>
                    <button class="btn btn-danger" id="stopButton" onclick="stop()">
                        <i class="fa fa-pause" style="color:white"></i>
                    </button>
                    <button class="btn btn-primary" id="sendButton" onclick="send()">
                        <i class="fa fa-share" style="color:white"></i>
                    </button>

                    <p id="playerpoints">Players' Rectangles:</p>
                </div>
                <div class="col-sm-6 float-sm-right">
                    <form class="float-sm-right">
                        Camera Height (m e.g. 1.5):
                        <br>
                        <input type="number" id="camh" value="4.5">
                        <br> Focal Length (mm):
                        <br>
                        <input type="number" id="focal" value="29">
                        <br> Duration (sec):
                        <br>
                        <input type="number" id="dur" value="10">
                    </form>
                </div>
            </div>


            <div id="dispContent">
                <canvas id="videoCanvas"></canvas>
                <video id="video" muted hidden></video>
            </div>

            <a href="http://lusob.com/2012/02/tracking-a-football-match-with-html5-and-javascript">[+]</a>

        </div>

        <script>
            var sesId = '<?php echo session_id(); ?>';
            console.log(sesId);
            var v = document.getElementById("video");
            v.src = "videos/video_"+ sesId + ".mp4"
            var c = document.getElementById("videoCanvas");
            var cb = document.getElementById("cntrlbtns");
            ctx = c.getContext("2d");

            var x1 = y1 = x2 = y2 = fr = width = height = mousex = mousey = r = 0;
            var mousedown = continueAnimating = activeRect = false;
            var rects = [];
            var drawRects = [];

            function rectToDraw(x, y, w, h) {
                this.x = x;
                this.y = y;
                this.w = w;
                this.h = h;
            }

            document.addEventListener('keydown', this.check, false);

            function getMousePos(c, evt) {
                var rect = c.getBoundingClientRect(), // abs. size of element
                    scaleX = c.width / rect.width,    // relationship bitmap vs. element for X
                    scaleY = c.height / rect.height;  // relationship bitmap vs. element for Y

                return {
                    x: (evt.clientX - rect.left),   // scale mouse coordinates after they have
                    y: (evt.clientY - rect.top)     // been adjusted to be relative to element
                }
            }

            function check(e) {
                if (e.keyCode == 13 && activeRect == true) {
                    var w = Math.abs(x1 - x2);
                    var h = Math.abs(y1 - y2);
                    rects.push(x1 + ' ' + y1 + ' ' + w + ' ' + h);
                    console.log(rects);
                    drawRects.push(r);
                    document.getElementById("playerpoints").innerHTML = "Players' Rectangles: " + rects;
                    activeRect = false;
                    ctx.strokeStyle = 'yellow';
                }
            }

            //Mousedown
            c.addEventListener('mousedown', function (e) {
                var pos = getMousePos(c, e);
                x1 = parseInt(pos.x);
                y1 = parseInt(pos.y);
                mousedown = true;
            });

            //Mouseup
            c.addEventListener('mouseup', function (e) {
                mousedown = false;
                r = new rectToDraw(x1, y1, width, height);

                // console.log("topLeft(" + x1 + ", " + y1 + "), bottomRight(" + x2 + ", " + y2 + ")");
                console.log(drawRects);
            });

            //Mousemove
            c.addEventListener('mousemove', function (e) {
                var pos = getMousePos(c, e);
                mousex = parseInt(pos.x);
                mousey = parseInt(pos.y);
            });

            function play() {
                c.setAttribute("width", v.videoWidth);
                c.setAttribute("height", v.videoHeight);
                continueAnimating = true;
                v.play();
                drawRects = [];
                animate();
            }
            function stop() {
                v.pause();
                fr = Math.floor(v.currentTime * 30);
                continueAnimating = false;
            }

            function send() {

                document.getElementById("overlay").style.display = "block";
                console.log(fr, rects);
                var ch = document.getElementById("camh").value * 1000;
                var fc = document.getElementById("focal").value;
                var vdur = document.getElementById("dur").value;
                vdur = (vdur * 30) + fr;
                console.log(ch, fc, vdur);

                $.ajax({
                    type: 'post',
                    url: 'execute.php',
                    data: { 'frame': fr, 'trackers': rects, 'camHeight': ch, 'focal': fc, 'duration': vdur },
                    success: function (response) {
                        console.log(response.blablabla);
                        window.location = "draw3d.php";
                    }
                });


            }

            function animate() {

                ctx.drawImage(v, 0, 0, c.width, c.height);

                if (drawRects.length > 0 && continueAnimating == false) {
                    for (var i = 0; i < drawRects.length; i++) {
                        ctx.beginPath();
                        ctx.rect(drawRects[i].x, drawRects[i].y, drawRects[i].w, drawRects[i].h);
                        ctx.lineWidth = 2;
                        ctx.stroke();
                    }
                }

                if (mousedown) {
                    ctx.beginPath();
                    width = mousex - x1;
                    height = mousey - y1;
                    ctx.rect(x1, y1, width, height);
                    x2 = mousex;
                    y2 = mousey;
                    ctx.strokeStyle = 'blue';
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    activeRect = true;
                }

                // request another frame
                requestAnimationFrame(animate);

            }

        </script>
</body>

</html>