<?php
session_start();
require_once("../../php/ImageManipulator.php");
require_once("../../php/dbFunctions.php");
connect2db();

$creatorId = $_SESSION['id'];
$firstName = cleanMySQL($_POST['firstName']);
$lastName = cleanMySQL($_POST['lastName']);
$middleNames = cleanMySQL($_POST['middleNames']);
$birthday = cleanMySQL($_POST['birthday']);
$deathDate = cleanMySQL($_POST['deathDate']);
$bio = cleanMySQL($_POST['bio']);
$memberType = cleanMySQL($_POST['memberType']);
$data = array();

$personId = addRelative($creatorId, $deathDate);
if(!$personId) {
  $data['errors'] = "The relative could not be added.";
  $data['success'] = false;
  echo json_encode($data);
  return false;
}

$id = addPerson("REL", $personId, $firstName, $lastName);
if(!$id) {
  $data['errors'] = "The person could not be added.";
  $data['success'] = false;
  echo json_encode($data);
  return false;
}

$update = array();
$update['birthday'] = $birthday;
$update['bio'] = $bio;
$result = updateFields($update, 'id', $id, 'person_details');

addFamilyMember($creatorId, $id, $memberType);

$data['id'] = $id;
$data['firstName'] = $firstName;
$data['lastName'] = $lastName;

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/tenderoots/assets/profilePics/";
$target_name = strtolower($firstName) . "-" . $id . ".jpg";
$target_file = $target_dir . $target_name;

if(empty($_FILES)) {
  $data['uploaded'] = false;
  $data['success'] = true;
  echo json_encode($data);
  return false;
}

if(!file_exists($_FILES['profilePic']['tmp_name']) || !is_uploaded_file($_FILES['profilePic']['tmp_name'])) {
  $data['uploaded'] = false;
  $data['success'] = true;
  echo json_encode($data);
  return false;
}

// Set up paths
$tmp_file = $_FILES['profilePic']['tmp_name'];

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
  $manipulator->resizeWidth(200);
  $manipulator->save($target_file);    
}
catch(RuntimeException $error) {
  $data['error'] = "There was an error uploading the image.";
  $data['success'] = false;
  echo json_encode($data);
  return false;
}

$data['uploaded'] = true;
$data['success'] = true;
echo json_encode($data);