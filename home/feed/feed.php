<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/tenderoots/php/generalFunctions.php");
startSession();

if(isset($_GET['id'])) {
  $_SESSION['feed'] = $_GET['id'];
  $profileId = $_GET['id'];
}
else {
  unset($_SESSION['feed']);
  $profileId = false;
}
?>

<link rel='stylesheet' href='./feed/feed.css'>
<script src='./feed/feed.js'></script>
<div class="row feed">
  <div class="col-sm-12">
    <h1>Feed<?php if(isset($profileId) && $profileId != $_SESSION['id']) echo "<button class='btn btn-success pull-right' onclick='sendMessage($profileId)'>Send Message</button>"; ?></h1>
  </div>
  <div id="messages" class="col-sm-12"></div>
</div>