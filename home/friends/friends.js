function declineRequest(id, personId, requestCount) {
  var url = '../php/action.php';
  var formData = {
    id: id,
    personId: personId,
    action: "declineFriendRequest"
  };

  ajaxPost(url, formData, function(data) {
    var element = "#friend" + personId;
    if(data.success) {
      $(element).remove();
      requestCount--;
      if(requestCount !== 0)
        $("#friendRequests").html("Friend Requests (" + requestCount + ")");
      else
        $("#friendRequests").remove();
    }
  });
}

function acceptRequest(id, personId, lastName, requestCount, friendsCount) {
  var url = '../php/action.php';
  var formData = {
    id: id,
    personId: personId,
    action: "acceptFriendRequest"
  };

  ajaxPost(url, formData, function(data) {
    var element = "#friend" + personId;
    var clone = $(element).clone();
    if(data.success) {
      $(element).remove();
      requestCount--;
      if(requestCount !== 0)
        $("#friendRequests").html("Friend Requests (" + requestCount + ")");
      else
        $("#friendRequests").remove();

      clone.find(".btn").remove();
      clone.find("span").removeClass('hidden-xs');
      friendsCount++;
      $("#friends").html("Friends (" + friendsCount + ")");
      if(friendsCount === 1) {
        $('.friends-container').append(clone);
        return;
      }
      var names = $('.friends-container .friend .friend-info').children();
      var lastNames = [];
      for(var i = 0; i < names.length; i++) {
        lastNames.push(names[i].innerHTML.split(' ')[1]);
      }
      var index = 0;
      for(var name in lastNames) {
        if(lastNames[name] < lastName)
          continue;
        if(lastNames[name] >= lastName) {
          index = name;
          break;
        }
      }
      clone.insertBefore($('.friends-container .friend').get(index));
    }
  });
}