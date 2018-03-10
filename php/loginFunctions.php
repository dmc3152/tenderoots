<?php

/**
 * Checks login credentials and gets user
 *
 * @param string $email
 * @param string $password
 * @return object
 */
function login($email, $password) {
  $hash = getHash($email);
  $verified = password_verify ($password, $hash);
  if(!$verified) return false;
  return getUserByEmail($email);
}

/**
 * Adds a new user to the database and returns the new user's id
 *
 * @param string $email
 * @param string $password
 * @return int
 */
function register($email, $password) {
  if(checkEmail($email)) return false;

  $hash = password_hash($password, PASSWORD_BCRYPT);
  return addUser($email, $hash);
}

/**
 * Retrieves the hashed password from the database
 *
 * @param string $email
 * @return string
 */
function getHash($email) {
  $query = "SELECT password
            FROM users
            WHERE email = '$email'";
  $result = mysqlQuery($query);
  if(!$result) return false;

  $hash = $result->fetch_assoc();
  return $hash['password'];
}

/**
 * Checks if the email address is already in the database
 *
 * @param string $email
 * @return boolean
 */
function checkEmail($email) {
  $query = "SELECT *
            FROM users
            WHERE email = '$email'";
  $result = mysqlQuery($query);
  if(!$result) return false;

  return $result->num_rows ? TRUE : FALSE;
}