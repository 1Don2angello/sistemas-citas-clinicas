
Array_Validacion_Datos_Cliente = [];


$(document).ready(function(){

    $("#menu").load("menu.html",function(){

        $("#footer_nav").load("footer.html",function(){

            validar_sesion();

            inicializar_pagina();
            consultar_clientes();
            eventos();

            $(".loader").fadeOut("slow");
        });
    });
    
});


function inicializar_pagina(){

    try{
            
        $(".boton_nav").removeClass("activo");
        $("#nav_clientes").addClass("activo");
        
    
        $(".panel_edit_inputs").prop('disabled', true);  
        
        consultar_validaciones_cliente();        

    }catch(ex){
        alert("[inicializar_pagina -> function]: " + ex);
    }    
}



function eventos(){

    $("#btn_buscar").on('click',function(e){
        e.preventDefault();

        try{

            consultar_clientes();

        }catch(ex){
            alert("[btn_buscar -> click]:" + ex);
        }   

    });



    $("#btn_agregar").on('click',function(e){
        e.preventDefault();

        try{
            
            $(".panel_edit_inputs input").val("");
            $("#hid_clientes_id").val("");

            $("#btn_agregar").css("display","none");
            $("#btn_editar").css("display","none");
            $("#btn_eliminar").css("display","none");
            $("#btn_guardar").css("display","block");
            $("#btn_cancelar").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit").focus();

            
        }catch(ex){
            alert("[btn_agregar -> click]:" + ex);
        }
    });




    $("#btn_editar").on('click',function(e){
        e.preventDefault();

        try{
            
            $("#btn_agregar").css("display","none");
            $("#btn_editar").css("display","none");
            $("#btn_eliminar").css("display","none");
            $("#btn_guardar").css("display","block");
            $("#btn_cancelar").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit").focus();
            

        }catch(ex){
            alert("[btn_editar -> click]:" + ex);
        }
    });




    $("#btn_eliminar").on('click',function(e){
        e.preventDefault();

        try{

            Swal.fire({
                title: '¿Realmente quieres eliminar este registro?',
                showCancelButton: true,
                icon: 'question',
                confirmButtonText: `Eliminar`,
            }).then((result) => {

                
                if (result.isConfirmed) {
                    
                    eliminar_cliente();

                    $("#btn_eliminar").addClass("disabled");
                    $("#btn_editar").addClass("disabled");
                }
            });
            

        }catch(ex){
            alert("[btn_eliminar -> click]:" + ex);
        }
    });




    $("#btn_guardar").on('click',function(e){
        e.preventDefault();

        try{

            var validacion = validar_campos();
            if(validacion!=""){

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                  
                Toast.fire({
                    icon: 'error',
                    title: '<span style="font-weight:bold; font-size:18px;">Error de validación:</span><br><br> ' + validacion
                });


                return false;
            }


            $("#btn_agregar").css("display","block");
            $("#btn_editar").css("display","block");
            $("#btn_eliminar").css("display","block");
            $("#btn_guardar").css("display","none");
            $("#btn_cancelar").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            


            //agregar nuevo
            if($("#hid_clientes_id").val()==""){
                
                agregar_cliente();

            }else{//actualizar
                
                actualizar_cliente();
            }


            $("#btn_eliminar").addClass("disabled");
            $("#btn_editar").addClass("disabled");

            $(".panel_edit_inputs input").val("");


        }catch(ex){
            alert("[btn_guardar -> click]:" + ex);
        }

    });




    $("#btn_cancelar").on('click',function(e){
        e.preventDefault();

        try{

            $("#btn_agregar").css("display","block");
            $("#btn_editar").css("display","block");
            $("#btn_eliminar").css("display","block");
            $("#btn_guardar").css("display","none");
            $("#btn_cancelar").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            

            $("#btn_eliminar").addClass("disabled");
            $("#btn_editar").addClass("disabled");

            $(".panel_edit_inputs input").val("");


        }catch(ex){
            alert("[btn_guardar -> click]:" + ex);
        }
    });

        

    $("#txt_telefono_edit").keydown(function(e) {
        var key = e.charCode || e.keyCode || 0;

        if($("#txt_telefono_edit").val().length==10){
            
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40));
        }
    });
}





