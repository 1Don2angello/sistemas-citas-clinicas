
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
        $("#nav_servicios").addClass("activo");
        
    
        $(".panel_edit_inputs").prop('disabled', true);  

        _llenar_combo('select_categoria_edit_servicio','../controladores/catalogos/cat_categorias_controller.php','combo_categorias');
        _llenar_combo('select_categoria_servicio','../controladores/catalogos/cat_categorias_controller.php','combo_categorias');
                
        consultar_servicios();
        consultar_categorias();

    }catch(ex){
        alert("[inicializar_pagina -> function]: " + ex);
    }    
}




function eventos(){

    $('.nav-link').on('click', function (e) {
        inicializar_pagina();
    });



    //------------------ EVENTOS SERVICIOS -----------------------

    $("#btn_buscar_servicio").on('click',function(e){
        e.preventDefault();

        try{

            consultar_servicios();

        }catch(ex){
            alert("[btn_buscar_servicio -> click]:" + ex);
        }   

    });


    $("#btn_agregar_servicio").on('click',function(e){
        e.preventDefault();

        try{
            
            vacias_inputs();
            $("#hid_servicios_id").val("");

            $("#btn_agregar_servicio").css("display","none");
            $("#btn_editar_servicio").css("display","none");
            $("#btn_eliminar_servicio").css("display","none");
            $("#btn_guardar_servicio").css("display","block");
            $("#btn_cancelar_servicio").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit_servicio").focus();

            
        }catch(ex){
            alert("[btn_agregar_servicio -> click]:" + ex);
        }
    });


    $("#btn_editar_servicio").on('click',function(e){
        e.preventDefault();

        try{
            
            $("#btn_agregar_servicio").css("display","none");
            $("#btn_editar_servicio").css("display","none");
            $("#btn_eliminar_servicio").css("display","none");
            $("#btn_guardar_servicio").css("display","block");
            $("#btn_cancelar_servicio").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit_servicio").focus();
            

        }catch(ex){
            alert("[btn_editar_servicio -> click]:" + ex);
        }
    });


    $("#btn_eliminar_servicio").on('click',function(e){
        e.preventDefault();

        try{

            Swal.fire({
                title: '¿Realmente quieres eliminar este registro?',
                showCancelButton: true,
                icon: 'question',
                confirmButtonText: `Eliminar`,
            }).then((result) => {

                
                if (result.isConfirmed) {
                    
                    eliminar_servicios();

                    $("#btn_eliminar_servicio").addClass("disabled");
                    $("#btn_editar_servicio").addClass("disabled");
                }
            });
            

        }catch(ex){
            alert("[btn_eliminar_servicio -> click]:" + ex);
        }
    });


    $("#btn_guardar_servicio").on('click',function(e){
        e.preventDefault();

        try{

            var validacion = validar_campos_servicios();
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


            $("#btn_agregar_servicio").css("display","block");
            $("#btn_editar_servicio").css("display","block");
            $("#btn_eliminar_servicio").css("display","block");
            $("#btn_guardar_servicio").css("display","none");
            $("#btn_cancelar_servicio").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            


            //agregar nuevo
            if($("#hid_servicios_id").val()==""){
                
                agregar_servicios();

            }else{//actualizar
                
                actualizar_servicios();
            }


            $("#btn_eliminar_servicio").addClass("disabled");
            $("#btn_editar_servicio").addClass("disabled");

            vacias_inputs();


        }catch(ex){
            alert("[btn_guardar_servicio -> click]:" + ex);
        }

    });


    $("#btn_cancelar_servicio").on('click',function(e){
        e.preventDefault();

        try{

            $("#btn_agregar_servicio").css("display","block");
            $("#btn_editar_servicio").css("display","block");
            $("#btn_eliminar_servicio").css("display","block");
            $("#btn_guardar_servicio").css("display","none");
            $("#btn_cancelar_servicio").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            

            $("#btn_eliminar_servicio").addClass("disabled");
            $("#btn_editar_servicio").addClass("disabled");

            vacias_inputs();


        }catch(ex){
            alert("[btn_guardar_servicio -> click]:" + ex);
        }
    });
    
    //------------------ (fin eventos servicios) -----------------------
        




    //-------------------- EVENTOS CATEGORIAS -------------------------
    $("#btn_buscar_categoria").on('click',function(e){
        e.preventDefault();

        try{

            consultar_categorias();

        }catch(ex){
            alert("[btn_buscar_categoria -> click]:" + ex);
        }   

    });


    $("#btn_agregar_categoria").on('click',function(e){
        e.preventDefault();

        try{
            
            vaciar_inputs_categorias();
            $("#hid_categorias_id").val("");

            $("#btn_agregar_categoria").css("display","none");
            $("#btn_editar_categoria").css("display","none");
            $("#btn_eliminar_categoria").css("display","none");
            $("#btn_guardar_categoria").css("display","block");
            $("#btn_cancelar_categoria").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit_categoria").focus();

            
        }catch(ex){
            alert("[btn_agregar_categoria -> click]:" + ex);
        }
    });


    $("#btn_editar_categoria").on('click',function(e){
        e.preventDefault();

        try{
            
            $("#btn_agregar_categoria").css("display","none");
            $("#btn_editar_categoria").css("display","none");
            $("#btn_eliminar_categoria").css("display","none");
            $("#btn_guardar_categoria").css("display","block");
            $("#btn_cancelar_categoria").css("display","block");

            $(".panel_edit_inputs").css("pointer-events","all");
            $("#txt_nombre_edit_categoria").focus();
            

        }catch(ex){
            alert("[btn_editar_categoria -> click]:" + ex);
        }
    });


    $("#btn_eliminar_categoria").on('click',function(e){
        e.preventDefault();

        try{

            Swal.fire({
                title: '¿Realmente quieres eliminar este registro?',
                showCancelButton: true,
                icon: 'question',
                confirmButtonText: `Eliminar`,
            }).then((result) => {

                
                if (result.isConfirmed) {
                    
                    eliminar_categorias();

                    $("#btn_eliminar_categoria").addClass("disabled");
                    $("#btn_editar_categoria").addClass("disabled");
                }
            });
            

        }catch(ex){
            alert("[btn_eliminar_categoria -> click]:" + ex);
        }
    });


    $("#btn_guardar_categoria").on('click',function(e){
        e.preventDefault();

        try{

            var validacion = validar_campos_categorias();
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


            $("#btn_agregar_categoria").css("display","block");
            $("#btn_editar_categoria").css("display","block");
            $("#btn_eliminar_categoria").css("display","block");
            $("#btn_guardar_categoria").css("display","none");
            $("#btn_cancelar_categoria").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            


            //agregar nuevo
            if($("#hid_categorias_id").val()==""){
                
                agregar_categorias();

            }else{//actualizar
                
                actualizar_categorias();
            }


            $("#btn_eliminar_categoria").addClass("disabled");
            $("#btn_editar_categoria").addClass("disabled");

            vaciar_inputs_categorias();


        }catch(ex){
            alert("[btn_guardar_categoria -> click]:" + ex);
        }

    });


    $("#btn_cancelar_categoria").on('click',function(e){
        e.preventDefault();

        try{

            $("#btn_agregar_categoria").css("display","block");
            $("#btn_editar_categoria").css("display","block");
            $("#btn_eliminar_categoria").css("display","block");
            $("#btn_guardar_categoria").css("display","none");
            $("#btn_cancelar_categoria").css("display","none");

            $(".panel_edit_inputs").css("pointer-events","none");            

            $("#btn_eliminar_categoria").addClass("disabled");
            $("#btn_editar_categoria").addClass("disabled");

            vaciar_inputs_categorias();


        }catch(ex){
            alert("[btn_guardar_categoria -> click]:" + ex);
        }
    });
    //------------------ (fin eventos categorias) -----------------------
}





