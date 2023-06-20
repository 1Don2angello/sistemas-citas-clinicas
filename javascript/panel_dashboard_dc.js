
$(document).ready(function(){

    $("#menu").load("menu.html",function(){

        $("#footer_nav").load("footer.html",function(){      
            $(".loader").fadeOut("slow");
        });
    });
    
});
