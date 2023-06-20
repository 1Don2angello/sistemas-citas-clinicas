
$(document).ready(function(){

    $("#menu").load("menu.html",function(){

        $("#footer_nav").load("footer.html",function(){

            validar_sesion();
            
            inicializar_pagina();            
            eventos();

            $(".loader").fadeOut("slow");
        });
    });
    
});