function consultar_servicios(){
    try{
            
        $(".loader").css("display","block");
        vacias_inputs();

        //limpiamos el contenido de la tabla
        $('#datos_tabla_servicios').empty();



        var obj_filtros = new Object();
        obj_filtros.servicios_nombre = $('#txt_nombre_servicio').val();                
        obj_filtros.servicios_categoria_id = $("#select_categoria_servicio").val()==undefined ? -1 : $("#select_categoria_servicio").val();        
                

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_servicios_controller.php',
            data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response); 
            
                    if(jsonData.length==0){
                        $('#datos_tabla_servicios').append('<tr style="pointer-events: none;"><td colspan="4">No se han encontrado resultados</td></tr>');
                    }

                    for(var i=0;i<jsonData.length;i++){
                        
                        var fila = new Object();                
                        fila.servicios_id=jsonData[i].servicios_id;
                        fila.servicios_categoria_id=jsonData[i].servicios_categoria_id;
                        fila.servicios_descripcion=jsonData[i].servicios_descripcion;
                        fila.servicios_nombre=jsonData[i].servicios_nombre;
                        fila.servicios_duracion=jsonData[i].servicios_duracion;
                        fila.servicios_precio=jsonData[i].servicios_precio; 
                        fila.cls_nombre_categoria=jsonData[i].cls_nombre_categoria;                       

                        var contenido="";
                                            
                        contenido +="<tr onClick='fila_click_servicios("+JSON.stringify(fila)+")'> "+
                                        '<td>'+ fila.servicios_nombre +'</td> '+
                                        '<td>'+ fila.cls_nombre_categoria +'</td> '+
                                        '<td>'+ fila.servicios_duracion +' min</td> '+
                                        '<td>$ '+ fila.servicios_precio +'.00</td> '+
                                    '</tr>';

                        $('#datos_tabla_servicios').append(contenido);
                    }

                }catch(ex_ajax){

                    alert("[consultar_servicios -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_servicios -> function]: " + ex);
    }
}


