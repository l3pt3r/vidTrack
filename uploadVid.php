<?php
session_start();
echo session_id();
$target_dir = "videos/";
$sid = session_id();
$target_file = $target_dir . "video_" . $sid . ".mp4";
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header('Location: track.php');
        exit;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>