function consultar_clientes(){
    try{
            
        $(".loader").css("display","block");
        $(".panel_edit_inputs input").val("");

        //limpiamos el contenido de la tabla
        $('#datos_tabla_clientes').empty();



        var obj_filtros = new Object();
        obj_filtros.clientes_nombre = $('#txt_nombre').val();        
        obj_filtros.clientes_apellido_p = $("#txt_apellido_p").val();
        obj_filtros.clientes_apellido_m = $("#txt_apellido_m").val();
        //obj_filtros.juego_tipo = $("#cmb_tipo option:selected").text();
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_clientes_controller.php',
        data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                
                var jsonData = JSON.parse(response); 
        
                if(jsonData.length==0){
                    $('#datos_tabla_clientes').append('<tr style="pointer-events: none;"><td colspan="4">No se han encontrado resultados</td></tr>');
                }

                for(var i=0;i<jsonData.length;i++){

                    var fila = new Object();                
                    fila.clientes_id=jsonData[i].clientes_id;
                    fila.clientes_nombre=jsonData[i].clientes_nombre;
                    fila.clientes_apellido_p=jsonData[i].clientes_apellido_p;
                    fila.clientes_apellido_m=jsonData[i].clientes_apellido_m;
                    fila.clientes_telefono=jsonData[i].clientes_telefono;
                    fila.clientes_correo=jsonData[i].clientes_correo;
                    fila.clientes_direccion=jsonData[i].clientes_direccion;
                    fila.clientes_sexo=jsonData[i].clientes_sexo;
                    fila.clientes_edad=jsonData[i].clientes_edad;                    

                    var contenido="";
                                        
                    contenido +="<tr onClick='fila_click("+JSON.stringify(fila)+")'> "+
                                    '<td>'+ fila.clientes_nombre + ' ' + fila.clientes_apellido_p + ' ' + fila.clientes_apellido_m +'</td> '+
                                    '<td>'+ fila.clientes_correo +'</td> '+
                                    '<td>'+ fila.clientes_telefono +'</td> '+
                                    '<td>'+ fila.clientes_direccion +'</td> '+
                                '</tr>';

                    $('#datos_tabla_clientes').append(contenido);
                }

            }catch(ex_ajax){

                alert("[consultar_clientes -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);                
        }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_clientes -> function]: " + ex);
    }
}




function agregar_cliente(){
    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.clientes_nombre = $("#txt_nombre_edit").val();
        obj_filtros.clientes_apellido_p =$("#txt_apellido_p_edit").val();
        obj_filtros.clientes_apellido_m =$("#txt_apellido_m_edit").val();
        obj_filtros.clientes_telefono =$("#txt_telefono_edit").val();
        obj_filtros.clientes_correo =$("#txt_correo_edit").val();
        obj_filtros.clientes_direccion =$("#txt_direccion_edit").val();
        obj_filtros.clientes_sexo =$("#select_sexo_edit option:selected").text();
        obj_filtros.clientes_edad = $("#txt_edad_edit").val() == "" ? 0 : parseInt($("#txt_edad_edit").val(),10);
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_clientes_controller.php',
        data: {"funcion" : "agregar", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                                
                var jsonData = JSON.parse(response); 
        
                $(".loader").fadeOut("slow");
                if(jsonData.mensaje=="correcto"){
                    
                    Swal.fire({
                        title: 'Terminado',
                        text: 'Se ha agregado el registro correctamente',
                        icon: 'success',
                        confirmButtonText: 'aceptar'              
                    });

                }else{

                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error agregando el registro, intentalo de nuevo más tarde',
                        icon: 'error',
                        confirmButtonText: 'aceptar'              
                    });
                }

                
            }catch(ex_ajax){

                alert("[agregar_cliente -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);
            $(".loader").fadeOut("slow");                
        }
        });
        

        consultar_clientes();

    }catch(ex){
        alert("[agregar_cliente -> function]: " + ex);
    }
}