function agregar_servicios(){
    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.servicios_nombre = $("#txt_nombre_edit_servicio").val();
        obj_filtros.servicios_descripcion =$("#txt_descripcion_edit_servicio").val();
        obj_filtros.servicios_duracion =$("#txt_duracion_edit_servicio").val();
        obj_filtros.servicios_precio =$("#txt_precio_edit_servicio").val();        
        obj_filtros.servicios_categoria_id =$("#select_categoria_edit_servicio").val();
                

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_servicios_controller.php',
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

                    alert("[agregar_servicios -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);
                $(".loader").fadeOut("slow");                
            }
        });
        

        consultar_servicios();

    }catch(ex){
        alert("[agregar_servicios -> function]: " + ex);
    }
}


function actualizar_servicios(){

    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.servicios_id = $("#hid_servicios_id").val();
        obj_filtros.servicios_nombre = $("#txt_nombre_edit_servicio").val();
        obj_filtros.servicios_descripcion =$("#txt_descripcion_edit_servicio").val();
        obj_filtros.servicios_duracion =$("#txt_duracion_edit_servicio").val();
        obj_filtros.servicios_precio =$("#txt_precio_edit_servicio").val();        
        obj_filtros.servicios_categoria_id =$("#select_categoria_edit_servicio").val();
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_servicios_controller.php',
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

                alert("[actualizar_servicios -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);
            $(".loader").fadeOut("slow");                
        }
        });
        

        consultar_servicios();

    }catch(ex){
        alert("[actualizar_servicios -> function]: " + ex);
    }
}


function eliminar_servicios(){
    
    try{
            
        $(".loader").css("display","block");

        var clientes_id_tmp = $("#hid_servicios_id").val();
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_servicios_controller.php',
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

                    alert("[eliminar_servicios -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });
        
        $(".loader").fadeOut("slow");
        consultar_servicios();

    }catch(ex){
        alert("[eliminar_servicios -> function]: " + ex);
    }
}


function fila_click_servicios(fila){
    
    try{        
                                                
        $("#hid_servicios_id").val(fila.servicios_id);

        $("#btn_eliminar_servicio").removeClass("disabled");
        $("#btn_editar_servicio").removeClass("disabled");
        

        $("#txt_nombre_edit_servicio").val(fila.servicios_nombre);
        $("#select_categoria_edit_servicio").val(fila.servicios_categoria_id);
        $("#txt_descripcion_edit_servicio").val(fila.servicios_descripcion);
        $("#txt_duracion_edit_servicio").val(fila.servicios_duracion);
        $("#txt_precio_edit_servicio").val(fila.servicios_precio);        


    }catch(ex){
        alert("[fila_click_servicios -> function]: " + ex);
    }
}


function validar_campos_servicios(){

    var resultado = "";
    
    if($("#txt_nombre_edit_servicio").val()=="")
        resultado += "- El campo 'nombre' es un dato obligatorio.<br>"

    if($("#select_categoria_edit_servicio").val()==-1)
        resultado += "- El campo 'categoría' es un dato obligatorio.<br>"

    if($("#txt_descripcion_edit_servicio").val()=="")
        resultado += "- El campo 'descripción' es un dato obligatorio.<br>"

    if($("#txt_duracion_edit_servicio").val()=="")
        resultado += "- El campo 'duración' es un dato obligatorio.<br>"
    else if($("#txt_duracion_edit_servicio").val()<=0)
        resultado += "- El campo 'duración' es incorrecto.<br>"

    if($("#txt_precio_edit_servicio").val()=="")
        resultado += "- El campo 'precio' es un dato obligatorio.<br>"
    else if($("#txt_precio_edit_servicio").val()<=0)
        resultado += "- El campo 'precio' es incorrecto.<br>"

    return resultado;
}









function consultar_categorias(){
    try{
            
        $(".loader").css("display","block");
        vaciar_inputs_categorias();

        //limpiamos el contenido de la tabla
        $('#datos_tabla_categorias').empty();



        var obj_filtros = new Object();
        obj_filtros.categorias_nombre = $('#txt_nombre_categoria').val();                        
                

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_categorias_controller.php',
            data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response); 
            
                    if(jsonData.length==0){
                        $('#datos_tabla_categorias').append('<tr style="pointer-events: none;"><td colspan="2">No se han encontrado resultados</td></tr>');
                    }

                    for(var i=0;i<jsonData.length;i++){
                        
                        var fila = new Object();                
                        fila.categorias_id=jsonData[i].categorias_id;
                        fila.categorias_nombre=jsonData[i].categorias_nombre;
                        fila.categorias_descripcion=jsonData[i].categorias_descripcion;
                        
                        var contenido="";
                                            
                        contenido +="<tr onClick='fila_click_categorias("+JSON.stringify(fila)+")'> "+
                                        '<td>'+ fila.categorias_nombre +'</td> '+                                        
                                        '<td>'+ fila.categorias_descripcion +'</td> '+                                        
                                    '</tr>';

                        $('#datos_tabla_categorias').append(contenido);
                    }

                }catch(ex_ajax){

                    alert("[consultar_categorias -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_categorias -> function]: " + ex);
    }
}


