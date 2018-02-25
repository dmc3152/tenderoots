<?php
session_start();

// Skip log in if the user is already logged in
if(isset($_SESSION['id'])) {
  header("Location: http://localhost/tenderoots/home/index.php");
  exit();
}

// Get necessary files
require_once("php/dbFunctions.php");
require_once("php/loginFunctions.php");

// Connect to the database
connect2db();

// Log in if the form has been submitted
if(isset($_POST['email'])) {
  $email = cleanMySQL($_POST['email']);
  $password = cleanMySQL($_POST['password']);

  $user = login($email, $password);

  if($user) {
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['lastName'] = $user['lastName'];
    $_SESSION['id'] = $user['personId'];
    header("Location: http://localhost/tenderoots/home/index.php");
    exit();
  } else {
    $error = true;
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
  <form class='form-signin' action='index.php' method='POST'>
      <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" <?php if($email) echo "value='$email'"; ?> required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" <?php if($password) echo "value='$password'"; ?> required>
      <?php
        if($error) {
          echo "<div class='form-text danger'>
                  Your username or password is incorrect
                </div>";
        }
      ?>
      <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Sign in</button>
      <label class="mt-3"><a href="register.php">Click here to register</a></label>
      <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
  </body>
</html>

<?php closeDbConnection(); ?>

