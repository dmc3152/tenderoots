$(document).ready(function(){
  var url = '../php/action.php';
  var formData = {
    action: "getFamily"
  };
  ajaxPost(url, formData, function(data) {
    console.log(data);
    if(data.success)
      showFamily(data.family);
  });
});

function showFamily(family) {
  var memberTypes = ['fathers', 'mothers', 'spouses', 'children'];
  for(var i in memberTypes) {
    var members = family[memberTypes[i]];
    console.log(members);
    for(var j in members) {
      var member = members[j];
      console.log(member);
      var image = member.firstName.toLowerCase()+"-"+member.id+".jpg";
      // var image;
      // if(data.uploaded)
      //   image = member.firstName.toLowerCase()+"-"+member.id+".jpg";
      // else
      //   image = "placeholder.jpg";
      var link = "<a href='#/profile?id="+member.id+"' class='member list-group-item list-group-item-action flex-column align-items-start'>" +
                    "<img class='image' src='/tenderoots/assets/profilePics/"+image+"'>" +
                    "<div class='member-info'>" +
                      "<h4 class='name'>"+member.firstName+" "+member.lastName+"</h4>" +
                    "</div>" +
                  "</a>";
      var element = "#" + memberTypes[i];
      $(element).append(link);
    }
  }
}