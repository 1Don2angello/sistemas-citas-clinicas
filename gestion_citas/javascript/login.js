$(document).ready(function () {
    
    interaccion_login();
    eventos();
    consultar_nombre_empresa();
});



function consultar_nombre_empresa(){
  
  try{
                    
    var obj_filtros = new Object();
    obj_filtros.configuracion_clase = "info_empresa";        
                    

    $.ajax({

        type: "POST",
        async: false,
        url: 'controladores/operaciones/configuracion_controller.php',
        data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                
                console.log(response);
                var jsonData = JSON.parse(response);                     
                
                $("#lb_nombre_empresa").text(jsonData[0].configuracion_valor);

            }catch(ex_ajax){

                alert("[consultar_nombre_empresa -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);                
        }
    });        

  }catch(ex){
      alert("[consultar_nombre_empresa -> function]: " + ex);
  }

}



function eventos(){

    $('#btn_acceder').on('click',function(e){
        e.preventDefault();
        
        if($("#txt_usuario").val()!="" && $("#txt_clave").val()!=""){
          
          consultar_usuario();

        }else{

          $.toast({
            position: 'top-right',
            heading: 'Error',
            text: 'Favor de ingresar el usuario y contraseña',
            icon: 'error',
            loader: true,        // Change it to false to disable loader
            loaderBg: '#9EC600'  // To change the background
          });
        }
        
    });
}



function consultar_usuario(){
  
  try{
                    
    var obj_filtros = new Object();
    obj_filtros.usuarios_usuario = $("#txt_usuario").val();        
    obj_filtros.usuarios_clave = $("#txt_clave").val();
                    

    $.ajax({

        type: "POST",
        async: false,
        url: 'controladores/operaciones/login_controller.php',
        data: {"funcion" : "consultar_usuario", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                
                console.log(response);
                var jsonData = JSON.parse(response);                     
                if(jsonData.mensaje=="correcto"){

                  crear_session();
                  window.location.href = 'paginas/panel_calendario.html';

                }else{

                  $.toast({
                    position: 'top-right',
                    heading: 'Error',
                    text: 'Error usuario o contraseña',
                    icon: 'error',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                  });
                }
                

            }catch(ex_ajax){

                alert("[consultar_usuario -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);                
        }
    });        

  }catch(ex){
      alert("[consultar_usuario -> function]: " + ex);
  }

}



function crear_session(){
  
  try{
                    
    $.ajax({

        type: "POST",
        async: false,
        url: 'controladores/operaciones/login_controller.php',
        data: {"funcion" : "crear_session", "user": $("#txt_usuario").val() , "pass": $("#txt_clave").val()},
        success: function(response)
        {                

            try{
                
                console.log(response);                
                var jsonData = JSON.parse(response);                     
                if(jsonData.mensaje!="correcto"){

                  alert("error creando la sesion del usuario");

                }                

            }catch(ex_ajax){

                alert("[crear_sesion -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);                
        }
    });        

  }catch(ex){
      alert("[crear_sesion -> function]: " + ex);
  }

}




function interaccion_login(){

    var panel = $(".form").height();

    var panelOne = $(".form-panel.two").height();
    panelTwo = $(".form-panel.two")[0].scrollHeight;
  
    $(".form-panel.two")
      .not(".form-panel.two.active")
      .on("click", function (e) {
        e.preventDefault();
  
        $(".form-toggle").addClass("visible");
        $(".form-panel.one").addClass("hidden");
        $(".form-panel.two").addClass("active");
        
      });
  
    $(".form-toggle").on("click", function (e) {
      e.preventDefault();
      $(this).removeClass("visible");
      $(".form-panel.one").removeClass("hidden");
      $(".form-panel.two").removeClass("active");
      
    });
}
  