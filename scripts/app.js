$(document).ready(function(){

    $(".ul-list li").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });


});

function crossfade(curr, next) {

    if($(next).closest('div').hasClass('cycle-slideshow')){
      $('#projectDetails').fadeOut(700);
      $(curr).fadeOut(700, function() {
        $(next).fadeIn(700);

      });
    }else{
      $(curr).fadeOut(700, function() {
        $(next).fadeIn(700);
        $('#projectDetails').fadeIn(700);

      });

    }

    if($(curr).closest('div').hasClass('tempActive')){
     $(curr).removeClass('tempActive');
     $(next).closest('li').addClass('tempActive');
    }else if($(curr).closest('li').hasClass('tempActive')){
      $(curr).removeClass('tempActive');
      $(next).addClass('tempActive');
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
      window.location = newUrl;
  });
});
}
