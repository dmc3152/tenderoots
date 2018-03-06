// Accepted routes
var routes = ["home", "settings", "draw", "stickyNotes"];

// Load the correct page on app load
$(document).ready(function(){
  var href = window.location.hash;
  loadPage(href);
});

// Load the correct page when the forward or back buttons are pressed
$(window).on('popstate', function (e) {
  var href = window.location.hash;
  loadPage(href);
});

// Load the correct page
function loadPage(href) {
  if(href.indexOf("http") !== -1) href = "#/home";
  var route = href.replace("#/", "");
  if(!routes.includes(route))
      window.location.href="#/home";
  var url = route + "/" + route + ".php";
  if(route === "home")
      url = "home.php";

  $.ajax({url: url, success: function(result){
      $("#content").html(result);
      $('.nav-item').removeClass("active");
      $('a[href="'+href+'"]').parent().addClass("active");
  }});
}

// Signs out the user
function signOut() {
  var url = '../php/action.php';
  var formData = { action: "signOut" };

  ajaxPost(url, formData, function(data) {
    if(data.success)
      window.location.href = "http://regis-dev/tenderoots/";
  });
}

// Helper function to make post ajax calls
function ajaxPost(url, data, callback) {
  $.ajax({
    type: 'POST',
    url: url,
    data: data,
    dataType: 'json'
  }).done(callback);
}

function uploadFile(url, data, callback) {
  $.ajax({
    type: 'POST',
    enctype: 'multipart/form-data',
    url: url,
    data: data,
    processData: false,
    contentType: false,
    cache: false,
    dataType: 'json'
  }).done(callback);
}