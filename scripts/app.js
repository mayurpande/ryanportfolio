$(document).ready(function(){
    $('#port-ul').hide();
    $('#land-ul').hide();
    $('#misc-ul').hide();

});

function crossfade(curr, next) {
    $(curr).fadeOut(1000, function() {
        $(next).fadeIn(1300);
    });    
}
    



    




  