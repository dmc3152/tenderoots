function clickHiddenInput($enable) {
  if($enable)
    $('#hiddenFileInput').click();
}

$('#hiddenFileInput').on('click touchstart' , function(){
  $(this).val('');
});

$("#hiddenFileInput").change(function(e) {
  var file = $(this)[0].files[0];
  if(!file.type.match(/^image\/(gif|png|jpeg)$/i)) {
    alert("The file " + file.name + " is not a valid image. Please choose a gif, png, or jpg");
    return false;
  }
  var form = $('#picUploadForm')[0];
  var data = new FormData(form);
  var url = '/tenderoots/components/profilePic/fileUpload.php';
  uploadFile(url, data, function(data) {
    if(data.success) {
      var d = new Date();
      $("#profilePic").attr("src", "/tenderoots/assets/profilePics/" + data.fileName +"?"+d.getTime());
    } else {
      console.log(data.errors);
    }
  });
  // console.log($(this).val());
});