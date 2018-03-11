var memberType = "";

function getMemberType() {
  return memberType;
}

function setMemberType(value) {
  memberType = value;
}

function openRelativeModal(memberType) {
  setMemberType(memberType);
  $('#relativeModal').modal({ backdrop: 'static' });
  $('#bio').on("input", setCount);
  $('#firstName').on("input", validateName);
  $('#lastName').on("input", validateName);
  $('input[type="date"]').on("input", validateDate);
  $("#profilePic").change(validateImage);
}

function closeRelativeModal() {
  $('#bio').off("input", setCount);
  $('#relativeModal').modal('hide');
}

function setCount(event) {
  var element = $(event.target);
  var count = element.val().length;
  $('#charCount').html(count);
}

function validateImage(e) {
  var file = $(this)[0].files[0];
  if(!file.type.match(/^image\/(gif|png|jpeg)$/i)) {
    var error = file.name + " is not a gif, png, or jpg.";
    $('#profilePicHelp').html(error);
    $('#profilePicHelp').removeClass('text-muted');
    $('#profilePicHelp').addClass('error');
    $('#profilePic').addClass('is-invalid');
    $('#submitButton').prop('disabled', true);
  } else {
    var message = "Only gif, png, and jpg file types are allowed.";
    $('#submitButton').prop('disabled', false);
    $('#profilePicHelp').addClass('text-muted');
    $('#profilePicHelp').removeClass('error');
    $('#profilePic').removeClass('is-invalid');
    $('#profilePicHelp').html(message);
  }
}

function validateDate() {
  var date = $(this).val();
  if(date.match(/^[0-1][0-9]\/[0-3][0-9]\/[1-2][0-9][0-9][0-9]$/)) {
    var error = "Please enter a valid date.";
    $(this).addClass('is-invalid');
    $(this).next().removeClass('text-muted');
    $(this).next().addClass('error');
    $(this).next().html(error);
    $('#submitButton').prop('disabled', true);
  } else {
    $(this).removeClass('is-invalid');
    $(this).next().addClass('text-muted');
    $(this).next().removeClass('error');
    $('#submitButton').prop('disabled', false);
  }
}

function validateName() {
  var name = $(this).val();
  if(name.indexOf(" ") !== -1) {
    var error = "Please remove any spaces.";
    $(this).addClass('is-invalid');
    $(this).next().removeClass('text-muted');
    $(this).next().addClass('error');
    $(this).next().html(error);
    $('#submitButton').prop('disabled', true);
  } else {
    $(this).removeClass('is-invalid');
    $(this).next().addClass('text-muted');
    $(this).next().removeClass('error');
    $('#submitButton').prop('disabled', false);
  }
}

function addRelative() {
  if(relativeForm.firstName.value === "" || relativeForm.lastName.value === "") {
    var error = "This field is required";
    $("#firstName, #lastName").addClass('is-invalid');
    $("#firstName, #lastName").next().removeClass('text-muted');
    $("#firstName, #lastName").next().addClass('error');
    $("#firstName, #lastName").next().html(error);
    $('#submitButton').prop('disabled', true);
    return false;
  }
  var form = $('#relativeForm')[0];
  var data = new FormData(form);
  data.append('memberType', getMemberType());
  var url = '/tenderoots/components/relativeModal/formUpload.php';
  console.log(data, form);
  uploadFile(url, data, function(data) {
    console.log(data);
    if(data.success) {
      var image;
      if(data.uploaded)
        image = data.firstName.toLowerCase()+"-"+data.id+".jpg";
      else
        image = "placeholder.jpg";
      var link = "<a href='#/profile?id="+data.id+"' class='member list-group-item list-group-item-action flex-column align-items-start'>" +
                    "<img class='image' src='/tenderoots/assets/profilePics/"+image+"'>" +
                    "<div class='member-info'>" +
                      "<h4 class='name'>"+data.firstName+" "+data.lastName+"</h4>" +
                    "</div>" +
                  "</a>";
      var element = "#" + getMemberType();
      $(element).append(link);
      closeRelativeModal();
    } else {
      alert(data.errors);
    }
  });
}