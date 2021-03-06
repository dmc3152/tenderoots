$(document).ready(function(){
  var url = "../php/action.php";
  var formData = { action: "getThumbnails" };

  ajaxPost(url, formData, function(data) {
    if(data.success) {
      var imagePath = "../assets/images/" + data.subDirectory + "/";
      var thumbPath = "../assets/images/" + data.subDirectory + "/thumb/";
      if(data.thumbnails.length < 1) {
        $('.gallery-component').hide();
      } else {
        $('.gallery-component').show();
      }
      for(var i in data.thumbnails) {
        var image = imagePath + data.thumbnails[i];
        var thumb = thumbPath + data.thumbnails[i];
        $('.gallery-component .images').append("<img src='"+thumb+"' onclick='openModal(\""+image+"\");'>");
      }
    } else
      $('.gallery-component').hide();
  });
});

function openModal(image) {
  $('#galleryModal .modal-body').append("<img src='"+image+"'>");
  // $('#galleryModal').modal('show');
  $('#galleryModal').modal({ backdrop: 'static' });
}

function closeModal() {
  $('#galleryModal').modal('hide');
}

// Removes modal contents on close
$('#galleryModal').on('hide.bs.modal', function (e) {
  $('#galleryModal .modal-body').empty();
});