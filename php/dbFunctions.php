<?php

/**
 * Connect to database
 *
 * @return void
 */
function connect2db() {
  // Database variables
  $dbhost = 'localhost';    // Database host
  $dbname = 'tenderoots';    // Database
  $dbuser = 'tr_user'; // Database user
  $dbpasswd = '!7uf6Xo*ZzefluJu';   // Database user password
  global $con;

  // Creating connection to the database
  $con = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
  if ($con->connect_error) die($con->connect_error);
}

/**
 * Closes database connection
 *
 * @return void
 */
function closeDbConnection() {
  global $con;
  $con->close();
}

/**
 * Cleans/protects site from user inputs
 *
 * @param string $str
 * @return string
 */
function cleanString($str) {
  $str = stripslashes($str);
  $str = strip_tags($str);
  $str = htmlentities($str);
  return $str;
}

/**
 * Cleans/protects datbase from user inputs
 *
 * @param string $str
 * @return string
 */
function cleanMySQL($str) {
  global $con;
  $str = $con->real_escape_string($str);
  $str = cleanString($str);
  return $str;
}

/**
 * Helper functin to execute mySQL queries
 *
 * @param string $query
 * @return object
 */
function mysqlQuery($query) {
  global $con;
  return $con->query($query);
}

/**
 * Gets a user by their id
 *
 * @param int $id
 * @return object
 */
function getUserById($id) {
  $query = "SELECT personPrefix, personId, firstName, lastName
            FROM `person_details`
            JOIN users
            ON users.id = person_details.personId
            WHERE person_details.personPrefix = 'USR'
            AND person_details.personId = $id";
  $result = mysqlQuery($query);
  if(!$result) return false;
  return $result->fetch_assoc();
}

/**
 * Gets a user by their email
 *
 * @param string $email
 * @return object
 */
function getUserByEmail($email) {
  $query = "SELECT personPrefix, personId, firstName, lastName
            FROM `person_details`
            JOIN users
            ON users.id = person_details.personId
            WHERE person_details.personPrefix = 'USR'
            AND users.email = '$email'";
  $result = mysqlQuery($query);
  if(!$result) return false;
  return $result->fetch_assoc();
}

/**
 * Adds a user to the database and returns the id of the user
 *
 * @param string $email
 * @param string $hash
 * @return int
 */
function addUser($email, $hash) {
  global $con;
  $stmt = $con->prepare("INSERT INTO users(email, password) VALUES(?,?)");
  $stmt->bind_param('ss', $email, $hash);
  $stmt->execute();
  $stmt->close();
  return $con->insert_id;
}

/**
 * Deletes a user from the database by id
 *
 * @param int $id
 * @return boolean
 */
function removeUserById($id) {
  $query = "DELETE FROM `users`
            WHERE id = $id";
  return mysqlQuery($query);
}

/**
 * Adds the details of a new person
 *
 * @param string $prefix
 * @param int $id
 * @param string $firstName
 * @param string $lastName
 * @return int
 */
function addPerson($prefix, $id, $firstName, $lastName) {
  global $con;
  $stmt = $con->prepare("INSERT INTO person_details(personPrefix, personId, firstName, lastName) VALUES(?,?,?,?)");
  $stmt->bind_param('siss', $prefix, $id, $firstName, $lastName);
  $stmt->execute();
  $stmt->close();
  return $con->error;
}