<?php
// require_once("../php/dbFunctions.php");
define("BASE_URL", "http://localhost/");  // website hostname

/**
 * Check if the user is signed in
 *
 * @return boolean
 */
function isSignedIn() {
  return isset($_SESSION['id']);
}

/**
 * Signs out the current user
 *
 * @return void
 */
function signOut() {
  session_unset();  // remove all session variables
  session_destroy();  // destroy the session
}

function sendToLogin() {
  header("Location: " . BASE_URL . "tenderoots/index.php");
  exit();
}

function updatePersonField($update) {
  $conditionField = "id";
  $condition = $_SESSION['id'];
  $table = "person_details";
  $result = updateFields($update, $conditionField, $condition, $table);
  $data = array();
  if(!$result) {
    $data['success'] = false;
    $data['errors'] = "The values failed to update";
    echo json_encode($data);
    return false;
  }

  $data['success'] = true;
  echo json_encode($data);
  return true;
}