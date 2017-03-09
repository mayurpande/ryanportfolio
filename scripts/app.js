$(document).ready(function(){
    $("ul").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });


});

function crossfade(curr, next) {
    $(curr).fadeOut(500, function() {
        $(next).fadeIn(750);
    });

    if($(curr).closest('div')){
      ($(curr).closest('div').removeClass('tempActive'));
      ($(next).closest('ul').addClass('tempActive'));
    }else{
      ($(curr).closest('ul').removeClass('tempActive'));
      ($(next).closest('ul')).addClass('tempActive');
    }

}


function showGallery(curr, next) {

    $(curr).fadeOut(1000, function() {
        $('#wrapper').fadeIn();
    });
    crossfade('.home-ul',next);




}
