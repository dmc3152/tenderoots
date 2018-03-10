$('input').on("input", saveValue);
$('textarea').on("input", saveValue);
$('textarea').on("input", setCount);

function saveValue(event) {
  var element = $(event.target);
  var url = "../php/action.php";
  var formData = {
    name: element.attr('name'),
    value: element.val(),
    action: "updatePersonField"
  };
  
  ajaxPost(url, formData, function(data) {
    console.log(data);
    if(!data.success)
      alert("Values are not saving.");
  });
}

// Continue this functionality: set count to charCount for textarea
function setCount(event) {
  var element = $(event.target);
  console.log(element.val().length);
}