function clickHiddenInput() {
  $('#hiddenFileInput').click();
}

$('#hiddenFileInput').on('click touchstart' , function(){
  $(this).val('');
});

$("#hiddenFileInput").change(function(e) {
  var fileName = $(this).val().toLowerCase();
  var ext = fileName.slice(-3, fileName.length);
  if(ext != 'jpg') {
    console.log("The file " + fileName + " is not a valid image.");
    console.log(ext);
    return false;
  }
  var form = $('#picUploadForm')[0];
  var data = new FormData(form);
  var url = '/tenderoots/components/profilePic/fileUpload.php';
  uploadFile(url, data, function(data) {
    console.log(data);
    if(data.success) {
      var d = new Date();
      $("#profilePic").attr("src", "/tenderoots/assets/profilePics/" + data.fileName +"?"+d.getTime());
    } else {
      console.log(data.errors);
    }
  });
  // console.log($(this).val());
});