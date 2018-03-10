<?php
require_once("../../php/generalFunctions.php");
require_once("../../php/dbFunctions.php");
startSession();
connect2db();

$user = getUserDetailsById($_SESSION['id']);
?>

<link rel='stylesheet' href='./feed/feed.css'>
<script src='./feed/feed.js'></script>
<div class="row feed">
  <div class="col-sm-12">
    <h1>Feed</h1>
  </div>
  <div id="messages" class="col-sm-12"></div>
</div>

<?php closeDbConnection(); ?>