
$(document).ready(function(){

    $("#menu").load("../paginas/menu",function(){

        $("#footer_nav").load("../paginas/footer",function(){

            validar_sesion();
            
            inicializar_pagina();            
            eventos();

            $(".loader").fadeOut("slow");
        });
    });
    
});

