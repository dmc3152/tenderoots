<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/tenderoots/php/generalFunctions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/tenderoots/php/dbFunctions.php");
if(!isset($_GET['id']) && !isset($_SESSION['profileId'])) sendHome();
startSession();
connect2db();

if(isset($_GET['id'])) 
  $id = cleanMySQL($_GET['id']);
else
  $id = $_SESSION['profileId'];

$_SESSION['feed'] = $id;

$user = getProfileById($id);
if(!$user) {
  echo "<h2>There is no user with the given ID.</h2>";
  return;
}
$_SESSION['feedName'] = $user['firstName'];
$editProfilePic = false;
?>

<link rel='stylesheet' href='./profile/profile.css'>
<script src="./profile/profile.js"></script>
<div class="col-sm-12">
  <h1><?php echo $user['firstName'] . " " . $user['lastName']; ?></h1>
  <div class="col-xs-4 pictures readOnly">
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/tenderoots/components/profilePic/profilePic.php') ?>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/tenderoots/components/gallery/gallery.php') ?>
  </div>
  <form>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group row">
          <label class="col-sm-5 col-form-label" for="firstName">First Name</label>
          <div class="col-sm-7">
            <input type="text" class="form-control-plaintext" readonly id="firstName" name="firstName" value="<?php echo $user['firstName']; ?>">
          </div>
          <label class="col-sm-5 col-form-label" for="lastName">Last Name</label>
          <div class="col-sm-7">
            <input type="text" class="form-control-plaintext" readonly id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>">
          </div>
          <label class="col-sm-5 col-form-label" for="middleNames">Middle Names</label>
          <div class="col-sm-7">
            <input type="text" class="form-control-plaintext" readonly id="middleNames" name="middleNames" value="<?php echo $user['middleNames']; ?>">
          </div>
          <label class="col-sm-5 col-form-label" for="birthday">Birthday</label>
          <div class="col-sm-7">
            <input type="date" class="form-control-plaintext" readonly id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>">
          </div>
          <?php
          if(isset($user['deathDate'])) {
            echo "<label class='col-sm-5 col-form-label' for='deathDate'>Death Date</label>
                  <div class='col-sm-7'>
                    <input type='date' class='form-control-plaintext' readonly id='deathDate' name='deathDate' value='".$user['deathDate']."'>
                  </div>";
          }
          ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 col-form-label" for="bio">Bio</label>
        <div class="col-sm-12">
          <?php echo $user['bio']; ?>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="clear"></div>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/tenderoots/home/feed/feed.php') ?>