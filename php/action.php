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
    resultNoData(true, null);
    break;

  case "updatePersonField":
    $update = array();
    $key = cleanMySQL($_POST['name']);
    $value = cleanMySQL($_POST['value']);
    $update[$key] = $value;
    updatePersonField($update);
    break;

  case "declineFriendRequest":
    $id = cleanMySQL($_POST['id']);
    $personId = cleanMySQL($_POST['personId']);
    $result = declineFriendRequest($id, $personId);
    if(!$result)
      resultNoData(false, "There was a problem removing the friend request.");
    else
      resultNoData(true, null);      
    break;

  case "acceptFriendRequest":
    $id = cleanMySQL($_POST['id']);
    $personId = cleanMySQL($_POST['personId']);
    $result = acceptFriendRequest($id, $personId);
    if(!$result)
      resultNoData(false, "There was a problem adding the friend.");
    else
      resultNoData(true, null);      
    break;

  case "searchUsers":
    $id = $_SESSION['id'];
    $value = cleanMySQL($_POST['value']);
    $result = searchUsers($id, $value);
    if(!$result)
      resultNoData(false, "There was a problem finding users.");
    else {
      $data = array();
      $data['success'] = true;
      $data['results'] = $result;
      $data['id'] = $id;
      closeDbConnection();
      echo json_encode($data);
      return false;
    } 
    break;

  case "addFriendRequest":
    $id = cleanMySQL($_POST['id']);
    $personId = cleanMySQL($_POST['personId']);
    $result = addFriendRequest($id, $personId);
    if(!$result)
      resultNoData(false, "There was a problem sending the friend request.");
    else
      resultNoData(true, null);
    break;

  case "getFeed":
    $feed = getFeed($_SESSION['id']);
    if($feed === -1) {
      resultNoData(false, "There was a problem getting the feed.");
    } else {
      $data = array();
      $data['success'] = true;
      $data['feed'] = $feed;
      closeDbConnection();
      echo json_encode($data);
    }
    break;

  case "getUserById":
    $id = cleanMySQL($_POST['id']);
    $user = getUserById($id);
    if(!$user)
      resultNoData(false, "There was a problem getting the user's information.");
    else {
      $data = array();
      $data['success'] = true;
      $data['user'] = $user;
      closeDbConnection();
      echo json_encode($data);
    }
    break;

  case "dismissFeedItem":
    $id = cleanMySQL($_POST['id']);
    $result = dismissFeedItem($id);
    if(!$result)
      resultNoData(false, "There was a problem dismissing the feed item.");
    else
      resultNoData(true, null);      
    break;

  case "dismissReplyItem":
    $id = cleanMySQL($_POST['id']);
    $result = dismissReplyItem($id);
    if(!$result)
      resultNoData(false, "There was a problem dismissing the reply item.");
    else
      resultNoData(true, null);      
    break;

  case "getMaximumFileUploadSize":
    $data = array();
    $data['maxSize'] = getMaximumFileUploadSize();
    $data['success'] = ($data['maxSize'] > 0);
    closeDbConnection();
    echo json_encode($data);
    break;

  case "removeImage":
    $id = $_SESSION['id'];
    $firstName = $_SESSION['firstName'];
    $fileName = cleanMySQL($_POST['fileName']);
    $result = removeImage($fileName, $firstName, $id);
    if(!$result)
      resultNoData(false, "The specified file does not exist.");
    else
      resultNoData(true, null);
    break;

  case "getThumbnails":
    $id = $_SESSION['id'];
    $firstName = $_SESSION['firstName'];
    $result = getThumbnails($id, $firstName);
    if(!$result) resultNoData(false, "Could not retrieve the thumbnails.");

    $data = array();
    $data['thumbnails'] = $result;
    $data['subDirectory'] = strtolower($firstName) . "-" . $id;
    $data['success'] = true;
    closeDbConnection();
    echo json_encode($data);
    break;

    case "addReply":
      $creatorId = $_SESSION['id'];
      $feedId = cleanMySQL($_POST['feedId']);
      $message = cleanMySQL($_POST['message']);
      $result = addReply($feedId, $creatorId, $message);
      if(!$result)
        resultNoData(false, "The reply failed to save.");
      else {
        $data = array();
        $data['success'] = true;
        $data['reply'] = $result;
        closeDbConnection();
        echo json_encode($data);
      }
      break;
  default:
    $data = array();
    $data['errors'] = "The action specified was not valid.";
    $data['success'] = false;
    closeDbConnection();
    echo json_encode($data);
    return false;
}

function resultNoData($success, $message) {
  $data = array();
  $data['success'] = $success;
  $data['message'] = $message;
  closeDbConnection();
  echo json_encode($data);
  return false;
}