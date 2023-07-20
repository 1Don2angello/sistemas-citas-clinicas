
$(document).ready(function(){

    $("#menu").load("menu.html",function(){

        $("#footer_nav").load("footer.html",function(){      
            $(".loader").fadeOut("slow");
        });
    });
    
});


function validar_sesion(){

    $.ajax({
  
      type: "POST",
      async: false,
      url: '../controladores/operaciones/login_controller.php',
      data: {"funcion" : "validar_usuario"},
      success: function(response)
      {                           
        
        var jsonData = JSON.parse(response); 
  
        if(jsonData.mensaje=="error"){
                  
          window.location.href = "../index.html";
  
        }else{
                
            $("#lbl_nombre_usuario").text(jsonData.nombre_usuario);

            if(jsonData.rol=="Proveedor"){
               /*  $("#nav_calendario").css("display","none"); */
               $("#nav_calendario").css("display","none");
                $("#nav_clientes").css("display","none");
                $("#nav_consultas").css("display","none");
                $("#nav_usuarios").css("display","none");
                $("#nav_configuracion").css("display","none");
            }
        }
                                  
      },
      error: function(e){
  
        alert(e);        
      }
    }); 
}