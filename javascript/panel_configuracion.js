
Array_Configuraciones = [];
Array_Descansos = [];


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
        $("#nav_configuracion").addClass("activo");

        consultar_configuracion();

    }catch(ex){
        alert("error [inicializar_pagina -> function]: " + ex);
    }
    
}



function eventos(){

    $("#btn_guardar").on('click',function(e){
        e.preventDefault();

        Swal.fire({
            title: '¿Quieres guardar los cambios?',            
            showCancelButton: true,
            icon: 'question',
            confirmButtonText: `Guardar`,
          }).then((result) => {

            
            if (result.isConfirmed) {

                var evaluacion = validar_configuracion();
                if(evaluacion!=""){

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
                        title: '<span style="font-weight:bold; font-size:18px;">Error de validación:</span><br><br> ' + evaluacion
                    });
    
    
                    return false;
                }

                actualizar_configuracion();     
                actualizar_horarios_descansos();                         
            }
        });
    });


    $("#btn_cancelar").on('click',function(e){
        e.preventDefault();

        try{
            
            Swal.fire({
                title: '¿Realmente quieres cancelar?<br><span style="font-size:15px;">Se perderá cualquier configuración que no hayas guardado</span>',
                showCancelButton: true,
                icon: 'question',
                confirmButtonText: `Cancelar`,
            }).then((result) => {

                
                if (result.isConfirmed) {
                    window.location.reload();
                    consultar_configuracion();
                }
            });
            
        }catch(ex){
            alert("error [btn_cancelar -> click]: " + ex);
        }
    });


    $("#btn_agregar_descanso").on('click',function(e){

        try{
            e.preventDefault();

            $("#hid_descansos_id").val("");
            $("#select_dia_modal").val("Lunes");
            $("#txt_hora_inicio_modal").val("");
            $("#txt_hora_final_modal").val("");

            $("#modal_descanso").modal('show');

        }catch(ex){
            alert("error [btn_agregar_descanso -> click]: " + ex);
        }
    });





    $("#btn_guardar_modal").on('click',function(e){
        
        try{
            e.preventDefault();

            
            var evaluacion="";
            if($("#txt_hora_inicio_modal").val() == ""){
                evaluacion+="- La hora de inicio es un datos necesario<br>";
            }else{
                if($("#txt_hora_inicio_modal").val()<=0 || $("#txt_hora_inicio_modal").val()>=25){
                    evaluacion+="- La hora de inicio es incorrecta<br>";
                }
            }

            if($("#txt_hora_final_modal").val() == ""){
                evaluacion+="- La hora final es un datos necesario<br>";
            }else{
                if($("#txt_hora_final_modal").val()<=0 || $("#txt_hora_final_modal").val()>=25){
                    evaluacion+="- La hora final es incorrecta<br>";
                }
            }


            if(evaluacion!=""){

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
                    title: '<span style="font-weight:bold; font-size:18px;">Error de validación:</span><br><br> ' + evaluacion
                });


                return false;
            }




            if($("#hid_descansos_id").val()==""){

                var item = new Object();
                item.descansos_id = Array_Descansos.length+1;
                item.descansos_inicio = $("#txt_hora_inicio_modal").val();
                item.descansos_final = $("#txt_hora_final_modal").val();
                item.descansos_dia = $("#select_dia_modal").val();

                Array_Descansos.push(item);
                actualizar_tabla_descansos();
                $("#modal_descanso").modal('hide');

            }else{

                for(var i=0;i<Array_Descansos.length;i++){
                    if(Array_Descansos[i].descansos_id == $("#hid_descansos_id").val()){

                        Array_Descansos[i].descansos_dia = $("#select_dia_modal").val();
                        Array_Descansos[i].descansos_inicio = $("#txt_hora_inicio_modal").val();
                        Array_Descansos[i].descansos_final = $("#txt_hora_final_modal").val();
                        break;
                    }
                }

                actualizar_tabla_descansos();
                $("#modal_descanso").modal('hide');
            }
            

        }catch(ex){
            alert("error [btn_guardar_modal -> click] :" + ex);
        }
        
    });




    $("#cbk_lunes").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_lunes_inicio").val("");
            $("#txt_horario_lunes_final").val("");
            $("#txt_horario_lunes_inicio").prop('disabled', true);
            $("#txt_horario_lunes_final").prop('disabled', true);
        }else{
            $("#txt_horario_lunes_inicio").prop('disabled', false);
            $("#txt_horario_lunes_final").prop('disabled', false);
        }
    });

    $("#cbk_martes").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_martes_inicio").val("");
            $("#txt_horario_martes_final").val("");
            $("#txt_horario_martes_inicio").prop('disabled', true);
            $("#txt_horario_martes_final").prop('disabled', true);
        }else{
            $("#txt_horario_martes_inicio").prop('disabled', false);
            $("#txt_horario_martes_final").prop('disabled', false);
        }
    });

    $("#cbk_miercoles").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_miercoles_inicio").val("");
            $("#txt_horario_miercoles_final").val("");
            $("#txt_horario_miercoles_inicio").prop('disabled', true);
            $("#txt_horario_miercoles_final").prop('disabled', true);
        }else{
            $("#txt_horario_miercoles_inicio").prop('disabled', false);
            $("#txt_horario_miercoles_final").prop('disabled', false);
        }
    });

    $("#cbk_jueves").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_jueves_inicio").val("");
            $("#txt_horario_jueves_final").val("");
            $("#txt_horario_jueves_inicio").prop('disabled', true);
            $("#txt_horario_jueves_final").prop('disabled', true);
        }else{
            $("#txt_horario_jueves_inicio").prop('disabled', false);
            $("#txt_horario_jueves_final").prop('disabled', false);
        }
    });

    $("#cbk_viernes").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_viernes_inicio").val("");
            $("#txt_horario_viernes_final").val("");
            $("#txt_horario_viernes_inicio").prop('disabled', true);
            $("#txt_horario_viernes_final").prop('disabled', true);
        }else{
            $("#txt_horario_viernes_inicio").prop('disabled', false);
            $("#txt_horario_viernes_final").prop('disabled', false);
        }
    });

    $("#cbk_sabado").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_sabado_inicio").val("");
            $("#txt_horario_sabado_final").val("");
            $("#txt_horario_sabado_inicio").prop('disabled', true);
            $("#txt_horario_sabado_final").prop('disabled', true);
        }else{
            $("#txt_horario_sabado_inicio").prop('disabled', false);
            $("#txt_horario_sabado_final").prop('disabled', false);
        }
    });

    $("#cbk_domingo").change(function(){
        
        if($(this).prop('checked')==false){
            $("#txt_horario_domingo_inicio").val("");
            $("#txt_horario_domingo_final").val("");
            $("#txt_horario_domingo_inicio").prop('disabled', true);
            $("#txt_horario_domingo_final").prop('disabled', true);
        }else{
            $("#txt_horario_domingo_inicio").prop('disabled', false);
            $("#txt_horario_domingo_final").prop('disabled', false);
        }
    });


    $("#file_logo").change(function(){

        subir_archivo();
        
        var input = document.getElementById("file_logo");
        var fReader = new FileReader();

        fReader.readAsDataURL(input.files[0]);
        fReader.onloadend = function(event){
            
            $('#img_logo').attr("src", event.target.result);
        }
    });
}



