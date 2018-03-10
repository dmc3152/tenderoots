var maxSize = 0;

$(document).ready(function(){
  var url = "../php/action.php";
  var formData = {
    action: "getMaximumFileUploadSize"
  };
  
  ajaxPost(url, formData, function(data) {
    if(data.success)
      maxSize = data.maxSize;
    else
      alert("Could not retrive the max size.");
  });
});

$("#galleryInput").change(function(e) {
  $('.gallery-upload-component form small').remove();
  $('.gallery-upload-component form button').remove();
  $('.gallery-upload-component .files').empty();
  $('.gallery-upload-component .files').append("<ul></ul>");
  var files = $(this)[0].files;
  $('.gallery-upload-component .files').prepend('<h4>Files to Upload</h4>');
  var error = "";
  var size = 0;
  for(var i = 0; i < files.length; i++) {
    size += files[i].size;
    var errorClass = "";
    var ext = files[i].name.substring(files[i].name.lastIndexOf(".") + 1);
    if(!files[i].type.match(/^image\/(gif|png|jpeg)$/i)) {
      errorClass = " class='error'";
      error += files[i].name + " is not a gif, png, or jpg.<br>";
    }
    $('.gallery-upload-component .files > ul').append('<li'+errorClass+'>'+files[i].name+'</li>');
  }
  if(size > maxSize) {
    var readableSize = convertByteSize(size);
    error += "The files' size ("+readableSize+") exceeds the maximum upload limit.";
  }
  if(error)
    $('.gallery-upload-component form').append('<small class="form-text error">'+error+'</small>');
  else
    $('.gallery-upload-component form').append('<button type="button" class="btn btn-success" onclick="galleryUpload()">Upload</button>');
});

function galleryUpload() {
  console.log("Clicked the button!");
  var form = $('#galleryUploadForm')[0];
  var data = new FormData(form);
  var url = '/tenderoots/components/galleryUpload/fileUpload.php';
  uploadFile(url, data, function(data) {
    if(data.success) {
      console.log("Images Uploaded Successfully!!");
    } else {
      alert(data.error);
    }
  });
}

function convertByteSize(bytes) {
  if (bytes > (1024*1024*1024))
    return (bytes/(1024*1024)).toFixed(2) + "GB";
  else if (bytes > (1024*1024))
    return (bytes/(1024*1024)).toFixed(2) + "MB";
  else if (bytes > 1024)
    return (bytes/1024).toFixed(2) + "KB";
  else
    return bytes + "B";
}