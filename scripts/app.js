$(document).ready(function(){

    $(".ul-list li").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });

   var images = [
     'home1.jpg',
     'home2.jpg',
     'home3.jpg',
     'home4.jpg',
     'home5.jpg',
     'home6.jpg',
     'home7.jpg',

   ];

   var size = images.length;
   var x = Math.floor(size*Math.random())

   $('.landing-page').css('background','url(' + '/img/' + images[x] + ') no-repeat center');
   $('.landing-page').css('background-size','cover');


});

function crossfade(curr, next) {


    $(curr).fadeOut(700, function() {

      $(next).fadeIn(700);


    });



    if($(curr).closest('div').hasClass('tempActive')){
     $(curr).removeClass('tempActive');
     $(next).closest('li').addClass('tempActive');
     //$('#projectDetails').addClass('tempActive');
   }else if($(curr).closest('li').hasClass('tempActive')){
      $(curr).removeClass('tempActive');
      $(next).addClass('tempActive');
      //$('#projectDetails').addClass('tempActive');

    }
}

function crossFadePc(curr, next) {
    $(curr).fadeOut(700, function() {
      $(next).fadeIn(700);
    });
    if($(curr).closest('li').hasClass('temp')){
      $(curr).removeClass('temp');
      $(next).addClass('temp');
      $('#projectDetails').addClass('temp');
    }

}

// function showGallery(curr, next) {
//
//     $(curr).fadeOut(1000, function() {
//         $('#wrap').fadeIn();
//     });
//     crossFadePc('.home-ul',next);
// }

function showHomePage(curr){
  newUrl = window.location + 'portfolio';
  $(curr).click(function() {
  $("body").fadeOut(1000, function() {
      $('body').css('background','none');
      window.location = newUrl;
  });
});
}