function subir_archivo(){

    if($('#file_logo').val()=="" || $('#file_logo').val()==null){
      
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
            title: 'Favor de cargar la imagen antes'
        });
  
      return false;
  
    }else{        
  
      var data = new FormData();
      var files = $('#file_logo')[0].files[0];
      data.append('file_lista', files);
  
      $.ajax({          
        url: '../controladores/utils/upload_file.php',
        type: "POST",
        dataType:'Json',
        async:false,
        data: data,                               
        processData: false,
        contentType: false,
        success: function (datos) {                                                 
  
          if(datos.mensaje=="error"){            

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
                title: 'Ha ocurrido un error cargando el archivo, favor de intentarlo mas tarde: <br><br>' + datos.detalles
            });
  
            return false;
  
          }else{
                        
            return true;              
          }
        } 
      });
    }
}




function actualizar_configuracion(){

    try{
            
        $(".loader").css("display","block");        
        

        arreglo_configuracion = [];
        arreglo_configuracion.push(nuevo_obj("nombre_empresa","info_empresa",$("#txt_nombre_empresa").val()));
        
        arreglo_configuracion.push(nuevo_obj("enviar_correo","envio_correos",$("#ckb_envio_correos").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("cuenta_correo","envio_correos",$("#txt_cuenta_correo").val()));
        arreglo_configuracion.push(nuevo_obj("clave_correo","envio_correos",$("#txt_clave_correo").val()));
        
        arreglo_configuracion.push(nuevo_obj("nombre_cliente","validacion_cliente",$("#ckb_nombre_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("apellido_p_cliente","validacion_cliente",$("#ckb_apellido_p_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("apellido_m_cliente","validacion_cliente",$("#ckb_apellido_m_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("edad_cliente","validacion_cliente",$("#ckb_edad_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("correo_cliente","validacion_cliente",$("#ckb_correo_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("telefono_cliente","validacion_cliente",$("#ckb_telefono_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("direccion_cliente","validacion_cliente",$("#ckb_direccion_validar").is(":checked").toString()));
        arreglo_configuracion.push(nuevo_obj("sexo_cliente","validacion_cliente",$("#ckb_sexo_validar").is(":checked").toString()));
                
        arreglo_configuracion.push(nuevo_obj("horario_lunes_inicio","horarios",$("#txt_horario_lunes_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_lunes_final","horarios",$("#txt_horario_lunes_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_martes_inicio","horarios",$("#txt_horario_martes_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_martes_final","horarios",$("#txt_horario_martes_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_miercoles_inicio","horarios",$("#txt_horario_miercoles_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_miercoles_final","horarios",$("#txt_horario_miercoles_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_jueves_inicio","horarios",$("#txt_horario_jueves_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_jueves_final","horarios",$("#txt_horario_jueves_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_viernes_inicio","horarios",$("#txt_horario_viernes_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_viernes_final","horarios",$("#txt_horario_viernes_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_sabado_inicio","horarios",$("#txt_horario_sabado_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_sabado_final","horarios",$("#txt_horario_sabado_final").val()));
        arreglo_configuracion.push(nuevo_obj("horario_domingo_inicio","horarios",$("#txt_horario_domingo_inicio").val()));
        arreglo_configuracion.push(nuevo_obj("horario_domingo_final","horarios",$("#txt_horario_domingo_final").val()));
        
        if($('#file_logo').val()!="" && $('#file_logo').val()!=null){
            arreglo_configuracion.push(nuevo_obj("imagen_editada","clase","valor"));
        }
        
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/configuracion_controller.php',
            data: {"funcion" : "actualizar", "obj_filtros": JSON.stringify(arreglo_configuracion)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response);                     
            
                    if(jsonData.mensaje=="correcto"){
                        Swal.fire('Se han guardado los cambios correctamente', '', 'success');
                    }else{
                        Swal.fire('Ha ocurrido un error guardando los cambios, favor de intentarlo de nuevo más tarde', '', 'error');
                    }
                                                   

                }catch(ex_ajax){

                    alert("[actualizar_configuracion -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });
        
        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[actualizar_configuracion -> function]: " + ex);
    }
}


function consultar_configuracion(){

    try{
            
        $(".loader").css("display","block");        
        

        var obj_filtros = new Object();
        obj_filtros.configuracion_clase = "";
        
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/configuracion_controller.php',
            data: {"funcion" : "consultar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    var jsonData = JSON.parse(response); 
            
                    
                    for(var i=0;i<jsonData.length;i++){

                        var fila = new Object();                
                        fila.configuracion_id=jsonData[i].configuracion_id;
                        fila.configuracion_nombre=jsonData[i].configuracion_nombre;
                        fila.configuracion_clase=jsonData[i].configuracion_clase;
                        fila.configuracion_valor=jsonData[i].configuracion_valor;
                        
                        Array_Configuraciones.push(fila);                        
                    }


                    //console.log(Array_Configuraciones);
                    $("#txt_nombre_empresa").val(get_valor("nombre_empresa"));
                    
                    $("#ckb_envio_correos").prop("checked", JSON.parse(get_valor("enviar_correo")));
                    $("#txt_cuenta_correo").val(get_valor("cuenta_correo"));
                    $("#txt_clave_correo").val(get_valor("clave_correo"));
                    
                    $("#ckb_nombre_validar").prop("checked", JSON.parse(get_valor("nombre_cliente")));
                    $("#ckb_apellido_p_validar").prop("checked", JSON.parse(get_valor("apellido_p_cliente")));
                    $("#ckb_apellido_m_validar").prop("checked", JSON.parse(get_valor("apellido_m_cliente")));
                    $("#ckb_edad_validar").prop("checked", JSON.parse(get_valor("edad_cliente")));
                    $("#ckb_correo_validar").prop("checked", JSON.parse(get_valor("correo_cliente")));
                    $("#ckb_telefono_validar").prop("checked", JSON.parse(get_valor("telefono_cliente")));
                    $("#ckb_direccion_validar").prop("checked", JSON.parse(get_valor("direccion_cliente")));
                    $("#ckb_sexo_validar").prop("checked", JSON.parse(get_valor("sexo_cliente")));
                    

                    $("#txt_horario_lunes_inicio").val(get_valor("horario_lunes_inicio"));
                    $("#txt_horario_lunes_final").val(get_valor("horario_lunes_final"));
                    $("#txt_horario_martes_inicio").val(get_valor("horario_martes_inicio"));
                    $("#txt_horario_martes_final").val(get_valor("horario_martes_final"));
                    $("#txt_horario_miercoles_inicio").val(get_valor("horario_miercoles_inicio"));
                    $("#txt_horario_miercoles_final").val(get_valor("horario_miercoles_final"));
                    $("#txt_horario_jueves_inicio").val(get_valor("horario_jueves_inicio"));                    
                    $("#txt_horario_jueves_final").val(get_valor("horario_jueves_final"));                    
                    $("#txt_horario_viernes_inicio").val(get_valor("horario_viernes_inicio"));
                    $("#txt_horario_viernes_final").val(get_valor("horario_viernes_final"));
                    $("#txt_horario_sabado_inicio").val(get_valor("horario_sabado_inicio"));
                    $("#txt_horario_sabado_final").val(get_valor("horario_sabado_final"));
                    $("#txt_horario_domingo_inicio").val(get_valor("horario_domingo_inicio"));
                    $("#txt_horario_domingo_final").val(get_valor("horario_domingo_final"));
                    

                    if($("#txt_horario_lunes_inicio").val()==""){
                        $("#cbk_lunes").prop("checked", false);
                        $("#txt_horario_lunes_inicio").prop('disabled', true);
                        $("#txt_horario_lunes_final").prop('disabled', true);
                    }else{
                        $("#cbk_lunes").prop("checked", true);
                    }

                    if($("#txt_horario_martes_inicio").val()==""){
                        $("#cbk_martes").prop("checked", false);
                        $("#txt_horario_martes_inicio").prop('disabled', true);
                        $("#txt_horario_martes_final").prop('disabled', true);
                    }else{
                        $("#cbk_martes").prop("checked", true);
                    }

                    if($("#txt_horario_miercoles_inicio").val()==""){
                        $("#cbk_miercoles").prop("checked", false);
                        $("#txt_horario_miercoles_inicio").prop('disabled', true);
                        $("#txt_horario_miercoles_final").prop('disabled', true);
                    }else{
                        $("#cbk_miercoles").prop("checked", true);
                    }

                    if($("#txt_horario_jueves_inicio").val()==""){
                        $("#cbk_jueves").prop("checked", false);
                        $("#txt_horario_jueves_inicio").prop('disabled', true);
                        $("#txt_horario_jueves_final").prop('disabled', true);
                    }else{
                        $("#cbk_jueves").prop("checked", true);
                    }

                    if($("#txt_horario_viernes_inicio").val()==""){
                        $("#cbk_viernes").prop("checked", false);
                        $("#txt_horario_viernes_inicio").prop('disabled', true);
                        $("#txt_horario_viernes_final").prop('disabled', true);
                    }else{
                        $("#cbk_viernes").prop("checked", true);
                    }

                    if($("#txt_horario_sabado_inicio").val()==""){
                        $("#cbk_sabado").prop("checked", false);
                        $("#txt_horario_sabado_inicio").prop('disabled', true);
                        $("#txt_horario_sabado_final").prop('disabled', true);
                    }else{
                        $("#cbk_sabado").prop("checked", true);
                    }

                    if($("#txt_horario_domingo_inicio").val()==""){
                        $("#cbk_domingo").prop("checked", false);                        
                        $("#txt_horario_domingo_inicio").prop('disabled', true);
                        $("#txt_horario_domingo_final").prop('disabled', true);
                    }else{
                        $("#cbk_domingo").prop("checked", true);
                    }

                }catch(ex_ajax){

                    alert("[consultar_configuracion -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");
        consultar_descansos();

    }catch(ex){
        alert("[consultar_configuracion -> function]: " + ex);
    }
}


function validar_configuracion(){

    var resultado ="";

    if($("#cbk_lunes").prop("checked")==true){

        if($("#txt_horario_lunes_inicio").val()==""){
            resultado+="-El campo 'inicio lunes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_lunes_inicio").val()<=0 || $("#txt_horario_lunes_inicio").val()>=25){
                resultado+="-El campo 'inicio lunes' es incorrecto<br>";
             }
        }

        if($("#txt_horario_lunes_final").val()==""){
            resultado+="-El campo 'final lunes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_lunes_final").val()<=0 || $("#txt_horario_lunes_final").val()>=25){
                resultado+="-El campo 'final lunes' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_martes").prop("checked")==true){

        if($("#txt_horario_martes_inicio").val()==""){
            resultado+="-El campo 'inicio martes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_martes_inicio").val()<=0 || $("#txt_horario_martes_inicio").val()>=25){
                resultado+="-El campo 'inicio martes' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_martes_final").val()==""){
            resultado+="-El campo 'final martes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_martes_final").val()<=0 || $("#txt_horario_martes_final").val()>=25){
                resultado+="-El campo 'final martes' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_miercoles").prop("checked")==true){

        if($("#txt_horario_miercoles_inicio").val()==""){
            resultado+="-El campo 'inicio miercoles' es un dato necesario<br>";
        }else{
             if($("#txt_horario_miercoles_inicio").val()<=0 || $("#txt_horario_miercoles_inicio").val()>=25){
                resultado+="-El campo 'inicio miercoles' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_miercoles_final").val()==""){
            resultado+="-El campo 'final miercoles' es un dato necesario<br>";
        }else{
             if($("#txt_horario_miercoles_final").val()<=0 || $("#txt_horario_miercoles_final").val()>=25){
                resultado+="-El campo 'final miercoles' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_jueves").prop("checked")==true){

        if($("#txt_horario_jueves_inicio").val()==""){
            resultado+="-El campo 'inicio jueves' es un dato necesario<br>";
        }else{
             if($("#txt_horario_jueves_inicio").val()<=0 || $("#txt_horario_jueves_inicio").val()>=25){
                resultado+="-El campo 'inicio jueves' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_jueves_final").val()==""){
            resultado+="-El campo 'final jueves' es un dato necesario<br>";
        }else{
             if($("#txt_horario_jueves_final").val()<=0 || $("#txt_horario_jueves_final").val()>=25){
                resultado+="-El campo 'final jueves' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_viernes").prop("checked")==true){

        if($("#txt_horario_viernes_inicio").val()==""){
            resultado+="-El campo 'inicio viernes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_viernes_inicio").val()<=0 || $("#txt_horario_viernes_inicio").val()>=25){
                resultado+="-El campo 'inicio viernes' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_viernes_final").val()==""){
            resultado+="-El campo 'final viernes' es un dato necesario<br>";
        }else{
             if($("#txt_horario_viernes_final").val()<=0 || $("#txt_horario_viernes_final").val()>=25){
                resultado+="-El campo 'final viernes' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_sabado").prop("checked")==true){

        if($("#txt_horario_sabado_inicio").val()==""){
            resultado+="-El campo 'inicio sabado' es un dato necesario<br>";
        }else{
             if($("#txt_horario_sabado_inicio").val()<=0 || $("#txt_horario_sabado_inicio").val()>=25){
                resultado+="-El campo 'inicio sabado' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_sabado_final").val()==""){
            resultado+="-El campo 'final sabado' es un dato necesario<br>";
        }else{
             if($("#txt_horario_sabado_final").val()<=0 || $("#txt_horario_sabado_final").val()>=25){
                resultado+="-El campo 'final sabado' es incorrecto<br>";
             }
        }
    }

    if($("#cbk_domingo").prop("checked")==true){

        if($("#txt_horario_domingo_inicio").val()==""){
            resultado+="-El campo 'inicio domingo' es un dato necesario<br>";
        }else{
             if($("#txt_horario_domingo_inicio").val()<=0 || $("#txt_horario_domingo_inicio").val()>=25){
                resultado+="-El campo 'inicio domingo' es incorrecto<br>";
             }
        }
    
        if($("#txt_horario_domingo_final").val()==""){
            resultado+="-El campo 'final domingo' es un dato necesario<br>";
        }else{
             if($("#txt_horario_domingo_final").val()<=0 || $("#txt_horario_domingo_final").val()>=25){
                resultado+="-El campo 'final domingo' es incorrecto<br>";
             }
        }
    }


    if($("#ckb_envio_correos").prop("checked")==true){

        if($("#txt_cuenta_correo").val()==""){
            resultado += "-El campo 'cuenta de correo' es un dato necesario<br>";
        }else{
            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            
            if(regex.test($("#txt_cuenta_correo").val())==false){
                resultado += "- El campo 'correo' es incorrecto.<br>";
            }
        }

        if($("#txt_clave_correo").val()==""){
            resultado+="-El campo 'contraseña de correo' es un dato necesario<br>";
        }
    }

    

    if($("#txt_nombre_empresa").val()==""){
        resultado+="-El campo 'nombre de la empresa' es un dato necesario<br>";
    }


    return resultado;
}




function consultar_descansos(){

    try{
            
        $(".loader").css("display","block");
        
        //limpiamos el contenido de la tabla
        $('#datos_tabla_descansos').empty();
        
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/descansos_controller.php',
            data: {"funcion" : "consultar"},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response); 
                                

                    for(var i=0;i<jsonData.length;i++){

                        var fila = new Object();                
                        fila.descansos_id=jsonData[i].descansos_id;
                        fila.descansos_dia=jsonData[i].descansos_dia;
                        fila.descansos_inicio=jsonData[i].descansos_inicio;
                        fila.descansos_final=jsonData[i].descansos_final;                                          

                        Array_Descansos.push(fila);

                        var contenido = "";
                        contenido +="<tr> "+
                                        "<td>"+ fila.descansos_dia +"</td> "+
                                        "<td>"+ fila.descansos_inicio +"</td> "+
                                        "<td>"+ fila.descansos_final +"</td> "+
                                        "<td> "+
                                            "<button class='btn btn-outline-primary' onclick='editar_descanso_click("+JSON.stringify(fila)+")'><i class='fa fa-edit'></i></button> "+
                                            "<button class='btn btn-outline-danger' onclick='eliminar_descanso_click("+fila.descansos_id+")'><i class='fa fa-trash'></i></button> "+
                                        "</td> "+
                                    "</tr";

                        $('#datos_tabla_descansos').append(contenido);
                    }

                }catch(ex_ajax){

                    alert("[consultar_descansos -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_descansos -> function]: " + ex);
    }
}


function actualizar_tabla_descansos(){

    $('#datos_tabla_descansos').empty();

    for(var i=0;i<Array_Descansos.length;i++){

        var contenido = "";
        contenido +="<tr> "+
                        "<td>"+ Array_Descansos[i].descansos_dia +"</td> "+
                        "<td>"+ Array_Descansos[i].descansos_inicio +"</td> "+
                        "<td>"+ Array_Descansos[i].descansos_final +"</td> "+
                        "<td> "+
                            "<button class='btn btn-outline-primary' onclick='editar_descanso_click("+JSON.stringify(Array_Descansos[i])+")'><i class='fa fa-edit'></i></button> "+
                            "<button class='btn btn-outline-danger' onclick='eliminar_descanso_click("+Array_Descansos[i].descansos_id+")'><i class='fa fa-trash'></i></button> "+
                        "</td> "+
                    "</tr";

        $('#datos_tabla_descansos').append(contenido);
    }
}


function editar_descanso_click(fila){

    try{

        $("#hid_descansos_id").val(fila.descansos_id);
        $("#select_dia_modal").val(fila.descansos_dia);
        $("#txt_hora_inicio_modal").val(fila.descansos_inicio);
        $("#txt_hora_final_modal").val(fila.descansos_final);

        $("#modal_descanso").modal('show');
        

    }catch(ex){
        alert("error [editar_descanso_click -> function]: " + ex);
    }
}


function eliminar_descanso_click(id){
    
    try{

        Swal.fire({
            title: '¿Quieres eliminar este registro?',            
            showCancelButton: true,
            icon: 'question',
            confirmButtonText: `Eliminar`,
          }).then((result) => {

            
            if (result.isConfirmed) {

                for(var i=0;i<Array_Descansos.length;i++){
                    if(Array_Descansos[i].descansos_id == id){
                        
                        Array_Descansos.splice(i,1);
                    }
                }


                actualizar_tabla_descansos();
            }
        });

    }catch(ex){
        alert("error [eliminar_descanso_click -> function]: " + ex);
    }
}


function actualizar_horarios_descansos(){

    try{
            
        $(".loader").css("display","block");                        
                
        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/descansos_controller.php',
            data: {"funcion" : "actualizar", "obj_filtros": JSON.stringify(Array_Descansos)},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response);                     
            
                    if(jsonData.mensaje!="correcto"){
                        Swal.fire('Ha ocurrido un error guardando los horarios de descansos, favor de intentarlo de nuevo más tarde', '', 'error');
                    }
                                                   

                }catch(ex_ajax){

                    alert("[actualizar_configuracion -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });
        
        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[actualizar_configuracion -> function]: " + ex);
    }
}







function nuevo_obj(nombre,clase,valor){

    var item = new Object();
    item.configuracion_nombre = nombre;
    item.configuracion_clase = clase;
    item.configuracion_valor = valor;

    return item;
}


function get_valor(configuracion_nombre){

    resultado = "";

    for(var i=0;i<Array_Configuraciones.length;i++){
        if(Array_Configuraciones[i].configuracion_nombre == configuracion_nombre){

            resultado = Array_Configuraciones[i].configuracion_valor;
            break;
        }
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
               /*  $("#nav_calendario").css("display","none"); */
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