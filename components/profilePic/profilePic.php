<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/tenderoots/php/generalFunctions.php");
startSession();

if(isset($_GET['id'])) {
  $id = $_SESSION['feed'];
  $firstName = $_SESSION['feedName'];
} else {
  $id = $_SESSION['id'];
  $firstName = $_SESSION['firstName'];
}

$image = strtolower($firstName) . "-" . $id . ".jpg";
$target_file = $_SERVER['DOCUMENT_ROOT'] . "/tenderoots/assets/profilePics/" . $image;

if(!file_exists($target_file))
  $image = "placeholder.jpg";

echo "<link rel='stylesheet' href='/tenderoots/components/profilePic/profilePic.css'>";
echo "<script src='/tenderoots/components/profilePic/profilePic.js'></script>";
echo "<div class='profile-pic-component'>";
echo "<form id='picUploadForm'>";
echo "<img id='profilePic' src='/tenderoots/assets/profilePics/$image' onclick='clickHiddenInput($editProfilePic);'>";
if($editProfilePic)
  echo "<small class='form-text text-muted'>Click on the image to change your profile picture.</small>";
echo "<input type='file' id='hiddenFileInput' name='profilePic'>";
echo "</form>";
echo "</div>";

?>