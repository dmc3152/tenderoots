<?php
session_start();
require_once("php/dbFunctions.php");
require_once("php/loginFunctions.php");
connect2db();

if(isset($_POST['email'])) {
  require_once("php/validation.php");

  // Sanitize inputs
  $email = cleanMySQL($_POST['email']);
  $password = cleanMySQL($_POST['password']);
  $password2 = cleanMySQL($_POST['password2']);
  $firstName = cleanMySQL($_POST['firstName']);
  $lastName = cleanMySQL($_POST['lastName']);

  // Capitalize names
  $firstName = ucwords($firstName);
  $lastName = ucwords($lastName);

  // Validate inputs
  $emailError = validateEmail($email);
  $passwordError .= validatePassword($password);
  $passwordError .= ($password === $password2) ? "" : "The passwords do not match.<br>";
  $nameError .= validateName($firstName);
  $nameError .= validateName($lastName);
  
  // Add user to database
  if(($emailError == "") && ($passwordError == "") && ($nameError == "")) {
    $userId = register($email, $password);
    if(!$userId) {
      global $con;
      $userError = $con->error ? $con->error : "The email address is already in use.<br>";
    }
  }
  
  // Add user details to database
  if($userId) {
    $detailsError = addPerson("USR", $userId, $firstName, $lastName);
    if($detailsError) {
      removeUserById($userId);  // removes user so it can be added later
    }
  }

  // Save variables and redirect to website
  if(!$detailsError) {
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['id'] = $userId;
    header("Location: http://localhost/tenderoots/home/index.php");
    exit();
  }
}
?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tenderoots</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
</head>
<body class="text-center">
  <form class='form-register' action='register.php' method='POST'>
    <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please register</h1>
    <!-- Email -->
    <div class="form-group">
      <label for="inputEmail">Email address</label>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" <?php if($email) echo "value='$email'"; ?> required autofocus>
      <?php
        if($emailError) {
          echo "<small id='emailHelpBlock' class='form-text danger'>
                  $emailError
                </small>";
        }
      ?>
    </div>
    <!-- Password -->
    <div class="form-group">
      <label for="inputPassword">Password</label>
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" <?php if($password) echo "value='$password'"; ?> required>
      <label for="inputPassword2" class="sr-only">Confirm Password</label>
      <input type="password" id="inputPassword2" name="password2" class="form-control" placeholder="Confirm Password" <?php if($password2) echo "value='$password2'"; ?> required>
      <?php
        if($passwordError) {
          echo "<small id='passwordHelpBlock' class='form-text danger'>
                  $passwordError
                </small>";
        }
      ?>
    </div>
    <!-- Name -->
    <div class="form-group">
      <label for="inputFirstName">Name</label>
      <input type="text" id="inputFirstName" name="firstName" class="form-control" placeholder="First Name" <?php if($firstName) echo "value='$firstName'"; ?> required>
      <label for="inputLastName" class="sr-only">Last Name</label>
      <input type="text" id="inputLastName" name="lastName" class="form-control" placeholder="Last Name" <?php if($lastName) echo "value='$lastName'"; ?> required>
      <?php
        if($nameError) {
          echo "<small id='nameHelpBlock' class='form-text danger'>
                  $nameError
                </small>";
        }
      ?>
    </div>

    <?php
      if($userError || $detailsError) {
        echo "<div id='formHelpBlock' class='form-text danger'>
                $userError
                $detailsError
              </div>";
      }
    ?>

    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Register</button>
      <label class="mt-3"><a href="index.php">Click here to sign in</a></label>
    <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
  </form>
</body>
</html>

<?php closeDbConnection(); ?>

