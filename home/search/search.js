$("#searchForm").submit(function(e) {
  var value = $('#searchForm input[name="searchInput"]').val();
  var url = '../php/action.php';
  var formData = {
    value: value,
    action: "searchUsers"
  };
  ajaxPost(url, formData, function(data) {
    $("#results").empty();
    if(data.success && data.results.length > 0) {
      $("#resultsHeader").html("Results (" + data.results.length + ")");
      for(var i in data.results) {
        showResult(data.results[i], data.id, data.results.length);
      }
    } else {
      $("#resultsHeader").html("There are no users to display");
    }
  });
  e.preventDefault();
});

function showResult(data, id, count) {
  var userId = "user" + data.id;
  var user =  "<div class='friend' id='" + userId + "'>" +
                "<img class='image' src='" + data.profilePic + "'>"+
                "<button class='btn btn-lg btn-success pull-right hidden-xs' onclick='sendFriendRequest("+id+", "+data.id+", "+userId+", "+count+")'>Add Friend</button>" +
                "<div class='friend-info'>" +
                  "<h5 class='card-title'>" + data.firstName + " " + data.lastName + "</h5>" +
                  "<span class='hidden-xs'>" + data.bio + "</span>" +
                  "<button class='btn btn-sm btn-success pull-left mr-1 visible-xs' onclick='sendFriendRequest("+id+", "+data.id+", "+userId+", "+count+")'>Add Friend</button>" +
                "</div>" +
              "</div>";
  $("#results").append(user);
}

function sendFriendRequest(id, userId, elementId, count) {
  console.log(id, userId);
  var url = '../php/action.php';
  var formData = {
    id: id,
    personId: userId,
    action: "addFriendRequest"
  };

  ajaxPost(url, formData, function(data) {
    console.log(data);
    if(data.success) {
      $(elementId).remove();
      count--;
      if(count !== 0)
        $("#resultsHeader").html("Results (" + count + ")");
      else
        $("#resultsHeader").remove();
    }
  });
}