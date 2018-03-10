<?php
session_start();
require_once("../../php/ImageManipulator.php");

$data = array();
$target_dir = "../../assets/profilePics/";
$target_name = strtolower($_SESSION['firstName']) . "-" . $_SESSION['id'] . ".jpg";
$target_file = $target_dir . $target_name;
$check = getimagesize($_FILES["profilePic"]["tmp_name"]);

// Check if the file is a real image
if(!$check) {
  $data['errors'] = "The file was not a real image.";
  $data['success'] = false;
  echo json_encode($data);
  return false;
}

// Remove old profile pic
if(file_exists($target_file))
  unlink($target_file);

// Resize and crop new image
$manipulator = new ImageManipulator($_FILES['profilePic']['tmp_name']);
$newImage = $manipulator->resizeWidth(200);
// $width  = $manipulator->getWidth();
// $height = $manipulator->getHeight();
// $data['width'] = $width;
// $data['height'] = $height;
// $centreX = round($width / 2);
// $centreY = round($height / 2);
$x1 = 0; //$centreX - 100;
$y1 = 0; //$centreY - 100;
$x2 = 200; //$centreX + 100;
$y2 = 200; //$centreY + 100;
$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
$manipulator->save($target_file);

// Save profile pic
// if (!move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
//   $data['errors'] = "There was an error uploading the image.";
//   $data['success'] = false;
//   echo json_encode($data);
//   return false;
// }

$data['fileName'] = $target_name;
$data['success'] = true;
echo json_encode($data);