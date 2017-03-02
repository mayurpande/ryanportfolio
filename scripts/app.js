$(document).ready(function(){
    $("ul").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });


});

function crossfade(curr, next) {
    $(curr).fadeOut(1000, function() {
        $(next).fadeIn(2000);
    });
}
