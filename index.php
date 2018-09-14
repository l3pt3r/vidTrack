<?php 
    session_start();
    $sesID = session_id();
    echo $sesID;
?>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <style>
        .content {
            max-width: 50%;
            align-content: center;
            margin: auto;
            padding: 10px;
        }

        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
            cursor: pointer;
        }

        #text {
            position: absolute;
            top: 65%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        .loader {
            position: absolute;
            height: 200px;
            width: 200px;
            background: transparent url('img/teilogo.png') no-repeat 0 0;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Video Tracker & 3D Visualizer</h1>
    </div>

    <br>
    <div class="row col-sm-6" style="margin: auto; max-width: 50%;">
        <button type="button" class="btn btn-info btn-block" onclick="newTrack()">Upload Video</button>
    </div>
    <script>

        function newTrack() {
            window.location = "upload.php";
        }

    </script>
</body>

</html>