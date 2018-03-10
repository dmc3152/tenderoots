<?php
require_once("../php/generalFunctions.php");
startSession();

// $image = strtolower($_SESSION['firstName']) . "-" . $_SESSION['id'] . ".jpg";
// $target_file = "../assets/profilePics/" . $image;

// if(!file_exists($target_file))
//   $image = "placeholder.jpg";

?>

<link rel='stylesheet' href='/tenderoots/components/galleryUpload/galleryUpload.css'>
<script src='/tenderoots/components/galleryUpload/galleryUpload.js'></script>
<div class='gallery-upload-component'>
  <form id='galleryUploadForm'>
    <h4>Upload Pictures</h4>
    <input type='file' id='galleryInput' name='galleryInput[]' multiple>
  </form>
  <div class='files'>
    <ul></ul>
  </div>
  <div class='images'></div>
</div>