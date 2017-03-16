$(document).ready(function(){

    $(".ul-list").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });


});


/*$(window).resize(function(){
 if(window.innerWidth>768){
  $('.cycle-slideshow').removeClass('.tempActive');
  $('.home-ul').addClass('.tempActive');
 }
});
*/
function crossfade(curr, next) {
    $(curr).fadeOut(700, function() {
      $(next).fadeIn(700);
    });

   if($(curr).closest('div') == 'div'){
     $(curr).closest('div').removeClass('tempActive');
     $(next).closest('ul').addClass('tempActive');
   } else if ($(curr).closest('ul')){
     $(curr).closest('ul').removeClass('tempActive');
     $(next).closest('ul').addClass('tempActive');
   }
}
/*if($(curr).closest('div').hasClass('tempActive')){
 $(curr).removeClass('tempActive');
 $(next).addClass('tempActive');
}else if($(curr).closest('li').hasClass('tempActive')){
  $(curr).removeClass('tempActive');
  $(next).addClass('tempActive');
}
*/

function crossFadePc(curr, next) {
    $(curr).fadeOut(700, function() {
      $(next).fadeIn(700);
    });

    if ($(curr).closest('ul')){
      $(curr).closest('ul').removeClass('temp');
      $(next).closest('ul').addClass('temp');
    }
}

function showGallery(curr, next) {

    $(curr).fadeOut(1000, function() {
        $('#wrapper').fadeIn();
    });
    crossFadePc('.home-ul',next);
}
