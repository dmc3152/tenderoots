<?php
session_start();
require_once("../php/dbFunctions.php");
require_once("../php/generalFunctions.php");
if(!isSignedIn()) sendToLogin();
?>

<html>
<head>
  <?php include_once('./head/head.php'); ?>
</head>
<body>
  <div class="app">
    <?php include_once('./header/header.php'); ?>
    <div id="content"></div>
  </div>
  <?php include_once('../components/reply/reply.php') ?>
  <?php include_once('./foot/foot.php'); ?>
</body>
</html>