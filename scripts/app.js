$(document).ready(function(){
   // $('#port-ul').hide();
    //$('#land-ul').hide();
    //$('#misc-ul').hide();
    $("ul").each(function(index){
      if($(this).attr("id") != "home-ul"){
        $(this).hide();
      }
      console.log("this worked");
   });


});

function crossfade(curr, next) {
    $(curr).fadeOut(1000, function() {
        $(next).fadeIn(2000);
    });
}
