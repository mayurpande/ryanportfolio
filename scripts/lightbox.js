var $overlay = $('<div id="overlay"></div>');
var $image = $("<img>");
var $caption = $("<p></p>");

//An image to overlay
$overlay.append($image);

//A caption to overlay
$overlay.append($caption);

//Add overlay
$("#wrapper").append($overlay);

//Capture the click event on a link to an image
$(".lightBox a").click(function(event){
  event.preventDefault();
  var imageLocation = $(this).attr("href");
  //Update overlay with the image linked in the link
  $image.attr("src", imageLocation);
  
  var miscUl = $(this).parent();
  if(miscUl.attr("id") == "misc-ul"){
      $('#misc-ul').hide();
      $overlay.addClass('toggleMisc');
  }
  $('.footer').hide();
  //Show the overlay.
  $overlay.show();
  
  //Get child's alt attribute and set caption
  var captionText = $(this).children("img").attr("alt");
  $caption.text(captionText);
});

//When overlay is clicked
$overlay.click(function(){
  
  //console.log(t);
  if($(this).hasClass('toggleMisc')){
        $('#misc-ul').show();
        $(this).removeClass('toggleMisc');

  }
  $('.footer').show();
  //Hide the overlay
  $overlay.hide();
  

 
});