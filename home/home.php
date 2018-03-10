<?php
require_once("../php/generalFunctions.php");
require_once("../php/dbFunctions.php");
startSession();
connect2db();
if(!isSignedIn()) sendToLogin();

$user = getUserDetailsById($_SESSION['id']);
?>
<div class="col-sm-12">
  <h1>Profile</h1>
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <?php include_once('../components/profilePic/profilePic.php') ?>
      <?php include_once('../components/galleryUpload/galleryUpload.php') ?>
  </div>
    <div class="col-sm-12 col-md-8">
    <form>
      <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $user['firstName']; ?>">
        <small id="firstNameHelp" class="form-text text-muted">Please enter your first name.</small>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $user['lastName']; ?>">
        <small id="lastNameHelp" class="form-text text-muted">Please enter your last name.</small>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="form-group">
        <label for="middleNames">Middle Names</label>
        <input type="text" class="form-control" id="middleNames" name="middleNames" placeholder="Middle Names" value="<?php echo $user['middleNames']; ?>">
        <small id="middleNamesHelp" class="form-text text-muted">Please enter any middle names.</small>
      </div>
    </div>
    <div class="col-sm-5">
      <div class="form-group">
        <label for="birthday">Birthday</label>
        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="mm/dd/yyyy" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" value="<?php echo $user['birthday']; ?>">
        <small id="birthdayHelp" class="form-text text-muted">Please use the following format: mm/dd/yyyy</small>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <label for="bio">Tell us a little about yourself</label>
        <textarea class="form-control" id="bio" name="bio" rows="5" maxlength="500" value="<?php echo $user['bio']; ?>"></textarea>
        <small id="bioHelp" class="form-text text-muted">Used <span id='charCount'>0</span> out of 500 characters.</small>
      </div>
    </div>
</div>
  </form>
</div>
  </div>
</div>
<script src="home.js"></script>

<?php closeDbConnection(); ?>