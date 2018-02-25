<?php
session_start();

echo $_SESSION['id'] . "<br>";
echo $_SESSION['firstName'] . "<br>";
echo $_SESSION['lastName'] . "<br>";

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>

<html>
  <h1>IT WORKED!</h1>
</html>