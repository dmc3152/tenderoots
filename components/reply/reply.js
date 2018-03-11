var feedId = 0;

function getFeedId() {
  return feedId;
}

function setFeedId(id) {
  feedId = id;
}

function reply(feedId) {
  setFeedId(feedId);
  $('#replyModal').modal({ backdrop: 'static' });
}

function closeReply() {
  $('#replyModal').modal('hide');
}

// Removes modal contents on close
$('#replyModal').on('hide.bs.modal', function (e) {
  $('#replyModal textarea').val("");
});

function submitReply() {
  var id = getFeedId();
  var message = $('#replyModal textarea').val();
  var url = "../php/action.php";
  var formData = {
    feedId: id,
    message: message,
    action: "addReply"
  };
  ajaxPost(url, formData, function(data) {
    if(!data.success) {
      alert(data.message);
      $('#replyModal').modal('hide');
      return;
    }
    addReply(data.reply, id);
    $('#replyModal').modal('hide');
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
                  "<h5 class='card-title'>"+sender.name+"</h5>" +
                  "<h6 class='card-subtitle mb-2 text-muted'>"+date+"</h6>" +
                  "<p class='card-text'>"+message+"</p>";
  for(var i in sender.links) {
    reply += sender.links[i];
  }
  reply += "</div></div>";
  var selector = "#feed-"+feedId+" .card-body .replies";
  $(selector).append(reply);
}