function actualizar_cliente(){

    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.clientes_id = $("#hid_clientes_id").val();
        obj_filtros.clientes_nombre = $("#txt_nombre_edit").val();
        obj_filtros.clientes_apellido_p =$("#txt_apellido_p_edit").val();
        obj_filtros.clientes_apellido_m =$("#txt_apellido_m_edit").val();
        obj_filtros.clientes_telefono =$("#txt_telefono_edit").val();
        obj_filtros.clientes_correo =$("#txt_correo_edit").val();
        obj_filtros.clientes_direccion =$("#txt_direccion_edit").val();
        obj_filtros.clientes_sexo =$("#select_sexo_edit option:selected").text();
        obj_filtros.clientes_edad =$("#txt_edad_edit").val();
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_clientes_controller.php',
        data: {"funcion" : "actualizar", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                                
                //console.log(response);
                var jsonData = JSON.parse(response); 
        
                $(".loader").fadeOut("slow");
                if(jsonData.mensaje=="correcto"){
                    
                    Swal.fire({
                        title: 'Terminado',
                        text: 'Se ha actualizado el registro correctamente',
                        icon: 'success',
                        confirmButtonText: 'aceptar'              
                    });

                }else{

                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error actualizando el registro, intentalo de nuevo más tarde',
                        icon: 'error',
                        confirmButtonText: 'aceptar'              
                    });
                }

                
            }catch(ex_ajax){

                alert("[actualizar_cliente -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);
            $(".loader").fadeOut("slow");                
        }
        });
        

        consultar_clientes();

    }catch(ex){
        alert("[actualizar_cliente -> function]: " + ex);
    }
}



function eliminar_cliente(){
    
    try{                    

        if(verificar_citas_cliente()){

            Swal.fire({
                title: '<span style="font-size:20px;">No es posible eliminar el cliente seleccionado porque ya tiene citas agendadas a su nombre<br><br>¿Desea eliminar el cliente de todas formas?<br>Se eliminarán todas las citas que se hayan registrado a su nombre.</span>',
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: `Eliminar`,
            }).then((result) => {

                
                if (result.isConfirmed) {                    
                    
                    $(".loader").css("display","block");

                    var clientes_id_tmp = $("#hid_clientes_id").val();
                
                    $.ajax({

                        type: "POST",
                        async: false,
                        url: '../controladores/catalogos/cat_clientes_controller.php',
                        data: {"funcion" : "eliminar", "id": clientes_id_tmp},
                        success: function(response)
                        {                

                            try{
                                
                                //console.log(response);
                                var jsonData = JSON.parse(response); 
                        
                                $(".loader").fadeOut("slow");
                                if(jsonData.mensaje=="correcto"){
                                    
                                    Swal.fire({
                                        title: 'Terminado',
                                        text: 'Se ha eliminado el registro correctamente',
                                        icon: 'success',
                                        confirmButtonText: 'aceptar'              
                                    });

                                }else{

                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ha ocurrido un error eliminando el registro, intentalo de nuevo más tarde',
                                        icon: 'error',
                                        confirmButtonText: 'aceptar'              
                                    });
                                }

                            }catch(ex_ajax){

                                alert("[eliminar_cliente -> ajax]: " + ex_ajax);
                            }

                        },
                        error: function(e){
                            
                            alert(e.responseText);                
                        }
                    });
                    
                    $(".loader").fadeOut("slow");
                    consultar_clientes();
                }
            });

            
        }else{
            
            $(".loader").css("display","block");

            var clientes_id_tmp = $("#hid_clientes_id").val();
        
            $.ajax({

                type: "POST",
                async: false,
                url: '../controladores/catalogos/cat_clientes_controller.php',
                data: {"funcion" : "eliminar", "id": clientes_id_tmp},
                success: function(response)
                {                

                    try{
                        
                        //console.log(response);
                        var jsonData = JSON.parse(response); 
                
                        $(".loader").fadeOut("slow");
                        if(jsonData.mensaje=="correcto"){
                            
                            Swal.fire({
                                title: 'Terminado',
                                text: 'Se ha eliminado el registro correctamente',
                                icon: 'success',
                                confirmButtonText: 'aceptar'              
                            });

                        }else{

                            Swal.fire({
                                title: 'Error',
                                text: 'Ha ocurrido un error eliminando el registro, intentalo de nuevo más tarde',
                                icon: 'error',
                                confirmButtonText: 'aceptar'              
                            });
                        }

                    }catch(ex_ajax){

                        alert("[eliminar_cliente -> ajax]: " + ex_ajax);
                    }

                },
                error: function(e){
                    
                    alert(e.responseText);                
                }
            });
            
            $(".loader").fadeOut("slow");
            consultar_clientes();
        }

        

    }catch(ex){
        alert("[eliminar_cliente -> function]: " + ex);
    }
}




