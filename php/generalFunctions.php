<?php
// require_once("../php/dbFunctions.php");
define("BASE_URL", "http://localhost/");  // website hostname

/**
 * Starts a session if none
 *
 * @return void
 */
function startSession() {
  if (session_status() == PHP_SESSION_NONE)
    session_start();
}

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

function getThumbnails($id, $firstName) {
  $sub_directory = strtolower($firstName) . "-" . $id;
  $directory = "../assets/images/$sub_directory/thumb";
  try {
    $files = scandir($directory);
    $thumbnails = array_diff($files, array('.', '..'));
  } catch(Exception $e) {
    return false;
  }
  return $thumbnails;
}

function removeImage($fileName, $firstName, $id) {
  $target_sub_directory = strtolower($firstName) . "-" . $id;
  $target_dir = "../../assets/images/$target_sub_directory/";
  $target_file = $target_dir . $fileName;

  if(file_exists($target_file))
    unlink($target_file);
  else
    return false;

  return true;
}

/**
 * Credit to CarstenSchmitz at https://stackoverflow.com/questions/13076480/php-get-actual-maximum-upload-size
* This function returns the maximum files size that can be uploaded 
* in PHP
* @returns int File size in bytes
**/
function getMaximumFileUploadSize()  
{  
    return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));  
}  

/**
 * Credit to CarstenSchmitz at https://stackoverflow.com/questions/13076480/php-get-actual-maximum-upload-size
* This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
* 
* @param string $sSize
* @return integer The value in bytes
*/
function convertPHPSizeToBytes($sSize)
{
    //
    $sSuffix = strtoupper(substr($sSize, -1));
    if (!in_array($sSuffix,array('P','T','G','M','K'))){
        return (int)$sSize;  
    } 
    $iValue = substr($sSize, 0, -1);
    switch ($sSuffix) {
        case 'P':
            $iValue *= 1024;
            // Fallthrough intended
        case 'T':
            $iValue *= 1024;
            // Fallthrough intended
        case 'G':
            $iValue *= 1024;
            // Fallthrough intended
        case 'M':
            $iValue *= 1024;
            // Fallthrough intended
        case 'K':
            $iValue *= 1024;
            break;
    }
    return (int)$iValue;
}