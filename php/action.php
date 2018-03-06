<?php
session_start();
require_once("dbFunctions.php");
require_once("generalFunctions.php");
connect2db();

if(!isset($_POST['action'])) {
  $data = array();
  $data['errors'] = "No action was specified";
  $data['success'] = false;
  closeDbConnection();
  echo json_encode($data);
  return false;
}

$action = cleanMySQL($_POST['action']);

switch($action) {
  case "signOut":
    signOut();
    successNoData();
    break;
  case "updatePersonField":
    $update = array();
    $key = cleanMySQL($_POST['name']);
    $value = cleanMySQL($_POST['value']);
    $update[$key] = $value;
    updatePersonField($update);
    break;
  default:
    $data = array();
    $data['errors'] = "The action specified was not valid.";
    $data['success'] = false;
    closeDbConnection();
    echo json_encode($data);
    return false;
}

function successNoData() {
  $data = array();
  $data['success'] = true;
  closeDbConnection();
  echo json_encode($data);
  return false;
}