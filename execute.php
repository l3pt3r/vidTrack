<?php
$src = 'videos\video.mp4';
// $x = $_POST['video'];
// $f = $_POST['frame'];
$obj = json_encode($_POST['trackers']);
$fr =  json_encode($_POST['frame']);
$ch =  json_encode($_POST['camHeight']);
$fc =  json_encode($_POST['focal']);
$vd =  json_encode($_POST['duration']);
print_r($_POST);

$sid = session_id();
$fileName = 'rect_'. $sid .".txt";
$myfile = fopen($fileName, "w") or die("Unable to open file!");

foreach($_POST['trackers'] as $obj)
  {   
      fwrite($myfile, 'box: ');
      fwrite($myfile, $obj);
      fwrite($myfile, "\n");
  }
fwrite($myfile, 'frame: ');
fwrite($myfile, str_replace("\"","", $fr));
fwrite($myfile, "\n");
fwrite($myfile, 'camHeight: ');
fwrite($myfile, str_replace("\"","", $ch));
fwrite($myfile, "\n");
fwrite($myfile, 'focal: ');
fwrite($myfile, str_replace("\"","", $fc));
fwrite($myfile, "\n");
fwrite($myfile, 'duration: ');
fwrite($myfile, str_replace("\"","", $vd));
fclose($myfile);

exec("service\multiple_objects.exe $src $fileName $sid", $result, $return);

if($return) {
  echo ("blablabla"->$result);
}
?>
