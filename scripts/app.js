$(document).ready(function(){

    $(".ul-list li").each(function(index){
      if(!$(this).hasClass("home-ul")){
        $(this).hide();
      }
   });




 $.ajax({
  url:'/land-images',
  type:'GET',
  dataType:'json',
  success:function(data){
    var size = data.length;
    var x = Math.floor(size*Math.random())

    $('.landing-page').css('background','url(' + '/img/' + data[x] + ') no-repeat center');
    $('.landing-page').css('background-size','cover');
  }
  });



   $(window).on('load resize',function(event){
     event.preventDefault();

     if($(window).width() < 768 && window.location.href == 'http://ryanotoolecollett.com/'){

       window.location.href = "http://ryanotoolecollett.com/portfolio";

     }

   });

});



function crossfade(curr, next) {

    $(curr).fadeOut(700, function() {

      $(next).fadeIn(700);

    });

    if($(curr).closest('div').hasClass('tempActive')){
     $(curr).removeClass('tempActive');
     $(next).closest('li').addClass('tempActive');


    }else if($(curr).closest('li').hasClass('tempActive')){
      $(curr).removeClass('tempActive');
      $(next).addClass('tempActive');



    }
}

function crossFadePc(curr, next) {
    $(curr).fadeOut(700,function() {
      $(next).fadeIn(1000);
    });

    if($(curr).closest('li').hasClass('temp')){
      $(curr).removeClass('temp');
      $(next).addClass('temp');
    }

}


function showHomePage(){
  $("body").fadeOut(700, function() {
      $('body').css('background','none');
      window.location.href = "./portfolio";
  });
}