function fila_click(fila){
    
    try{        
                                                
        $("#hid_clientes_id").val(fila.clientes_id);

        $("#btn_eliminar").removeClass("disabled");
        $("#btn_editar").removeClass("disabled");
        

        $("#txt_nombre_edit").val(fila.clientes_nombre);
        $("#txt_apellido_p_edit").val(fila.clientes_apellido_p);
        $("#txt_apellido_m_edit").val(fila.clientes_apellido_m);
        $("#txt_telefono_edit").val(fila.clientes_telefono);
        $("#txt_correo_edit").val(fila.clientes_correo);
        $("#txt_direccion_edit").val(fila.clientes_direccion);
        $("#select_sexo_edit").val(fila.clientes_sexo);
        $("#txt_edad_edit").val(fila.clientes_edad);



    }catch(ex){
        alert("[fila_click -> function]: " + ex);
    }
}








function verificar_citas_cliente(){

    var resultado=false;//false indica que no tienen ninguna cita agendada

    try{
            
        $(".loader").css("display","block");        
    

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : "verificar_citas_cliente", "id": $("#hid_clientes_id").val() },
            success: function(response)
            {                

                try{
                    
                    var jsonData = JSON.parse(response); 
            
                    if(jsonData.mensaje=="encontrado"){
                        
                        resultado=true;
                    }


                }catch(ex_ajax){

                    alert("[verificar_citas_cliente -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[verificar_citas_cliente -> function]: " + ex);
    }

    return resultado;
}



function consultar_validaciones_cliente(){

    try{
                    
        var obj_filtros = new Object();
        obj_filtros.configuracion_clase = "validacion_cliente";        
                        

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/configuracion_controller.php',
            data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response);                     
                    

                    for(var i=0;i<jsonData.length;i++){

                        var fila = new Object();                
                        fila.configuracion_nombre=jsonData[i].configuracion_nombre;
                        fila.configuracion_clase=jsonData[i].configuracion_clase;
                        fila.configuracion_valor=jsonData[i].configuracion_valor;

                        Array_Validacion_Datos_Cliente.push(fila);                                      
                    }

                }catch(ex_ajax){

                    alert("[consultar_validaciones_cliente -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("[consultar_validaciones_cliente -> function]: " + ex);
    }
}



function obtener_campo_validacion(nombre){

    var result = "";

    for(var i=0;i<Array_Validacion_Datos_Cliente.length;i++){

        if(Array_Validacion_Datos_Cliente[i].configuracion_nombre == nombre){
            result = Array_Validacion_Datos_Cliente[i].configuracion_valor;
            break;
        }
    }

    return result;
}



function validar_campos(){

    var resultado = "";
    
    if(obtener_campo_validacion("nombre_cliente")=="true"){
        if($("#txt_nombre_edit").val()=="")
            resultado += "- El campo 'nombre' es un dato obligatorio.<br>"
    }

    if(obtener_campo_validacion("apellido_p_cliente")=="true"){
        if($("#txt_apellido_p_edit").val()=="")
            resultado += "- El campo 'apellido paterno' es un dato obligatorio.<br>"
    }

    if(obtener_campo_validacion("apellido_m_cliente")=="true"){
        if($("#txt_apellido_m_edit").val()=="")
            resultado += "- El campo 'apellido materno' es un dato obligatorio.<br>"
    }

    if(obtener_campo_validacion("telefono_cliente")=="true"){
        if($("#txt_telefono_edit").val()=="")
            resultado += "- El campo 'telefono' es un dato obligatorio.<br>"

        else if($("#txt_telefono_edit").val().length!=10)
            resultado += "- El campo 'telefono' es incorrecto.<br>"
    }
    
    if(obtener_campo_validacion("correo_cliente")=="true"){
        if($("#txt_correo_edit").val()==""){
            resultado += "- El campo 'correo' es un dato obligatorio.<br>"
        }
        else{

            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            
            if(regex.test($("#txt_correo_edit").val())==false){
                resultado += "- El campo 'correo' es incorrecto.<br>";
            }
        }

    }

    if(obtener_campo_validacion("direccion_cliente")=="true"){
        if($("#txt_direccion_edit").val()=="")    
            resultado += "- El campo 'direccion' es un dato obligatorio.<br>"
    }

    if(obtener_campo_validacion("edad_cliente")=="true"){
        if($("#txt_edad_edit").val()=="")
            resultado += "- El campo 'edad' es un dato obligatorio.<br>"

        else if(parseInt($("#txt_edad_edit").val(),10)<=0 || parseInt($("#txt_edad_edit").val(),10)>=150)
            resultado += "- El campo 'edad' es incorrecto.<br>"
    }


    return resultado;
}




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

                $("#nav_clientes").css("display","none");
                $("#nav_servicios").css("display","none");
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