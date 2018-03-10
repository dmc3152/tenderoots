<?php
require_once("../php/generalFunctions.php");
startSession();

$image = strtolower($_SESSION['firstName']) . "-" . $_SESSION['id'] . ".jpg";
$target_file = "../assets/profilePics/" . $image;

if(!file_exists($target_file))
  $image = "placeholder.jpg";

echo "<link rel='stylesheet' href='/tenderoots/components/profilePic/profilePic.css'>";
echo "<script src='/tenderoots/components/profilePic/profilePic.js'></script>";
echo "<div class='profile-pic-component'>";
echo "<form id='picUploadForm'>";
echo "<img id='profilePic' src='/tenderoots/assets/profilePics/$image' onclick='clickHiddenInput();'>";
echo "<small class='form-text text-muted'>Click on the image to change your profile picture.</small>";
echo "<input type='file' id='hiddenFileInput' name='profilePic'>";
echo "</form>";
echo "</div>";

?>