<?php
session_start();
require_once("../../php/ImageManipulator.php");

$data = array();
$target_sub_directory = strtolower($_SESSION['firstName']) . "-" . $_SESSION['id'];
$target_dir = "../../assets/images/$target_sub_directory/";
$target_thumb_dir = "../../assets/images/$target_sub_directory/thumb/";

$count = count($_FILES["galleryInput"]["name"]);
for($i = 0; $i < $count; $i++) {
  // Set up paths
  $tmp_file = $_FILES['galleryInput']['tmp_name'][$i];
  $target_file = $target_dir . $_FILES["galleryInput"]["name"][$i];
  $target_thumb = $target_thumb_dir . $_FILES["galleryInput"]["name"][$i];

  // Check if the file is a real image
  if(!getimagesize($tmp_file)) {
    $data['errors'] = "The file was not a real image.";
    $data['success'] = false;
    echo json_encode($data);
    return false;
  }

  // Save image and thumbnail
  try {
    $manipulator = new ImageManipulator($tmp_file);
    $manipulator->save($target_file);
    $manipulator->resizeWidth(50);
    $manipulator->save($target_thumb);    
  }
  catch(RuntimeException $error) {
    $data['error'] = "There was an error uploading the image.";
    $data['success'] = false;
    echo json_encode($data);
    return false;
  }
}

// Save image
// if (!move_uploaded_file($tmp_file, $target_file)) {
//   $data['error'] = "There was an error uploading the image.";
//   $data['success'] = false;
//   echo json_encode($data);
//   return false;
// }

$data['success'] = true;
echo json_encode($data);