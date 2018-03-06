<?php

/**
 * Validates email addresses
 *
 * @param string $email
 * @return string
 */
function validateEmail($email) {
  if($email == "") return "No Email was entered.<br>";
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return "The Email is invalid.<br>";
  return "";
}

/**
 * Validates passwords
 *
 * @param string $password
 * @return string
 */
function validatePassword($password) {
  if($password == "") return "No Password was entered.<br>";
  if(strlen($password) < 6) return "Password must be at least 6 characters.<br>";
  if( !preg_match("/[a-z]/", $password) ||
      !preg_match("/[A-Z]/", $password) ||
      !preg_match("/[0-9]/", $password))
      return "Passwords require 1 each of a-z, A-Z, and 0-9.<br>";
  return "";
}

/**
 * Validates names
 *
 * @param string $name
 * @return string
 */
function validateName($name) {
  return ($name == "") ? "No Name was entered.<br>" : "";
}