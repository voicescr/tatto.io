$(document).ready(function () {
  $.getJSON("const/images.json", function (data) {
    console.log("getting images..", data); 
    var items = [];
    $.each(data, function (key, val) {
      //items.push();
      $("#galleryItems").append(
       "<div class=col-sm-3 >"+"<div class=gallery-grid>"+ "<img src="+val+" />" + "</div>" +"</div>"      
      );
    });
  });
});
