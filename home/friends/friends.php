<?php
require_once("../../php/generalFunctions.php");
require_once("../../php/dbFunctions.php");
startSession();
connect2db();

function sortByLastName($a, $b) {
  return $a['lastName'] <=> $b['lastName'];
}

$user = getUserDetailsById($_SESSION['id']);
$friendRequests = array();
$results = getFriendRequests($_SESSION['id']);
while($row = $results->fetch_assoc()) {
  $friendRequests[] = $row;
}
$friends = array();
$results = getFriends($_SESSION['id']);
while($row = $results->fetch_assoc()) {
  $friends[] = $row;
}
usort($friendRequests, 'sortByLastName');
usort($friends, 'sortByLastName');
?>

<link rel='stylesheet' href='./friends/friends.css'>
<script src="./friends/friends.js"></script>
<div class="row">
  <div class="col-sm-12">
    <h1>Friends and Requests</h1>
    <?php
      if(sizeof($friendRequests))
        echo "<h2 id='friendRequests'>Friend Requests (".sizeof($friendRequests).")</h2><div class='friendRequests'>";
      foreach ($friendRequests as $friend) {
        $image = strtolower($friend['firstName']) . "-" . $friend['personId'] . ".jpg";
        $target_file = "../../assets/profilePics/" . $image;
        if(!file_exists($target_file))
          $image = "placeholder.jpg";
          
        $id = $_SESSION['id'];
        $friendId = $friend['personId'];
        $firstName = $friend['firstName'];
        $lastName = $friend['lastName'];
        $bio = $friend['bio'];
        echo "<div class='friend' id='friend$friendId'>
                <img class='image' src='/tenderoots/assets/profilePics/$image'>
                <div class='friend-info'>
                  <h5 class='card-title'>
                    <a href='#/profile?id=$friendId'>$firstName $lastName</a>
                    <button class='btn btn-lg btn-danger pull-right mt-3 hidden-xs' onclick='declineRequest($id, $friendId, " . sizeof($friendRequests) . ")'>Decline</button>
                    <button class='btn btn-lg btn-success pull-right mr-1 mt-3 hidden-xs' onclick='acceptRequest($id, $friendId, \"$lastName\", " . sizeof($friendRequests) . ", " . sizeof($friends) . ")'>Accept</button>
                  </h5>
                  <span class='hidden-xs'>$bio</span>
                  <button class='btn btn-sm btn-success pull-left mr-1 visible-xs' onclick='acceptRequest($id, $friendId, \"$lastName\", " . sizeof($friendRequests) . ", " . sizeof($friends) . ")'>Accept</button>
                  <button class='btn btn-sm btn-danger pull-left visible-xs' onclick='declineRequest($id, $friendId, " . sizeof($friendRequests) . ")'>Decline</button>
                </div>
              </div>";
      }
      echo "</div>";

      if(sizeof($friends)) {
        echo "<h2 id='friends'>Friends (".sizeof($friends).")</h2>";
        echo "<div class='friends-container'>";
      } else {
        echo "<h2 id='friends'>You do not have any friends.</h2>";
        echo "<div class='friends-container'>";
      }
        foreach ($friends as $friend) {
          $image = strtolower($friend['firstName']) . "-" . $friend['friendId'] . ".jpg";
          $target_file = "../../assets/profilePics/" . $image;
          if(!file_exists($target_file))
            $image = "placeholder.jpg";
          
          $friendId = $friend['friendId'];
          $firstName = $friend['firstName'];
          $lastName = $friend['lastName'];
          $bio = $friend['bio'];
          echo "<div class='friend' id='friend$friendId'>
                  <img class='image' src='/tenderoots/assets/profilePics/$image'>
                  <div class='friend-info'>
                    <h5 class='card-title'><a href='$/profile?id=$friendId'>$firstName $lastName</a></h5>
                    $bio
                  </div>
                </div>";
        }
        if(sizeof($friends))
          echo "</div>";
      ?>
  </div>
</div>

<?php closeDbConnection(); ?>