
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


function inicializar_pagina(){

    try{
            
        $(".boton_nav").removeClass("activo");
        $("#nav_usuarios").addClass("activo");
        

        $("#select_servicios_edit").select2();           
        _llenar_combo('select_servicios_edit','../controladores/catalogos/cat_servicios_controller.php','combo_servicios');  
        
        consultar_usuarios();     

    }catch(ex){
        alert("[inicializar_pagina -> function]: " + ex);
    }    
}



function eventos(){

    $("#btn_buscar").on('click',function(e){
        e.preventDefault();

        try{

            consultar_usuarios();

        }catch(ex){
            alert("[btn_buscar -> click]:" + ex);
        }   

    });



    $("#btn_agregar").on('click',function(e){
        e.preventDefault();

        try{
            
            limpiar_controles();
            $("#hid_usuarios_id").val("");

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
            if($("#hid_usuarios_id").val()==""){
                
                agregar_usuario();

            }else{//actualizar
                
                actualizar_cliente();
            }


            $("#btn_eliminar").addClass("disabled");
            $("#btn_editar").addClass("disabled");

            limpiar_controles();


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

            limpiar_controles();


        }catch(ex){
            alert("[btn_guardar -> click]:" + ex);
        }
    });

        
    $("#select_rol_edit").change(function(){    

        if($("#select_rol_edit").val()=="Proveedor"){
            
            $("#row_select_rol").show();            
                        
        }else{
            
            $("#row_select_rol").hide();            
        }

        $("#select_servicios_edit").val([]).change();        
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





function consultar_usuarios(){
    try{
            
        $(".loader").css("display","block");
        limpiar_controles();

        //limpiamos el contenido de la tabla
        $('#datos_tabla_usuarios').empty();



        var obj_filtros = new Object();
        obj_filtros.usuarios_nombre = $('#txt_nombre').val();        
        obj_filtros.usuarios_apellido_p = $("#txt_apellido_p").val();
        obj_filtros.usuarios_apellido_m = $("#txt_apellido_m").val();
        obj_filtros.usuarios_rol = $("#select_rol option:selected").text();
                

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response); 
            
                    if(jsonData.length==0){
                        $('#datos_tabla_usuarios').append('<tr style="pointer-events: none;"><td colspan="5">No se han encontrado resultados</td></tr>');
                    }

                    for(var i=0;i<jsonData.length;i++){

                        var fila = new Object();                
                        fila.usuarios_id=jsonData[i].usuarios_id;
                        fila.usuarios_nombre=jsonData[i].usuarios_nombre;
                        fila.usuarios_apellido_p=jsonData[i].usuarios_apellido_p;
                        fila.usuarios_apellido_m=jsonData[i].usuarios_apellido_m;
                        fila.usuarios_telefono=jsonData[i].usuarios_telefono;
                        fila.usuarios_correo=jsonData[i].usuarios_correo;
                        fila.usuarios_direccion=jsonData[i].usuarios_direccion;
                        fila.usuarios_usuario=jsonData[i].usuarios_usuario;
                        fila.usuarios_clave=jsonData[i].usuarios_clave;  
                        fila.usuarios_rol=jsonData[i].usuarios_rol;                    

                        var contenido="";
                                            
                        contenido +="<tr onClick='fila_click("+JSON.stringify(fila)+")'> "+
                                        '<td>'+ fila.usuarios_nombre + ' ' + fila.usuarios_apellido_p + ' ' + fila.usuarios_apellido_m +'</td> '+
                                        '<td>'+ fila.usuarios_correo +'</td> '+
                                        '<td>'+ fila.usuarios_telefono +'</td> '+
                                        '<td>'+ fila.usuarios_usuario +'</td> '+
                                        '<td>'+ fila.usuarios_rol +'</td> '+
                                    '</tr>';

                        $('#datos_tabla_usuarios').append(contenido);
                    }

                }catch(ex_ajax){

                    alert("[consultar_usuarios -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_usuarios -> function]: " + ex);
    }
}




function agregar_usuario(){
    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.usuarios_nombre = $("#txt_nombre_edit").val();
        obj_filtros.usuarios_apellido_p =$("#txt_apellido_p_edit").val();
        obj_filtros.usuarios_apellido_m =$("#txt_apellido_m_edit").val();
        obj_filtros.usuarios_telefono =$("#txt_telefono_edit").val();
        obj_filtros.usuarios_correo =$("#txt_correo_edit").val();
        obj_filtros.usuarios_direccion =$("#txt_direccion_edit").val();
        obj_filtros.usuarios_usuario =$("#txt_usuario_edit").val();
        obj_filtros.usuarios_clave =$("#txt_clave_edit").val();
        obj_filtros.usuarios_rol =$("#select_rol_edit option:selected").text();
                
        console.log("Contenido de obj_filtros:", obj_filtros);
        console.log("JSON de obj_filtros:", JSON.stringify(obj_filtros));
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : "agregar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response); 
                                
                    if(jsonData.mensaje=="correcto"){
                                                
                        array_servicios=[];

                        for(var i=0; i<$("#select_servicios_edit").val().length; i++){
                            var item = new Object();
                            item.usuarios_id=jsonData.id;
                            item.servicios_id=$("#select_servicios_edit").val()[i];
                            array_servicios.push(item);
                        }


                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/catalogos/cat_usuarios_controller.php',
                            data: {"funcion" : "registrar_servicios_usuario", "obj_filtros": JSON.stringify(array_servicios)},
                            success: function(data)
                            {                
                
                                try{
                                    
                                    console.log(data);
                                    var datos = JSON.parse(data); 
                            
                                    $(".loader").fadeOut("slow");
                                    if(datos.mensaje=="correcto"){
                                                                                
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
                
                                    alert("[agregar_usuario -> ajax_servicios]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);
                                $(".loader").fadeOut("slow");                
                            }
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

                    alert("[agregar_usuario -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);
                $(".loader").fadeOut("slow");                
            }
        });
        

        consultar_usuarios();

    }catch(ex){
        alert("[agregar_usuario -> function]: " + ex);
    }
}



function actualizar_cliente(){

    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.usuarios_id = $("#hid_usuarios_id").val();
        obj_filtros.usuarios_nombre = $("#txt_nombre_edit").val();
        obj_filtros.usuarios_apellido_p =$("#txt_apellido_p_edit").val();
        obj_filtros.usuarios_apellido_m =$("#txt_apellido_m_edit").val();
        obj_filtros.usuarios_telefono =$("#txt_telefono_edit").val();
        obj_filtros.usuarios_correo =$("#txt_correo_edit").val();
        obj_filtros.usuarios_direccion =$("#txt_direccion_edit").val();
        obj_filtros.usuarios_usuario =$("#txt_usuario_edit").val();
        obj_filtros.usuarios_clave =$("#txt_clave_edit").val();
        obj_filtros.usuarios_rol =$("#select_rol_edit option:selected").text();
        console.log("Contenido de obj_filtros:", obj_filtros);
        console.log("JSON de obj_filtros:", JSON.stringify(obj_filtros));    

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : "actualizar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                                    
                    //console.log(response);
                    var jsonData = JSON.parse(response); 
                                
                    if(jsonData.mensaje=="correcto"){
                        
                        array_servicios=[];

                        for(var i=0; i<$("#select_servicios_edit").val().length; i++){
                            var item = new Object();
                            item.usuarios_id=obj_filtros.usuarios_id;
                            item.servicios_id=$("#select_servicios_edit").val()[i];
                            array_servicios.push(item);
                        }


                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/catalogos/cat_usuarios_controller.php',
                            data: {"funcion" : "registrar_servicios_usuario", "obj_filtros": JSON.stringify(array_servicios)},
                            success: function(data)
                            {                
                
                                try{
                                    
                                    console.log(data);
                                    var datos = JSON.parse(data); 
                            
                                    $(".loader").fadeOut("slow");
                                    if(datos.mensaje=="correcto"){
                                                                                
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
                
                                    alert("[agregar_usuario -> ajax_servicios]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);
                                $(".loader").fadeOut("slow");                
                            }
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
        

        consultar_usuarios();

    }catch(ex){
        alert("[actualizar_cliente -> function]: " + ex);
    }
}



function eliminar_cliente(){
    
    try{
            
        $(".loader").css("display","block");

        var clientes_id_tmp = $("#hid_usuarios_id").val();
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_usuarios_controller.php',
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
        consultar_usuarios();

    }catch(ex){
        alert("[eliminar_cliente -> function]: " + ex);
    }
}




function fila_click(fila){
    
    try{        
                                                
        $("#hid_usuarios_id").val(fila.usuarios_id);

        $("#btn_eliminar").removeClass("disabled");
        $("#btn_editar").removeClass("disabled");
        
        $("#txt_nombre_edit").val(fila.usuarios_nombre);
        $("#txt_apellido_p_edit").val(fila.usuarios_apellido_p);
        $("#txt_apellido_m_edit").val(fila.usuarios_apellido_m);
        $("#txt_telefono_edit").val(fila.usuarios_telefono);
        $("#txt_correo_edit").val(fila.usuarios_correo);
        $("#txt_direccion_edit").val(fila.usuarios_direccion);
        $("#txt_usuario_edit").val(fila.usuarios_usuario);
        $("#txt_clave_edit").val(fila.usuarios_clave);
        $("#select_rol_edit").val(fila.usuarios_rol);        

        if($("#select_rol_edit").val()!="Proveedor"){
            
            $("#row_select_rol").hide();                                    
        }else{
            $("#row_select_rol").show();                                    
        }

        consultar_servicios_usuario(fila.usuarios_id);

    }catch(ex){
        alert("[fila_click -> function]: " + ex);
    }
}






function validar_campos(){

    var resultado = "";        

    if($("#txt_nombre_edit").val()=="")
        resultado += "- El campo 'nombre' es un dato obligatorio.<br>"
    

    if($("#txt_apellido_p_edit").val()=="")
        resultado += "- El campo 'apellido paterno' es un dato obligatorio.<br>"
    

    if($("#txt_apellido_m_edit").val()=="")
        resultado += "- El campo 'apellido materno' es un dato obligatorio.<br>"
    

    if($("#txt_telefono_edit").val()=="")
        resultado += "- El campo 'teléfono' es un dato obligatorio.<br>"
    else if($("#txt_telefono_edit").val().length!=10)
        resultado += "- El campo 'teléfono' es incorrecto.<br>"
    
        
    if($("#txt_correo_edit").val()==""){
        resultado += "- El campo 'correo' es un dato obligatorio.<br>"
    }
    else{

        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            
        if(regex.test($("#txt_correo_edit").val())==false){
            resultado += "- El campo 'correo' es incorrecto.<br>";
        }
    }

        
    if($("#txt_direccion_edit").val()=="")    
        resultado += "- El campo 'dirección' es un dato obligatorio.<br>"
    
    
    if($("#txt_usuario_edit").val()=="")
        resultado += "- El campo 'usuario' es un dato obligatorio.<br>"

        
    if($("#txt_clave_edit").val()=="")
        resultado += "- El campo 'Contraseña' es un dato obligatorio.<br>"
    

    if($("#select_rol_edit").val()=="Proveedor"){

        if($("#select_servicios_edit").val().length == 0){
            resultado += "- Debe agregar por lo menos un servicio para cada proveedor.<br>"
        }
    }

    return resultado;
}



function _llenar_combo(id_combo, controlador, metodo) {
    
    try {
        
        $('#' + id_combo + ' option').remove();

        $.ajax({
            type: 'POST',
            url: controlador,
            data: {"funcion" : metodo},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                                        
                    //document.getElementById(id_combo).innerHTML += "<option value='-1'>- seleccionar -</option>";

                    for (var i = 0; i < datos.length; i++) {

                        document.getElementById(id_combo).innerHTML += "<option value='" + datos[i].id + "'>" + datos[i].texto + "</option>";
                    }                    
                                        
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [_llenar_combo]', e);
    }
}


function consultar_servicios_usuario(usuario_id){
    
    try {
            
        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : "consultar_servicios_usuario", "id" : usuario_id},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                    
                    
                    servicio_ids=[];
                    for(var i=0;i<datos.length;i++){
                        servicio_ids.push(datos[i].servicios_id);
                    }

                    console.log(servicio_ids);
                    $("#select_servicios_edit").val(servicio_ids).change();                     
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [consultar_servicios_usuario] ' + e);
    }
}


function limpiar_controles(){

    $(".panel_edit_inputs input").val("");
    $("#select_rol_edit").val("Proveedor");
    $("#select_servicios_edit").val([]).change();        
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