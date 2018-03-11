<?php

/**
 * Connect to database
 *
 * @return void
 */
function connect2db() {
  global $con;
  // Database variables
  $dbhost = 'localhost';    // Database host
  $dbname = 'tenderoots';    // Database
  $dbuser = 'tr_user'; // Database user
  $dbpasswd = '!7uf6Xo*ZzefluJu';   // Database user password

  // Creating connection to the database
  if (!$con || !$con->ping()) {
    $con = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
    if ($con->connect_error) die($con->connect_error);
  }
}

/**
 * Checks for a connection. Creates connection if none.
 *
 * @return void
 */
function checkConnection() {
  global $con;
  if (!$con->ping()) {
    connect2db();
  }
}

/**
 * Closes database connection
 *
 * @return void
 */
function closeDbConnection() {
  global $con;
  if ($con && $con->ping()) {
    $con->close();
  };
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
 * Helper function to execute mySQL queries
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
 * Gets user details by the user's by their id
 *
 * @param int $id
 * @return object
 */
function getUserDetailsById($id) {
  $query = "SELECT *
            FROM `person_details`
            WHERE id = $id";
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
  $query = "SELECT personPrefix, person_details.id as id, firstName, lastName
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
  return $con->insert_id;
}

/**
 * Updates fields in any table
 *
 * @param array $update
 * @param string $conditionField
 * @param string $condition
 * @param string $table
 * @return object
 */
function updateFields($update, $conditionField, $condition, $table) {
  $iterations = count($update);
  $updateString = "";
  $i = 0;
  foreach ($update as $key => $value) {
    $updateString .= $key . "='" . $value . "'";
    if($i < $iterations - 1)
      $updateString .= ", ";
    $i++;
  }
  $query = "UPDATE $table
            SET $updateString
            WHERE $conditionField = $condition";
  return mysqlQuery($query);
}

/**
 * Get all friend requests for a user by Id
 *
 * @param int $id
 * @return object
 */
function getFriendRequests($id) {
  $query = "SELECT *
            FROM friends
            JOIN person_details
            ON friends.personId = person_details.personId
            WHERE friends.friendId = $id
            AND friends.accepted = 0";
  $result = mysqlQuery($query);
  if(!$result) return false;
  return $result;
}

/**
 * Get all friends for a user by Id
 *
 * @param int $id
 * @return object
 */
function getFriends($id) {
  $query = "SELECT (CASE WHEN pdl.personId = '$id' THEN pdr.personId ELSE pdl.personId END) AS friendId,
            (CASE WHEN pdl.personId = '$id' THEN pdr.firstName ELSE pdl.firstName END) AS firstName,
            (CASE WHEN pdl.personId = '$id' THEN pdr.lastName ELSE pdl.lastName END) AS lastName,
            (CASE WHEN pdl.personId = '$id' THEN pdr.bio ELSE pdl.bio END) AS bio
            FROM friends
            JOIN person_details pdl
            ON friends.personId = pdl.personId
            JOIN person_details pdr
            ON friends.friendId = pdr.personId
            WHERE (friends.friendId = '$id' OR friends.personId = '$id')
            AND friends.accepted = 1";
  $result = mysqlQuery($query);
  if(!$result) return false;
  return $result;
}

/**
 * Declines a friend request
 *
 * @param int $id
 * @param int $personId
 * @return object
 */
function declineFriendRequest($id, $personId) {
  $query = "DELETE FROM friends
            WHERE personId = $personId
            AND friendId = $id";
  return mysqlQuery($query);
}

/**
 * Accepts a friend request
 *
 * @param int $id
 * @param int $personId
 * @return object
 */
function acceptFriendRequest($id, $personId) {
  $query = "UPDATE friends
            SET accepted = 1
            WHERE personId = $personId
            AND friendId = $id";
  return mysqlQuery($query);
}

/**
 * Searches all users for new friends
 *
 * @param int $id
 * @param string $search
 * @return object
 */
function searchUsers($id, $search) {
  if(strpos($search, " ")) {
    $split = explode(" ", $search);
    $firstName = $split[0];
    $lastName = $split[1];
  } else {
    $firstName = $search;
    $lastName = $search;
  }
  $query = "SELECT *
            FROM person_details
            WHERE (firstName LIKE '%$search%'OR lastName LIKE '%$search%'
            OR (firstName LIKE '%$firstName%' AND lastName LIKE '%$lastName%'))
            AND personId != $id";
  $result = mysqlQuery($query);
  if(!$result) return false;

  $people = array();
  while($row = $result->fetch_assoc()) {
    $people[] = $row;
  }

  $query = "SELECT (CASE WHEN personId = '$id' THEN friendId ELSE personId END) AS id
            FROM friends
            WHERE (friendId = '$id' OR personId = '$id')";
  $result = mysqlQuery($query);
  if(!$result) return false;

  $friends = array();
  while($row = $result->fetch_assoc()) {
    $friends[] = $row['id'];
  }

  $found = array();
  foreach ($people as $person) {
    if(!in_array($person['id'], $friends)) {
      $image = strtolower($person['firstName']) . "-" . $person['id'] . ".jpg";
      $target_file = "../assets/profilePics/" . $image;
      if(!file_exists($target_file))
        $target_file = "../assets/profilePics/placeholder.jpg";
      $person['profilePic'] = $target_file;
      $found[] = $person;
    }
  }

  function sortByLastName($a, $b) {
    return $a['lastName'] <=> $b['lastName'];
  }
  usort($found, 'sortByLastName');

  return $found;
}

/**
 * Creates a friend request
 *
 * @param string $prefix
 * @param int $id
 * @param string $firstName
 * @param string $lastName
 * @return int
 */
function addFriendRequest($id, $friendId) {
  global $con;
  $stmt = $con->prepare("INSERT INTO friends(personId, friendId) VALUES(?,?)");
  $stmt->bind_param('ii', $id, $friendId);
  $stmt->execute();
  $stmt->close();

  $message = "You have a new friend request!";
  return addMessageToFeed(-1, $friendId, $message);
}

/**
 * Adds a message to a user's feed
 *
 * @param int $creatorId
 * @param int $receiverId
 * @param string $message
 * @return int
 */
function addMessageToFeed($creatorId, $receiverId, $message) {
  global $con;
  $stmt = $con->prepare("INSERT INTO feed(creatorId, receiverId, message) VALUES(?,?,?)");
  $stmt->bind_param('iis', $creatorId, $receiverId, $message);
  $stmt->execute();
  $stmt->close();
  return $con->insert_id;
}

/**
 * Gets the feed for the specified id
 *
 * @param int $id
 * @return array
 */
function getFeed($id) {
  $query = "SELECT *
            FROM feed
            WHERE receiverId = $id
            AND seen = 0";
  $result = mysqlQuery($query);
  if(!$result) return -1;

  $feed = array();
  while($row = $result->fetch_assoc()) {
    $feedId = $row['id'];
    $query2 = "SELECT *
               FROM replies
               WHERE feedId = $feedId
               AND seen = 0";
    $result2 = mysqlQuery($query2);
    $replies = array();
    while($row2 = $result2->fetch_assoc()) {
      $replies[] = $row2;
    }
    $row['replies'] = $replies;
    $feed[] = $row;
  }

  return $feed;
}

/**
 * Marks a feed item as seen
 *
 * @param int $id
 * @return int
 */
function dismissFeedItem($id) {
  $query = "UPDATE feed
            SET seen = 1
            WHERE id = $id";
  return mysqlQuery($query);
}

/**
 * Marks a reply item as seen
 *
 * @param int $id
 * @return int
 */
function dismissReplyItem($id) {
  $query = "UPDATE replies
            SET seen = 1
            WHERE id = $id";
  return mysqlQuery($query);
}

/**
 * Adds a reply to a feed
 *
 * @param int $feedId
 * @param int $creatorId
 * @param int $message
 * @return object
 */
function addReply($feedId, $creatorId, $message) {
  global $con;
  $stmt = $con->prepare("INSERT INTO replies(feedId, creatorId, message) VALUES(?,?,?)");
  $stmt->bind_param('iis', $feedId, $creatorId, $message);
  $stmt->execute();
  $stmt->close();
  $replyId = $con->insert_id;

  $query = "SELECT *
            FROM replies
            WHERE id = $replyId";
  $result = mysqlQuery($query);
  if(!$result) return false;
  return $result->fetch_assoc();
}