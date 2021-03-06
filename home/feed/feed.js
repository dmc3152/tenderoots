$(document).ready(function(){
  var url = '../php/action.php';
  var formData = {
    action: "getFeed"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) return;
    var feed = data.feed;
    if(feed.length < 1)
      $('#messages').append("<h3>There are no messages to display.</h3>");
    for(var i in feed)
      addMessage(feed[i]);
  });
});

function addMessage(feed) {
  var senderId = feed.creatorId;
  var feedId = feed.id;
  if(senderId < 0) {
    var sender = getSystemFeedData(senderId, feedId);
    showFeedMessage(sender, feed.creationDate, feed.message, feedId);
    var replies = feed.replies;
    for(var i in replies) {
      addReply(replies[i], feedId);
    }
  }

  var url = '../php/action.php';
  var formData = {
    id: senderId,
    action: "getUserById"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) return;
    var image = data.user.firstName.toLowerCase() + "-" + data.user.personId + ".jpg";
    var sender = {
      id: data.user.personId,
      name: data.user.firstName + " " + data.user.lastName,
      image: "/tenderoots/assets/profilePics/" + image,
      links: [
        "<a href='#/feed' onclick='reply("+feedId+")' class='card-link'>Reply</a>",
        "<a href='#/feed' onclick='dismiss("+feedId+")' class='card-link'>Dismiss</a>"
      ]
    };
    showFeedMessage(sender, feed.creationDate, feed.message, feedId);
    var replies = feed.replies;
    for(var i in replies) {
      addReply(replies[i], feedId);
    }
  });
}

function getSystemFeedData(senderId, feedId) {
  var data;
  switch(senderId) {
    case "-1":
      data = {
        name: "Tenderoots",
        image: "/tenderoots/assets/images/roots-logo.png",
        links: [
          "<a href='#/friends' class='card-link'>Go to friend request</a>",
          "<a href='#/feed' onclick='dismiss("+feedId+")' class='card-link'>Dismiss</a>"
        ]
      };
      return data;
    default:
      data = {
        name: "Tenderoots",
        image: "/tenderoots/assets/images/roots-logo.png",
        links: [
          "<a href='#/feed' onclick='dismiss("+feedId+")' class='card-link'>Dismiss</a>"
        ]
      };
      return data;
  }
}

function showFeedMessage(sender, date, message, feedId) {
  date = formatDate(date);
  var title = "";
  if(sender.id > 0)
    title = "<a href='#/profile?id="+sender.id+"'>"+sender.name+"</a>";
  else
    title = sender.name;
  var card = "<div id='feed-"+feedId+"' class='card'>" +
                "<img class='feed-img' src='"+sender.image+"'>" +
                "<div class='card-body'>" +
                  "<h5 class='card-title'>"+title+"</h5>" +
                  "<h6 class='card-subtitle mb-2 text-muted'>"+date+"</h6>" +
                  "<p class='card-text'>"+message+"</p>";
  for(var i in sender.links) {
    card += sender.links[i];
  }
  card += "<div class='replies'></div>";
  card += "</div></div>";
  $('#messages').append(card);
}

function dismiss(feedId) {
  var url = '../php/action.php';
  var formData = {
    id: feedId,
    action: "dismissFeedItem"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) return;
    var element = "#feed-" + feedId;
    $(element).remove();
  });
}

function addReply(reply, feedId) {
  var senderId = reply.creatorId;
  var replyId = reply.id;
  if(senderId < 0) {
    var sender = getSystemFeedData(senderId, replyId);
    showReplyMessage(sender, reply.creationDate, reply.message, feedId, replyId);
  }

  var url = '../php/action.php';
  var formData = {
    id: senderId,
    action: "getUserById"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) return;
    var image = data.user.firstName.toLowerCase() + "-" + data.user.personId + ".jpg";
    var sender = {
      id: data.user.personId,
      name: data.user.firstName + " " + data.user.lastName,
      image: "/tenderoots/assets/profilePics/" + image,
      links: [
        "<a href='#/feed' onclick='reply("+feedId+")' class='card-link'>Reply</a>",
        "<a href='#/feed' onclick='dismissReply("+replyId+")' class='card-link'>Dismiss</a>"
      ]
    };
    showReplyMessage(sender, reply.creationDate, reply.message, feedId, replyId);
  });
}

function showReplyMessage(sender, date, message, feedId, replyId) {
  date = formatDate(date);
  var reply = "<div id='reply-"+replyId+"' class='card'>" +
                "<img class='reply-img' src='"+sender.image+"'>" +
                "<div class='card-body'>" +
                  "<h5 class='card-title'><a href='#/profile?id="+sender.id+"'>"+sender.name+"</a></h5>" +
                  "<h6 class='card-subtitle mb-2 text-muted'>"+date+"</h6>" +
                  "<p class='card-text'>"+message+"</p>";
  for(var i in sender.links) {
    reply += sender.links[i];
  }
  reply += "</div></div>";
  var selector = "#feed-"+feedId+" .card-body .replies";
  $(selector).append(reply);
}

function dismissReply(replyId) {
  var url = '../php/action.php';
  var formData = {
    id: replyId,
    action: "dismissReplyItem"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) return;
    var element = "#reply-" + replyId;
    $(element).remove();
  });
}