function agregar_categorias(){
    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.categorias_nombre = $("#txt_nombre_edit_categoria").val();
        obj_filtros.categorias_descripcion =$("#txt_descripcion_edit_categoria").val();        
                

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_categorias_controller.php',
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

                    alert("[agregar_categorias -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);
                $(".loader").fadeOut("slow");                
            }
        });
        

        consultar_categorias();

    }catch(ex){
        alert("[agregar_categorias -> function]: " + ex);
    }
}


function actualizar_categorias(){

    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.categorias_id = $("#hid_categorias_id").val();
        obj_filtros.categorias_nombre = $("#txt_nombre_edit_categoria").val();
        obj_filtros.categorias_descripcion =$("#txt_descripcion_edit_categoria").val();        
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_categorias_controller.php',
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

                alert("[actualizar_categorias -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);
            $(".loader").fadeOut("slow");                
        }
        });
        

        consultar_categorias();

    }catch(ex){
        alert("[actualizar_categorias -> function]: " + ex);
    }
}


function eliminar_categorias(){
    
    try{
            
        $(".loader").css("display","block");

        var clientes_id_tmp = $("#hid_categorias_id").val();
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/catalogos/cat_categorias_controller.php',
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

                    alert("[eliminar_categorias -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });
        
        $(".loader").fadeOut("slow");
        consultar_categorias();

    }catch(ex){
        alert("[eliminar_categorias -> function]: " + ex);
    }
}


function fila_click_categorias(fila){
    
    try{        
                                                
        $("#hid_categorias_id").val(fila.categorias_id);

        $("#btn_eliminar_categoria").removeClass("disabled");
        $("#btn_editar_categoria").removeClass("disabled");
        

        $("#txt_nombre_edit_categoria").val(fila.categorias_nombre);        
        $("#txt_descripcion_edit_categoria").val(fila.categorias_descripcion);
               


    }catch(ex){
        alert("[fila_click_categorias -> function]: " + ex);
    }
}


function validar_campos_categorias(){

    var resultado = "";
    
    if($("#txt_nombre_edit_categoria").val()=="")
        resultado += "- El campo 'nombre' es un dato obligatorio.<br>"

    if($("#txt_descripcion_edit_categoria").val()==-1)
        resultado += "- El campo 'descripción' es un dato obligatorio.<br>"
    

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
                    
                    datos = JSON.parse(datos);
                    
                    //console.log(datos);
                    document.getElementById(id_combo).innerHTML += "<option value='-1'>- seleccionar -</option>";

                    for (var i = 0; i < datos.length; i++) {

                        document.getElementById(id_combo).innerHTML += "<option value='" + datos[i].id + "'>" + datos[i].texto + "</option>";
                    }                    

                    $('#' + id_combo).val(-1);                    
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


function vacias_inputs(){
    $(".panel_edit_inputs input").val("");
    $("#select_categoria_edit_servicio").val(-1);
    $("#txt_descripcion_edit_servicio").val("");
}



function vaciar_inputs_categorias(){
    $(".panel_edit_inputs input").val("");    
    $("#txt_descripcion_edit_categoria").val("");
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