// Accepted routes
var routes = ["home", "feed", "friends", "family", "search"];
var prevURL = "test";

// Load the correct page on app load
$(document).ready(function(){
  var href = window.location.hash;
  prevUrl = href;
  loadPage(href);
});

// Load the correct page when the forward or back buttons are pressed
$(window).on('popstate', function (e) {
  var href = window.location.hash;
  if(prevUrl === href) return;
  prevUrl = href;
  loadPage(href);
});

// Load the correct page
function loadPage(href) {
  if(!href) return;
  var route = href.substr(href.indexOf("#/") + 2);
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
function ajaxGet(url, callback) {
  $.ajax({
    type: 'GET',
    url: url,
    dataType: 'json'
  }).done(callback);
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

function formatDate(date) {
  var d = new Date(date);
  var hours = d.getHours();
  var minutes = d.getMinutes();
  var day = d.getDate();
  var strDay = d.getDay();
  strDay = formatStrDay(strDay);
  var month = d.getMonth();
  month = formatMonth(month);
  var year = d.getFullYear();
  var milli = d.getTime();
  var time = formatTime(hours, minutes);

  var today = new Date();
  var curMilli = today.getTime();

  milli = milli / (1000 * 60 * 60 * 24);
  curMilli = curMilli / (1000 * 60 * 60 * 24);

  if(curMilli - milli < 7)
    return time+" "+strDay+", "+month+". "+day+", "+year;
  else
    return time+" "+month+". "+day+", "+year;
}

function formatTime(hours, minutes) {
  minutes += "";
  if(minutes.length < 2)
    minutes = "0" + minutes;

  if(hours === 0)
    return "12:"+minutes+"am";

  if(hours < 12)
    return hours+":"+minutes+"am";

  if(hours === 12)
    return hours+":"+minutes+"pm";

  if(hours > 12)
    return (hours - 12)+":"+minutes+"pm";
}

function formatStrDay(day) {
  switch(day) {
    case 0:
      return "Sunday";
    case 1:
      return "Monday";
    case 2:
      return "Tuesday";
    case 3:
      return "Wednesday";
    case 4:
      return "Thursday";
    case 5:
      return "Friday";
    case 6:
      return "Saturday";
  }
}

function formatMonth(month) {
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  return months[month];
}