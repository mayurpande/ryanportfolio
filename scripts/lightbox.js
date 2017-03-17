var $overlay = $('<div id="overlay"></div>');
var $image = $("<img>");
var $caption = $('<p></p>');



//An image to overlay
$overlay.append($image);

//A caption to overlay
$overlay.append($caption);

//Add overlay
$("body").append($overlay);

//Capture the click event on a link to an image
$(".lightBox a").click(function(event){
  event.preventDefault();
//  x = this;
//  getNextImage(x);


  var imageLocation = $(this).attr("href");

  //Update overlay with the image linked in the link
  $image.attr("src", imageLocation);


  $('.footer').hide();
  //Show the overlay.
  $overlay.show();


  //get p element text and add it to caption
/*  var captionText = $(this).children("p").text();
  $caption.text(captionText);.*/

});

//When overlay is clicked
$overlay.click(function(){

  $('.footer').show();
  //Hide the overlay
  $overlay.hide();
});



function getNextImage(x){
  //console.log(currImage);


  var t = $(x).closest('li');

  var nextLi = t.closest('li').nextAll('.temp').slideToggle();
  //console.log(nextLi);
  /*$(nextLi).each(function(){
     arr.push($(this).children().attr("href"));
  });*/
  $nextButton.click(function(){


    $(nextLi).each(function(){

       console.log($(this).children().attr("href"));
       $image.attr("src",$(this).children().attr("href"));
       $overlay.append($image);
       $overlay.show();
    });
  });

}
