var Calendar_Obj=null;

var Array_Horarios = [];
var Servicio_Seleccionado=null;

var Array_Validacion_Datos_Cliente = [];
var Cliente_ID=0;

var Fecha_Actual_Calendar = null;

var Usuiaro_ID = 0;
var Usuario_Rol = "";

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
        $("#nav_calendario").addClass("activo");

        var calendarEl = document.getElementById('calendar');
        Calendar_Obj = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            //height: 750,
            themeSystem: 'bootstrap',
            eventOrder: "description",
            dayMaxEvents: true, // allow "more" link when too many events                                    
            
            eventClick: function(info) {
                                                
                var datos="";
                for(var i=0;i<info.event.classNames.length;i++){
                    datos+=info.event.classNames[i] + " ";
                }

                var json_datos = JSON.parse(datos);       
                //console.log(json_datos);         
                
                var contenido = '<span style="font-weight:bold; font-size:20px;">Datos de la cita</span><br><br>' +
                '<span style="font-size:18px;"><span style="font-weight:bold;">Servicio: </span>'+json_datos.servicios_nombre+'</span><br>' +
                '<span style="font-size:18px;"><span style="font-weight:bold;">Proveedor: </span>'+json_datos.proveedores_nombre_completo+'</span><br><br>' +

                '<span style="font-weight:bold;">Fecha: </span>' + json_datos.citas_fecha + "<br>" +
                '<span style="font-weight:bold;">Hora: </span>' + json_datos.citas_hora + "<br>" +
                '<span style="font-weight:bold;">Notas: </span>' + json_datos.citas_notas + "<br>" +
                '<span style="font-weight:bold;">Lugar: </span>' + json_datos.citas_sala + "<br><br>" +

                '<span style="font-weight:bold;">Cliente: </span>' + json_datos.clientes_nombre_completo + "<br>" +                
                '<span style="font-weight:bold;">Teléfono: </span>' + json_datos.clientes_telefono + "<br>" +                
                '<span style="font-weight:bold;">Correo: </span>' + json_datos.clientes_correo;
                

                                  
                Swal.fire({
                                            
                    toast:true,
                    width: 500,                                    
                    showConfirmButton: true,
                    confirmButtonText: `Editar`,
                    showCancelButton: true,
                    icon: 'info',
                    title: contenido                    

                }).then((result) => {
                
                    if (result.isConfirmed) {
                        
                        Cliente_ID = json_datos.clientes_id;
                        $("#hid_cita_id").val(json_datos.citas_id);
                        $("#hid_cambio_estatus").val("");
                        $("#hid_cambio_fecha_hora").val("");

                        $("#select_estatus_modal").val(json_datos.citas_estatus);

                        $("#txt_nota_modal").val(json_datos.citas_notas);                           
                        $("#date_fecha_modal").val(json_datos.citas_fecha);
                        $("#select_servicio_modal").val(json_datos.servicios_id);
                        $("#select_cliente_modal").val(json_datos.clientes_id);
                        $("#select_sala_modal").val(json_datos.citas_sala);
                        
                        _llenar_combo_proveedores(json_datos.servicios_id);
                        $('#select_proveedor_modal').val(json_datos.citas_proveedor_id);                        

                        $("#date_fecha_modal").prop("disabled",false);
                        consultar_info_servicio(json_datos.servicios_id);
                        generar_lista_horarios(json_datos.citas_fecha);
                        document.getElementById('select_hora_modal').innerHTML += "<option value='"+json_datos.citas_hora+"'>"+json_datos.citas_hora+"</option>";
                        $("#select_hora_modal").val(json_datos.citas_hora);


                        $("#btn_cancelar").css("display","none");
                        $("#btn_agregar_cliente").css("display","block");
                        $("#contenedor_nuevo_cliente").css("display","none");
                        $("#select_cliente_modal").prop("disabled",false);

                        $("#modal_cita").modal('show');
                    }
                });
                
            },

            eventDrop: function(info) {

                var datos="";
                for(var i=0;i<info.event.classNames.length;i++){
                    datos+=info.event.classNames[i] + " ";
                }
                var json_datos = JSON.parse(datos);                 
                
                
                if(Usuiaro_ID != json_datos.citas_proveedor_id && Usuario_Rol=="Proveedor"){

                    const Toast_a = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                      
                    Toast_a.fire({
                        icon: 'warning',
                        title: 'No puedes modificar las citas de otro proveedor, favor de contactar al administrador del sistema para verificar.'
                    });
    
                    info.revert();
                    return false;
                }



                //console.log(info);      
                var fecha_seleccionada=new Date(obtener_fecha(info.event.start));
                fecha_seleccionada.setHours(23);
                fecha_seleccionada.setMinutes(59);
                fecha_seleccionada.setSeconds(0);
                var fecha_actual=new Date();
                fecha_actual.setDate(fecha_actual.getDate() + (-1));

                if(fecha_seleccionada<fecha_actual){

                    const Toast_a = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                      
                    Toast_a.fire({
                        icon: 'error',
                        title: 'La fecha seleccionada ya ha pasado. Favor de seleccionar otra'
                    });

                    info.revert();
                    return false;
                }


                

                Swal.fire({
                    heightAuto: false,
                    backdrop:false,
                    title: '¿Realmente quieres cambiar la cita a la fecha '+obtener_fecha(info.event.start)+'?',
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonText: `Cambiar`,
                }).then((result) => {
    
                    
                    if (result.isConfirmed) {

                        var resultado = reagendar_cita(info.event.id,obtener_fecha(info.event.start));                        
                        if(resultado!=""){

                            Swal.fire({
                                heightAuto: false,
                                backdrop:false,
                                title: resultado,
                                icon: 'error',
                                confirmButtonText: `Aceptar`,
                            });

                            info.revert();

                        }else{

                            var json_txt = "";
                            for(var i=0;i<info.event.classNames.length;i++){
                                json_txt+= info.event.classNames[i] + " ";
                            }
                            var json_obj = JSON.parse(json_txt);
                            
                            notificar_correo_reagendar(json_obj.clientes_nombre_completo,json_obj.clientes_correo,json_obj.servicios_nombre,json_obj.citas_proveedor_id,json_obj.citas_fecha,json_obj.citas_hora);




                            var fecha = Fecha_Actual_Calendar;
                            consultar_citas_mes(fecha.substring(0,7));
                        }

                    }else{
                        info.revert();
                    }
                });
            },

            eventDidMount: function(info) {
                                                
                $(info.el).prop("title",info.event.title);                
            }
        });
        Calendar_Obj.render();
        Fecha_Actual_Calendar = obtener_fecha(Calendar_Obj.currentData.currentDate);


        _llenar_combo_servicios();
        consultar_horarios();
        _llenar_combo_clientes();
        consultar_validaciones_cliente();
        consultar_citas_sin_sala();
        

        var fecha_tmp = Fecha_Actual_Calendar;
        consultar_citas_mes(fecha_tmp.substring(0,7));

    }catch(ex){
        alert("error [inizializar_pagina -> function] :" + ex);
    }
}


function eventos(){

    
    $("#btn_agregar_cita").on('click',function(e){
        e.preventDefault();

        try{
            
            limpiar_modal();
            $("#modal_cita").modal('show');

        }catch(ex){
            alert("error [btn_agregar_cita -> click]: " + ex);
        }
    });



    $("#btn_agregar_cliente").on('click',function(e){
        e.preventDefault();

        try{
            
            $(this).css("display","none");
            $("#btn_cancelar").css("display","block");
            $("#contenedor_nuevo_cliente").css("display","block");
            $("#select_cliente_modal").val("-1");
            $("#select_cliente_modal").prop("disabled",true);

            Cliente_ID=0;

        }catch(ex){
            alert("error [btn_agregar_cliente -> click]: " + ex);
        }
    });
    


    $("#btn_cancelar").on('click',function(e){
        e.preventDefault();

        try{
            
            $("#txt_nombre_modal").val("");
            $("#txt_apellido_p_modal").val("");
            $("#txt_apellido_p_modal").val("");
            $("#txt_telefono_modal").val("");
            $("#txt_domicilio_modal").val("");
            $("#txt_correo_modal").val("");    
            $("#txt_edad_modal").val("");

            $(this).css("display","none");
            $("#btn_agregar_cliente").css("display","block");
            $("#contenedor_nuevo_cliente").css("display","none");
            $("#select_cliente_modal").prop("disabled",false);
            

        }catch(ex){
            alert("error [btn_cancelar -> click]: " + ex);
        }
    });


    $("#btn_guardar_modal").on('click',function(e){
        e.preventDefault();

        try{


            var validacion = validar_campos_modal();
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


            //si se esta registando una nueva cita
            if($("#hid_cita_id").val()==""){

                if(Usuiaro_ID != $("#select_proveedor_modal").val() && Usuario_Rol=="Proveedor"){

                    const Toast_a = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                      
                    Toast_a.fire({
                        icon: 'warning',
                        title: 'No puedes agendar citas para otro proveedor, favor de contactar al administrador del sistema para verificar.'
                    });
                        
                    return false;
                }




                if(Cliente_ID==0){
                    registrar_cliente();
                }

                registrar_cita();


            //si se esta editando una cita
            }else{


                if(Usuiaro_ID != $("#select_proveedor_modal").val() && Usuario_Rol=="Proveedor"){

                    const Toast_a = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                      
                    Toast_a.fire({
                        icon: 'warning',
                        title: 'No puedes modificar las citas de otro proveedor, favor de contactar al administrador del sistema para verificar.'
                    });
    
                    
                    return false;
                }








                if(Cliente_ID==0){
                    registrar_cliente();
                }

                actualizar_cita($("#hid_cita_id").val());
                $("#modal_cita").modal('hide');

                
                $(".loader").css("display","block");
                notificar_correo();
                $(".loader").css("display","none");
            } 
            
            
            var fecha = Fecha_Actual_Calendar;
            consultar_citas_mes(fecha.substring(0,7));

        }catch(ex){
            alert("error [btn_guardar_modal -> click]: " + ex);
        }
    });



    $("#select_servicio_modal").change(function(){

        try{
        
            _llenar_combo_proveedores($("#select_servicio_modal").val());            
            consultar_info_servicio($(this).val());

            $("#date_fecha_modal").val("");
            $('#select_hora_modal option').remove();

            $("#date_fecha_modal").prop("disabled",false);

        }catch(ex){
            alert("error [select_servicio -> change]: " + ex);
        }
    });


    $("#select_servicio").change(function(){

        try{
        
            _llenar_combo_proveedores_filtro($("#select_servicio").val());                        
            
            var fecha = Fecha_Actual_Calendar;
            consultar_citas_mes(fecha.substring(0,7));

        }catch(ex){
            alert("error [select_servicio -> change]: " + ex);
        }
    });


    $("#select_estatus").change(function(){

        try{

            if($("#select_servicio").val()!=-1){
                                
                var fecha = Fecha_Actual_Calendar;
                consultar_citas_mes(fecha.substring(0,7));
            }

        }catch(ex){
            alert("error [select_servicio -> change]: " + ex);
        }
    });


    $("#chk_citas_pasadas").change(function(){
        try{
                    
            var fecha = Fecha_Actual_Calendar;
            consultar_citas_mes(fecha.substring(0,7));

        }catch(ex){
            alert("error [select_servicio -> change]: " + ex);
        }
    });


    $(".fc-next-button").on('click',function(e){
                
        Fecha_Actual_Calendar = obtener_fecha(Calendar_Obj.currentData.viewApi.currentStart);        
        consultar_citas_mes(Fecha_Actual_Calendar.substring(0,7));
    });

    $(".fc-prev-button").on('click',function(e){
                
        Fecha_Actual_Calendar = obtener_fecha(Calendar_Obj.currentData.viewApi.currentStart);        
        consultar_citas_mes(Fecha_Actual_Calendar.substring(0,7));
    });



    $("#select_proveedor").change(function(){

        try{
                                
            var fecha = Fecha_Actual_Calendar;
            consultar_citas_mes(fecha.substring(0,7));

        }catch(ex){
            alert("error [select_proveedor -> change]: " + ex);
        }
    });


    $("#select_proveedor_modal").change(function(){

        try{
                                
            $("#date_fecha_modal").val("");            
            $('#select_hora_modal option').remove();
            

        }catch(ex){
            alert("error [select_proveedor_modal -> change]: " + ex);
        }
    });


    $("#btn_buscar").on('click',function(e){
        
        try{
        
            e.preventDefault();

            var fecha = Fecha_Actual_Calendar;
            consultar_citas_mes(fecha.substring(0,7));

        }catch(ex){
            alert("error [btn_buscar -> click]: " + ex);
        }
    });


    $("#date_fecha_modal").change(function(){
        
        try{

            var fecha_seleccionada=new Date($("#date_fecha_modal").val());
            var fecha_actual=new Date();
            fecha_actual.setDate(fecha_actual.getDate() + (-1));

            if(fecha_seleccionada<fecha_actual){
                
                const Toast_a = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                  
                Toast_a.fire({
                    icon: 'error',
                    title: 'La fecha seleccionada ya ha pasado. Favor de seleccionar otra'
                });

                $("#date_fecha_modal").val("");
                return false;
            }

            



            if(Servicio_Seleccionado!=null){

                $("#hid_cambio_fecha_hora").val("cambio");
                
                generar_lista_horarios($(this).val());
                document.getElementById('select_hora_modal').innerHTML += "<option value='selecciona'>- seleccionar -</option>";
                $("#select_hora_modal").val("selecciona");
                
                if($("#select_hora_modal option").length==1){
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                      
                    Toast.fire({
                        icon: 'error',
                        title: 'La fecha seleccionada no tiene horarios disponibles, favor de seleccionar otra'
                    });
                }
            }

        }catch(ex){
            alert("error [date_fecha_modal -> change] :" + ex);
        }
    });    


    $("#select_cliente_modal").change(function(){

        try{
        
            Cliente_ID = $("#select_cliente_modal").val();

        }catch(ex){
            alert("error [select_servicio -> change]: " + ex);
        }
    });

    $("#select_estatus_modal").change(function(){            

        if($(this).val()=="cancelado"){
            $("#hid_cambio_estatus").val("cambio");
        }else{
            $("#hid_cambio_estatus").val("");
        }
    });


    $("#select_hora_modal").change(function(){

        try{

            if($(this).val()!="selecciona"){

                $("#select_sala_modal").val("");

                //habilitamos todas las opciones de las salas
                $("#select_sala_modal option").each(function() {                                                
                    $(this).attr('disabled',false);                
                });


                //consultamos todas las citas que se tengan para ese dia, para evaluar em que horarios ya no se tendrian disponibles las salas en las que ya se les haya registrado una cita
                $.ajax({
                    type: 'POST',
                    url: '../controladores/operaciones/citas_controller.php',
                    data: {"funcion" : 'consultar_salas_ocupadas',"fecha": $("#date_fecha_modal").val()},
                    async: false,            
                    success: function (data) {

                        //console.log(data);
                        var datos = JSON.parse(data);

                        if(datos.length>=1){

                            for(var i=0;i<datos.length;i++){

                                //evaluamos si la hora seleccionada cae dentro de alguna otra en la que ya se tenga una cita
                                if(evaluar_entre_horas(datos[i].hora_inicio,sumar_minutos(datos[i].hora_inicio,datos[i].duracion),$("#select_hora_modal").val())==true){
                                    
                                    //deshabilitamos la sala que ya se tiene ocupada para esa hora
                                    $("#select_sala_modal option").each(function() {
                                        
                                        if($(this).val()==datos[i].citas_sala){

                                            $(this).attr('disabled',true);
                                        }                                
                                    });                            
                                }
                            }
                        }
                    
                    },
                    error: function (datos) {
                        alert(datos.responseText);
                    }
                });
            }

        }catch(ex){
            alert("error [select_hora_modal->change] : " + ex);
        }
    });


    $("#txt_telefono_modal").keydown(function(e) {
        var key = e.charCode || e.keyCode || 0;

        if($("#txt_telefono_modal").val().length==10){
            
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 ||
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40));
        }
    });


    $("#modal_cita").on('hidden.bs.modal', function () {
        consultar_citas_sin_sala();
    });
}






function validar_campos_modal(){

    var resultado = "";
    

    if($("#select_servicio_modal").val()=="-1"){
        resultado += "- El campo 'servicio' es un dato obligatorio.<br>"
    }
    
    if($("#date_fecha_modal").val()==""){
        resultado += "- El campo 'fecha' es un dato obligatorio.<br>"
    }

    if($("#select_hora_modal").val()==null || $("#select_hora_modal").val()=="selecciona"){
        resultado += "- El campo 'hora' es un dato obligatorio.<br>"
    }


    if($("#select_cliente_modal").prop("disabled")==true){

        if(obtener_campo_validacion("nombre_cliente")=="true"){
            if($("#txt_nombre_modal").val()=="")
                resultado += "- El campo 'nombre' es un dato obligatorio.<br>"
        }

        if(obtener_campo_validacion("apellido_p_cliente")=="true"){
            if($("#txt_apellido_p_modal").val()=="")
                resultado += "- El campo 'apellido paterno' es un dato obligatorio.<br>"
        }

        if(obtener_campo_validacion("apellido_m_cliente")=="true"){
            if($("#txt_apellido_m_modal").val()=="")
                resultado += "- El campo 'apellido materno' es un dato obligatorio.<br>"
        }

        if(obtener_campo_validacion("telefono_cliente")=="true"){
            if($("#txt_telefono_modal").val()=="")
                resultado += "- El campo 'telefono' es un dato obligatorio.<br>"

            else if($("#txt_telefono_modal").val().length!=10)
                resultado += "- El campo 'telefono' es incorrecto.<br>"
        }
        
        if(obtener_campo_validacion("correo_cliente")=="true"){
            if($("#txt_correo_modal").val()==""){
                resultado += "- El campo 'correo' es un dato obligatorio.<br>"
            }
            else{

                var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            
                if(regex.test($("#txt_correo_modal").val())==false){
                    resultado += "- El campo 'correo' es incorrecto.<br>";
                }
            }

        }

        if(obtener_campo_validacion("direccion_cliente")=="true"){
            if($("#txt_direccion_modal").val()=="")    
                resultado += "- El campo 'direccion' es un dato obligatorio.<br>"
        }

        if(obtener_campo_validacion("edad_cliente")=="true"){
            if($("#txt_edad_modal").val()=="")
                resultado += "- El campo 'edad' es un dato obligatorio.<br>"

            else if(parseInt($("#txt_edad_modal").val(),10)<=0 || parseInt($("#txt_edad_edit").val(),10)>=150)
                resultado += "- El campo 'edad' es incorrecto.<br>"
        }

    }else{

        if($("#select_cliente_modal").val()=="-1"){
            resultado += "- El campo 'cliente' es un dato obligatorio.<br>"
        }
    }

    if($("#select_sala_modal").val()==""){
        resultado += "- El campo 'Sala' es un dato obligatorio.<br>"
    }


    return resultado;
}




function consultar_citas_mes(fecha){
    
    $(".loader").css("display","block");

    var filtros = new Object();
    filtros.citas_fecha = fecha;
    filtros.citas_servicios_id = $("#select_servicio").val();
    filtros.citas_proveedor_id = $("#select_proveedor").val();
    filtros.citas_estatus = $("#select_estatus").val();
    filtros.citas_sala = $("#select_sala").val()==null?"":$("#select_sala").val();
    filtros.citas_atendidas = $("#chk_citas_pasadas").prop('checked')==false?"":"1";    



    try {         
        
        
        Calendar_Obj.removeAllEvents();         
        
        $.ajax({
            type: 'POST',
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : 'consultar_cls',"obj_filtros": JSON.stringify(filtros)},
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    try{

                        //console.log(datos);
                        datos = JSON.parse(datos);                         
                        
                        for(var i=0;i<datos.length;i++){
                                      
                            var color_cita="green";
                            if($("#select_estatus").val()=="cancelado"){
                                color_cita="gray";
                            }

                            var fecha_cita = new Date(datos[i].citas_fecha);
                            fecha_cita.setHours(23);
                            fecha_cita.setMinutes(59);
                            fecha_cita.setSeconds(59);
                            var fecha_actual = new Date();
                            fecha_actual.setDate(fecha_actual.getDate() + (-1));
                            if(fecha_cita<fecha_actual){
                                color_cita="orange";
                            }



                            Calendar_Obj.addEvent({
                                id:datos[i].citas_id,
                                description:i,                                
                                title: datos[i].clientes_nombre_completo + " (" + datos[i].citas_hora + ")",
                                classNames: JSON.stringify(datos[i]),
                                editable: true,        
                                start: datos[i].citas_fecha,
                                allDay: true,
                                color:color_cita       
                            });                            
                        }
                        

                    }catch (ex) {
                        alert('Error [consultar_citas_mes -> ajax]' + ex);
                    }
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
        

    } catch (e) {
        alert('Error [consultar_citas_mes -> function]' + e);
    }

    $(".loader").fadeOut("slow");
  
}



function notificar_correo(){    
    
    if($("#hid_cita_id").val()==""){
        return false;
    }


    try{
                    
        var obj_filtros = new Object();
        obj_filtros.configuracion_clase = "envio_correos";        
                        
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
                    
                    var envio_activo=false;
                    var correo="";
                    var clave="";

                    for(var i=0;i<jsonData.length;i++){

                        if(jsonData[i].configuracion_nombre=="enviar_correo"){                            
                            envio_activo=JSON.parse(jsonData[i].configuracion_valor);
                        }

                        if(jsonData[i].configuracion_nombre=="cuenta_correo"){
                            correo=jsonData[i].configuracion_valor;
                        }

                        if(jsonData[i].configuracion_nombre=="clave_correo"){
                            clave=jsonData[i].configuracion_valor;
                        }
                    }

                    

                    if(envio_activo==true){

                        var correo_destino="";
                        var nombre_cliente=$("#select_cliente_modal option:selected").text();
                        var correo_proveedor="";
                        var telefono_proveedor="";
                        var nombre_proveedor=$("#select_proveedor_modal option:selected").text();
                        var nombre_servicio=$("#select_servicio_modal option:selected").text();
                        var mensaje="";
                        var nombre_empresa="";


                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/catalogos/cat_clientes_controller.php',
                            data: {
                                "funcion" : "consultar_por_id",
                                "id": $("#select_cliente_modal").val()                                
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);
                                    correo_destino=jsonData[0].clientes_correo;                                    
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_cliente]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });



                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/catalogos/cat_usuarios_controller.php',
                            data: {
                                "funcion" : "consultar_por_id",
                                "id": $("#select_proveedor_modal").val()                                
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                                                         
                                    correo_proveedor=jsonData[0].usuarios_correo;
                                    telefono_proveedor=jsonData[0].usuarios_telefono;
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_proveedor]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });



                        var filtro=new Object();
                        filtro.configuracion_clase="info_empresa";
                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/operaciones/configuracion_controller.php',
                            data: {
                                "funcion" : "consultar",
                                "obj_filtros": JSON.stringify(filtro)
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                                                         
                                    nombre_empresa=jsonData[0].configuracion_valor;                                    
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_empresa]: " + ex_ajax);                                    
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });
                        


                        if($("#hid_cambio_estatus").val()!=""){

                            mensaje+="<img src='cid:logo_nn' alt='Logo' width='100' height='100'/><br>";
                            mensaje+="<h1>" + nombre_empresa + "</h1><br>";
                            
                            mensaje+="<span style='font-weight:bold'>Estimad@ " + nombre_cliente + ".</span><br>";
                            mensaje+="Se le notifica que su cita agendada para el servicio de " + nombre_servicio + ". Ha sido cancelada<br><br>";
                            mensaje+="Datos de la cita:<br>";
                            mensaje+="<ul>";                            
                            mensaje+="<li>Fecha: " + $("#date_fecha_modal").val() + "</li>";
                            mensaje+="<li>Hora: " + $("#select_hora_modal").val() + "</li>";                                                        
                            mensaje+="</ul>";
                            mensaje+="<br><br><br>Si no reconoce el motivo de la cancelación, favor de contactar al proveedor del servicio para confirmar.<br>";
                            mensaje+="<ul>";                            
                            mensaje+="<li>Nombre: " + nombre_proveedor + "</li>";
                            mensaje+="<li>Teléfono: " + telefono_proveedor + "</li>";
                            mensaje+="<li>Correo: " + correo_proveedor + "</li>";
                            mensaje+="</ul>";                            

                        }else if($("#hid_cambio_fecha_hora").val()!=""){
                        
                            mensaje+="<img src='cid:logo_nn' alt='Logo' width='100' height='100'/><br>";
                            mensaje+="<h1>" + nombre_empresa + "</h1><br>";
                            
                            mensaje+="<span style='font-weight:bold'>Estimad@ " + nombre_cliente + ".</span><br>";
                            mensaje+="Se le notifica que los datos de su cita para el servicio de " + nombre_servicio + " han cambiado.<br><br>";
                            mensaje+="Datos de la cita:<br>";
                            mensaje+="<ul>";                            
                            mensaje+="<li>Fecha: " + $("#date_fecha_modal").val() + "</li>";
                            mensaje+="<li>Hora: " + $("#select_hora_modal").val() + "</li>";                            
                            mensaje+="<li>Notas extras: " + $("#txt_nota").val() + "</li>";
                            mensaje+="</ul>";
                            mensaje+="<br><br><br>Si no reconoce el cambio, favor de contactar al proveedor del servicio:<br>";
                            mensaje+="<ul>";                            
                            mensaje+="<li>Nombre: " + nombre_proveedor + "</li>";
                            mensaje+="<li>Teléfono: " + telefono_proveedor + "</li>";
                            mensaje+="<li>Correo: " + correo_proveedor + "</li>";
                            mensaje+="</ul>";
                        }else{

                            return false;
                        }
                        
                        

                       

                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/utils/enviar_mail.php',
                            data: {
                                "correo_origen" : correo,
                                "clave": clave,
                                "correo_destino":correo_destino,
                                "asunto":"Modificación cita agendada",
                                "mensaje_html":mensaje,
                                "imagen":"../../img/logotipo.jpg"
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                     
                                    if(jsonData.mensaje!="correcto"){

                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Ha ocurrido un error enviando el correo, pero su cita ha sido registrada. Favor de contactar con administración para verificar',
                                            icon: 'error',
                                            confirmButtonText: 'aceptar'              
                                        });
                                    }
                                    
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_envio]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });
                    }




                }catch(ex_ajax){

                    alert("[enviar_correo -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("Error [enviar_correo -> function]: " + ex);
    }    
}


function notificar_correo_reagendar(nombre_cliente_prm,correo_cliente_prm,nombre_servicio_prm,proveedor_id_prm,fecha_prm,hora_prm){    
        
    try{
                    
        var obj_filtros = new Object();
        obj_filtros.configuracion_clase = "envio_correos";        
                        
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
                    
                    var envio_activo=false;
                    var correo="";
                    var clave="";

                    for(var i=0;i<jsonData.length;i++){

                        if(jsonData[i].configuracion_nombre=="enviar_correo"){                            
                            envio_activo=JSON.parse(jsonData[i].configuracion_valor);
                        }

                        if(jsonData[i].configuracion_nombre=="cuenta_correo"){
                            correo=jsonData[i].configuracion_valor;
                        }

                        if(jsonData[i].configuracion_nombre=="clave_correo"){
                            clave=jsonData[i].configuracion_valor;
                        }
                    }

                    

                    if(envio_activo==true){

                        var correo_destino=correo_cliente_prm;
                        var nombre_cliente=nombre_cliente_prm;                        
                        var nombre_servicio=nombre_servicio_prm;
                        var mensaje="";
                        var nombre_empresa="";

                        var correo_proveedor="";
                        var telefono_proveedor="";
                        var nombre_proveedor="";


                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/catalogos/cat_usuarios_controller.php',
                            data: {
                                "funcion" : "consultar_por_id",
                                "id": proveedor_id_prm
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                                                         
                                    correo_proveedor=jsonData[0].usuarios_correo;
                                    telefono_proveedor=jsonData[0].usuarios_telefono;
                                    nombre_proveedor=jsonData[0].usuarios_nombre + " " + jsonData[0].usuarios_apellido_p + " " + jsonData[0].usuarios_apellido_m;
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_proveedor]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });



                        var filtro=new Object();
                        filtro.configuracion_clase="info_empresa";
                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/operaciones/configuracion_controller.php',
                            data: {
                                "funcion" : "consultar",
                                "obj_filtros": JSON.stringify(filtro)
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                                                         
                                    nombre_empresa=jsonData[0].configuracion_valor;                                    
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_empresa]: " + ex_ajax);                                    
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });
                        

                        mensaje+="<img src='cid:logo_nn' alt='Logo' width='100' height='100'/><br>";
                        mensaje+="<h1>" + nombre_empresa + "</h1><br>";
                        
                        mensaje+="<span style='font-weight:bold'>Estimad@ " + nombre_cliente + ".</span><br>";
                        mensaje+="Se le notifica que su cita para el servicio de " + nombre_servicio + ". Ha sido reagendada. Los nuevos datos de la cita son los siguientes:<br><br>";
                        mensaje+="Datos de la cita:<br>";
                        mensaje+="<ul>";                            
                        mensaje+="<li>Fecha: " + fecha_prm + "</li>";
                        mensaje+="<li>Hora: " + hora_prm + "</li>";                                                        
                        mensaje+="</ul>";
                        mensaje+="<br><br><br>Si no reconoce el motivo del cambio, favor de contactar al proveedor del servicio para confirmar.<br>";
                        mensaje+="<ul>";                            
                        mensaje+="<li>Nombre: " + nombre_proveedor + "</li>";
                        mensaje+="<li>Teléfono: " + telefono_proveedor + "</li>";
                        mensaje+="<li>Correo: " + correo_proveedor + "</li>";
                        mensaje+="</ul>"; 
                        
                                               

                        $.ajax({

                            type: "POST",
                            async: false,
                            url: '../controladores/utils/enviar_mail.php',
                            data: {
                                "correo_origen" : correo,
                                "clave": clave,
                                "correo_destino":correo_destino,
                                "asunto":"Modificación cita agendada",
                                "mensaje_html":mensaje,
                                "imagen":"../../img/logotipo.jpg"
                            },
                            success: function(response)
                            {                
                
                                try{
                                    
                                    //console.log(response);
                                    var jsonData = JSON.parse(response);                     
                                    if(jsonData.mensaje!="correcto"){

                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Ha ocurrido un error enviando el correo, pero su cita ha sido registrada. Favor de contactar con administración para verificar',
                                            icon: 'error',
                                            confirmButtonText: 'aceptar'              
                                        });
                                    }
                                    
                
                                }catch(ex_ajax){
                
                                    alert("[enviar_correo -> ajax_envio]: " + ex_ajax);
                                }
                
                            },
                            error: function(e){
                                
                                alert(e.responseText);                
                            }
                        });
                    }




                }catch(ex_ajax){

                    alert("[enviar_correo -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("Error [enviar_correo -> function]: " + ex);
    }    
}





function _llenar_combo_servicios() {
        
    try {
        
        $('#select_servicio_modal option').remove();
        $('#select_servicio option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_servicios_controller.php',
            data: {"funcion" : 'combo_servicios'},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                                        
                    document.getElementById('select_servicio_modal').innerHTML += "<option value='-1'>- seleccionar -</option>";
                    document.getElementById('select_servicio').innerHTML += "<option value='-1'>- Todos -</option>";

                    array_categorias = [];
                    for (var i = 0; i < datos.length; i++) {
                        if(array_categorias.indexOf(datos[i].extra)==-1)
                            array_categorias.push(datos[i].extra);
                    }

                    var contenido = "";
                    for(var j=0;j<array_categorias.length;j++){
                        
                        contenido += "<optgroup label='"+array_categorias[j]+"'>";

                        for (var i = 0; i < datos.length; i++) {

                            if(datos[i].extra == array_categorias[j])
                                contenido += "<option value='" + datos[i].id + "'>" + datos[i].texto + "</option>";
                        } 
                        
                        contenido += "</optgroup>";
                    }

                    document.getElementById('select_servicio_modal').innerHTML += contenido;
                    document.getElementById('select_servicio').innerHTML += contenido;
                                        
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [_llenar_combo_servicios -> function]' + e);
    }
}

function _llenar_combo_proveedores(id_servicio) {
        
    try {
        
        $('#select_proveedor_modal option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : 'consultar_usuarios_servicio', "id":id_servicio},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                       
                    if(datos.length==0)
                        document.getElementById('select_proveedor_modal').innerHTML += "<option value='-1'>- seleccionar -</option>";

                    
                    var contenido = "";                
                    for (var i = 0; i < datos.length; i++) {
                        
                        contenido += "<option value='" + datos[i].id + "'>" + datos[i].texto + "</option>";
                    } 
                     

                    document.getElementById('select_proveedor_modal').innerHTML += contenido;
                                        
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [_llenar_combo_proveedores -> function]' + e);
    }
}

function _llenar_combo_proveedores_filtro(id_servicio) {
        
    try {
        
        $('#select_proveedor option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : 'consultar_usuarios_servicio', "id":id_servicio},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                       
                    
                    document.getElementById('select_proveedor').innerHTML += "<option value='-1'>- Todos -</option>";

                    
                    var contenido = "";                
                    for (var i = 0; i < datos.length; i++) {
                        
                        contenido += "<option value='" + datos[i].id + "'>" + datos[i].texto + "</option>";
                    } 
                     

                    document.getElementById('select_proveedor').innerHTML += contenido;
                                        
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [_llenar_combo_proveedores_filtro -> function]' + e);
    }
}

function _llenar_combo_clientes() {
        
    try {
        
        var filtro = new Object();
        filtro.clientes_nombre="";
        filtro.clientes_apellido_p="";
        filtro.clientes_apellido_m="";
        $('#select_cliente_modal option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_clientes_controller.php',
            data: {"funcion" : 'consultar',"obj_filtros":JSON.stringify(filtro)},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                       
                    
                    document.getElementById('select_cliente_modal').innerHTML += "<option value='-1'>- seleccionar -</option>";

                    
                    var contenido = "";                
                    for (var i = 0; i < datos.length; i++) {
                        
                        contenido += "<option value='" + datos[i].clientes_id + "'>" + datos[i].clientes_nombre + " " + datos[i].clientes_apellido_p + " " + datos[i].clientes_apellido_m + "</option>";
                    } 
                     

                    document.getElementById('select_cliente_modal').innerHTML += contenido;
                                        
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [_llenar_combo_clientes -> function]' + e);
    }
}

function consultar_info_servicio(id_servicio) {
        
    try {
                
        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_servicios_controller.php',
            data: {"funcion" : 'consultar_info_servicio', "id":id_servicio},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);                    
                    Servicio_Seleccionado=datos[0];                                                              
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [consultar_info_servicio -> function]' + e);
    }
}







function consultar_horarios(){

    try {

        var filtros = new Object();
        filtros.configuracion_clase = "horarios";
                
        $.ajax({
            type: 'POST',
            url: '../controladores/operaciones/configuracion_controller.php',
            data: {"funcion" : 'consultar', "obj_filtros":JSON.stringify(filtros)},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    try{

                        //console.log(datos);
                        datos = JSON.parse(datos);   
                        Array_Horarios = datos;                        
         
                    }catch (ex) {
                        alert('Error [consultar_horarios -> ajax]' + ex);
                    }
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    } catch (e) {
        alert('Error [consultar_horarios -> function]' + e);
    }
}

function generar_lista_horarios(formato_fecha){
    
    //registros de configuracion
    if(Array_Horarios.length!=0){

        $('#select_hora_modal option').remove();

        var Xmas95 = new Date(formato_fecha);
        var weekday = Xmas95.getDay();        
        
        var array_horas_disponibles = [];

        var hora_inicial="";
        var hora_final="";

        for(var i=0;i<Array_Horarios.length;i++){
            
            if(weekday==0 && Array_Horarios[i].configuracion_nombre=="horario_lunes_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==0 && Array_Horarios[i].configuracion_nombre=="horario_lunes_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==1 && Array_Horarios[i].configuracion_nombre=="horario_martes_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==1 && Array_Horarios[i].configuracion_nombre=="horario_martes_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==2 && Array_Horarios[i].configuracion_nombre=="horario_miercoles_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==2 && Array_Horarios[i].configuracion_nombre=="horario_miercoles_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==3 && Array_Horarios[i].configuracion_nombre=="horario_jueves_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==3 && Array_Horarios[i].configuracion_nombre=="horario_jueves_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==4 && Array_Horarios[i].configuracion_nombre=="horario_viernes_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==4 && Array_Horarios[i].configuracion_nombre=="horario_viernes_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==5 && Array_Horarios[i].configuracion_nombre=="horario_sabado_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==5 && Array_Horarios[i].configuracion_nombre=="horario_sabado_final")
                hora_final = Array_Horarios[i].configuracion_valor;


            if(weekday==6 && Array_Horarios[i].configuracion_nombre=="horario_domingo_inicio")
                hora_inicial = Array_Horarios[i].configuracion_valor;
            
            if(weekday==6 && Array_Horarios[i].configuracion_nombre=="horario_domingo_final")
                hora_final = Array_Horarios[i].configuracion_valor;
        }

        
        if(hora_inicial==""){
            return false;
        }

        if(parseInt(hora_inicial,10)<10)
            hora_inicial = '0' + hora_inicial;


        //convertir minutos a horas para poder restar la ultima hora de consulta a la hroa final
        var valor_resta = Math.trunc(Servicio_Seleccionado.servicios_duracion / 60);


        var nueva_hora = hora_inicial +':00';
        array_horas_disponibles.push(nueva_hora);

        do{
            
            nueva_hora = sumar_minutos(nueva_hora,Servicio_Seleccionado.servicios_duracion);            
                        
            array_horas_disponibles.push(nueva_hora);
            
            if(nueva_hora.split(':')[0]==hora_final){
                array_horas_disponibles.splice((array_horas_disponibles.length-1),1);
            }

            var valor_hora_n = parseInt(nueva_hora.split(':')[0],10);
            var valor_hora_f = (parseInt(hora_final,10) - valor_resta);            

        }while(valor_hora_n < valor_hora_f);
                
        



        //------------- ELIMINAR HORARIOS DESCANSOS ------------------
        
        array_horario_descansos = consultar_descansos(weekday);

        if(array_horario_descansos.length!=0){

            array_horas_disponibles_tmp=[];
            
            for(var j=0;j<array_horas_disponibles.length;j++){


                for(var i=0;i<array_horario_descansos.length;i++){

                    if(evaluar_entre_horas(
                        array_horario_descansos[i].descansos_inicio,
                        array_horario_descansos[i].descansos_final,
                        array_horas_disponibles[j])==false
                        ){
                        
                        array_horas_disponibles_tmp.push(array_horas_disponibles[j]);

                    }
                }
            }

            array_horas_disponibles = array_horas_disponibles_tmp;
        }

        //------------- (fin eliminar horarios descansos) ------------






        //------------ ELIMINAR HORARIOS OCUPADOS -------------------
        
        array_citas_ocupadas = consultar_citas(formato_fecha);       

        if(array_citas_ocupadas.length!=0){


            for(var j=0;j<array_citas_ocupadas.length;j++){

                var index = array_horas_disponibles.indexOf(array_citas_ocupadas[j].citas_hora);
                if(index!=-1){
                    array_horas_disponibles.splice(index,1);
                }
            }
            
        }

        //------------ (fin eliminar horarios ocupados) -------------------
        


        //--------------- ELIMINAR HORAS QUE YA HAYAN PASADO -------------


        var fecha_seleccionada=new Date($("#date_fecha_modal").val());        
        var fecha_actual=new Date();
        fecha_actual.setDate(fecha_actual.getDate() + (-1));        
        
        if(fecha_actual.getDate() == fecha_seleccionada.getDate()){
            
            var array_tmp = [];
            var hora_actual = fecha_actual.getHours() + ":" + fecha_actual.getMinutes();            
            for(var i=0;i<array_horas_disponibles.length;i++){

                //evaluamos que la hora del array sea mayor que la hora actual
                if(comparar_dos_horas(array_horas_disponibles[i],hora_actual)==1){
                    array_tmp.push(array_horas_disponibles[i]);
                }
            }

            array_horas_disponibles = array_tmp;
        }

        //--------------- (fin eliminar horas que ya hayan pasado) -------





        //---- ELIMINAR HORAS OCUPADAS DEL PROVEEDOR (MISMA FECHA DIFERENTE SERVICIO) -------


        try {                
            
            $.ajax({
                type: 'POST',
                url: '../controladores/operaciones/citas_controller.php',
                data: {
                    "funcion" : 'consultar_horas_ocupadas',
                    "proveedor_id": $("#select_proveedor_modal").val(),
                    "fecha":formato_fecha
                },
                async: false,            
                success: function (datos) {
                    if (datos !== null) {
                        
                        try{

                            //console.log(datos);
                            datos = JSON.parse(datos);   

                            if(datos.length>=1){
                                    
                                var array_horas_ocupadas_tmp = [];
                                
                                //evaluamos si alguna hora de la lista cae dentro de los intervalos de horas ocupadas
                                for(var i=0;i<array_horas_disponibles.length;i++){

                                    for(var j=0;j<datos.length;j++){

                                        var hora_inicio_o = datos[j].hora_inicio;
                                        var hora_fin_o = sumar_minutos(datos[j].hora_inicio,datos[j].duracion);
                                        
                                        //econtramos todas las horas que el provvedor ya tenga ocupadas y que figuren en la lista diponibles
                                        if(evaluar_entre_horas(hora_inicio_o,hora_fin_o,array_horas_disponibles[i])==true){
                                            array_horas_ocupadas_tmp.push(array_horas_disponibles[i]);
                                            break;
                                        }
                                    }
                                }


                                //agregamos solo las horas que no aparezcan como ocupadas en array_horas_ocupadas_tmp
                                var array_temporal = [];
                                
                                var encontrado=false;
                                for(var i=0;i<array_horas_disponibles.length;i++){

                                    encontrado=false;
                                    for(var j=0;j<array_horas_ocupadas_tmp.length;j++){

                                        if(array_horas_disponibles[i]==array_horas_ocupadas_tmp[j]){
                                            encontrado=true;
                                            break;
                                        }
                                    }

                                    if(encontrado==false){
                                        array_temporal.push(array_horas_disponibles[i]);
                                    }
                                }

                                array_horas_disponibles = array_temporal;
                            }

                        }catch (ex) {
                            alert('Error [consultar_descansos -> ajax]' + ex);
                        }
                    }
                },
                error: function (datos) {
                    alert(datos.responseText);
                }
            });
            

        } catch (e) {
            alert('Error [consultar_descansos -> function]' + e);
        }

        //------------------ (fin eliminar horas ocupadas del proveedor) --------------------





        var contenido = "";                
        for (var i = 0; i < array_horas_disponibles.length; i++) {
            
            contenido += "<option value='" + array_horas_disponibles[i] + "'>" + array_horas_disponibles[i] + "</option>";
        } 
         

        document.getElementById('select_hora_modal').innerHTML += contenido;
          
    }
}



function comparar_dos_horas(hora_muestra,hora_referencia){

    var horas1 = parseInt(hora_muestra.split(":")[0],10);
    var minutos1 = parseInt(hora_muestra.split(":")[1],10);

    var horas2 = parseInt(hora_referencia.split(":")[0],10);
    var minutos2 = parseInt(hora_referencia.split(":")[1],10);
    
    if(horas1<horas2){
        return 2;
    }else if(horas1>horas2){
        return 1;
    }else if(horas1==horas2){

        if(minutos1<minutos2){
            return 2;
        }else if(minutos1>minutos2){
            return 1;
        }else{
          return 2;
        }
    }
}




function sumar_minutos(hora,minutos){

    if(hora.includes(':')==false){
        hora+=":00";
    }

    var hrs = parseInt(hora.split(':')[0],10);
    var min = parseInt(hora.split(':')[1],10);

    var min_add = parseInt(minutos,10);

    min += min_add;

    while(min>=60){
      
      min-= 60;
      hrs++;
    }
    
    var hora_res = hrs+'';
    if(hrs<10){
      hora_res = '0' + hrs;
    }
    
    var min_res = min;
    if(min<10){
      min_res = '0' + min;
    }



    if(hrs>=24 && min>=0){
      
      return '24:00';
      
    }else{
      
      return hora_res + ':' + min_res;
    }
}

function evaluar_entre_horas(hora_inicio,hora_final,hora){
  
    if(hora_inicio.toString().includes(':')==false){
        hora_inicio += ":00";
    }

    if(hora_final.toString().includes(':')==false){
        hora_final += ":00";
    }



    var hora_hrs = parseInt(hora.split(':')[0],10);
    var hora_min = parseInt(hora.split(':')[1],10);
    
    var hora_ini = parseInt(hora_inicio);
    var hora_fin = parseInt(hora_final);
    
    var hora_fin_min = parseInt(hora_final.split(':')[1],10);
    
    
    var estado=0;
    
    
    while(estado != 4 && estado != 2 && estado!=5){
      
      switch (estado) {
        
        case 0:
          
          if(hora_hrs >= hora_ini){
            estado=1;
          }else{
            estado=5;
          }
          
          break;
        
        
        case 1:
          
          if(hora_hrs < hora_fin){
            estado = 2;
          }else if (hora_hrs == hora_fin){
            estado = 3;
          }else{
            estado = 5;
          }
          
          break;
          
        case 3:
          
          if(hora_min < hora_fin_min){
            estado=4;
          }else{
            estado=5;
          }
          
          break;
          
          
      }
      
    }
    
    
    if(estado==2 || estado==4){
      return true;
    }else{
      return false
    }
}

function consultar_descansos(dia){

    var dias_semana = ["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
    
    try {
        
        array_resultado=[];
        
        $.ajax({
            type: 'POST',
            url: '../controladores/operaciones/descansos_controller.php',
            data: {"funcion" : 'consultar'},
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    try{

                        //console.log(datos);
                        datos = JSON.parse(datos);                    
                        
                        for(var i=0;i<datos.length;i++){
                            if(datos[i].descansos_dia==dias_semana[dia]){
                                array_resultado.push(datos[i]);
                            }
                        }
                                                

                    }catch (ex) {
                        alert('Error [consultar_descansos -> ajax]' + ex);
                    }
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });

        return array_resultado;

    } catch (e) {
        alert('Error [consultar_descansos -> function]' + e);
    }
}

function consultar_citas(fecha){
    
    var array_resultado=[];

    var filtros = new Object();
    filtros.citas_fecha = fecha;
    filtros.citas_servicios_id = $("#select_servicio_modal").val();
    filtros.citas_proveedor_id = $("#select_proveedor_modal").val();
    filtros.citas_sala = $("#select_sala_modal").val();
    filtros.citas_atendidas = "";

    try {                
        
        $.ajax({
            type: 'POST',
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : 'consultar',"obj_filtros": JSON.stringify(filtros)},
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    try{

                        //console.log(datos);
                        datos = JSON.parse(datos);                                                                    
                        array_resultado = datos;                                                                            

                    }catch (ex) {
                        alert('Error [consultar_citas -> ajax]' + ex);
                    }
                }
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });

        return array_resultado;

    } catch (e) {
        alert('Error [consultar_citas -> function]' + e);
    }
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
                        
                        if(fila.configuracion_nombre == "nombre_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_nombre_modal']").text($("label[for='txt_nombre_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "apellido_p_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_apellido_p_modal']").text($("label[for='txt_apellido_p_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "apellido_m_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_apellido_m_modal']").text($("label[for='txt_apellido_m_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "telefono_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_telefono_modal']").text($("label[for='txt_telefono_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "direccion_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_domicilio_modal']").text($("label[for='txt_domicilio_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "correo_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_correo_modal']").text($("label[for='txt_correo_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "sexo_cliente" && fila.configuracion_valor=="true")
                            $("label[for='select_sexo_modal']").text($("label[for='select_sexo_modal']").text() + " (*)");

                        if(fila.configuracion_nombre == "edad_cliente" && fila.configuracion_valor=="true")
                            $("label[for='txt_edad_modal']").text($("label[for='txt_edad_modal']").text() + " (*)");
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


function registrar_cliente(){


    resultado = true;

    try{
            
        $(".loader").css("display","block");

        
        var obj_filtros = new Object();

        obj_filtros.clientes_nombre = $("#txt_nombre_modal").val();
        obj_filtros.clientes_apellido_p =$("#txt_apellido_p_modal").val();
        obj_filtros.clientes_apellido_m =$("#txt_apellido_m_modal").val();
        obj_filtros.clientes_telefono =$("#txt_telefono_modal").val();
        obj_filtros.clientes_correo =$("#txt_correo_modal").val();
        obj_filtros.clientes_direccion =$("#txt_domicilio_modal").val();
        obj_filtros.clientes_sexo =$("#select_sexo option:selected").text();
        obj_filtros.clientes_edad = $("#txt_edad_modal").val() == "" ? 0 : parseInt($("#txt_edad_modal").val(),10);
                

        $.ajax({

        type: "POST",
        async: false,
        url: '../controladores/catalogos/cat_clientes_controller.php',
        data: {"funcion" : "agregar", "obj_filtros": JSON.stringify(obj_filtros)},
        success: function(response)
        {                

            try{
                                
                //console.log(response);
                var jsonData = JSON.parse(response); 
        
                $(".loader").fadeOut("slow");
                if(jsonData.mensaje!="correcto"){
                    
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error agregando el registro, intentalo de nuevo más tarde',
                        icon: 'error',
                        confirmButtonText: 'aceptar'              
                    });

                    resultado=false;

                }else{

                    Cliente_ID = jsonData.id;
                }
                
            }catch(ex_ajax){

                alert("[registrar_cliente -> ajax]: " + ex_ajax);
            }

        },
        error: function(e){
            
            alert(e.responseText);
            $(".loader").fadeOut("slow");                
        }
        });
                

    }catch(ex){
        alert("[registrar_cliente -> function]: " + ex);
    }

    return resultado;
}



function registrar_cita(){

    try{
        
        $(".loader").css("display","block");
        
        var obj_filtros = new Object();        
        obj_filtros.citas_servicios_id = $("#select_servicio_modal").val();
        obj_filtros.citas_proveedor_id = $("#select_proveedor_modal").val();
        obj_filtros.citas_clientes_id = Cliente_ID;        
        obj_filtros.citas_estatus = "activo";
        obj_filtros.citas_fecha = $("#date_fecha_modal").val();
        obj_filtros.citas_hora = $("#select_hora_modal").val();
        obj_filtros.citas_notas = $("#txt_nota_modal").val();        
        obj_filtros.citas_sala = $("#select_sala_modal").val();

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : "agregar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response);                     
                    
                    if(jsonData.mensaje=="correcto"){

                        Swal.fire({
                            title: 'La cita se ha registrado correctamente',                            
                            icon: 'success',
                            confirmButtonText: `Salir`,
                        }).then((result) => {
                                                                
                            $("#modal_cita").modal('hide');
                        });

                    }else{

                        Swal.fire({
                            title: 'Ha ocurrido un error registrando la cita, favor de intentarlo más tarde',                            
                            icon: 'error',
                            confirmButtonText: `Salir`,
                        }).then((result) => {
                                                                    
                            $("#modal_cita").modal('hide');
                        });
                    }
                    

                }catch(ex_ajax){

                    alert("[registrar_cita -> ajax]: " + ex_ajax);
                }

                $(".loader").fadeOut("slow");                

            },
            error: function(e){
                
                $(".loader").fadeOut("slow");                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("[registrar_cita -> function]: " + ex);
    }
}


function actualizar_cita(id){

    try{
        
        $(".loader").css("display","block");
        
        var obj_filtros = new Object();        
        obj_filtros.citas_id = id;
        obj_filtros.citas_servicios_id = $("#select_servicio_modal").val();
        obj_filtros.citas_proveedor_id = $("#select_proveedor_modal").val();
        obj_filtros.citas_clientes_id = Cliente_ID;        
        obj_filtros.citas_estatus = "activo";
        obj_filtros.citas_fecha = $("#date_fecha_modal").val();
        obj_filtros.citas_hora = $("#select_hora_modal").val();
        obj_filtros.citas_notas = $("#txt_nota_modal").val();        
        obj_filtros.citas_estatus = $("#select_estatus_modal").val();
        obj_filtros.citas_sala = $("#select_sala_modal").val();

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : "actualizar", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response);                     
                    
                    if(jsonData.mensaje=="correcto"){

                        Swal.fire({
                            title: 'La cita se ha registrado correctamente',                            
                            icon: 'success',
                            confirmButtonText: `Salir`,
                        }).then((result) => {
                                                                
                            $("#modal_cita").modal('hide');
                        });

                    }else{

                        Swal.fire({
                            title: 'Ha ocurrido un error actualizando la cita, favor de intentarlo más tarde',                            
                            icon: 'error',
                            confirmButtonText: `Salir`,
                        }).then((result) => {
                                                                    
                            $("#modal_cita").modal('hide');
                        });
                    }
                    

                }catch(ex_ajax){

                    alert("[registrar_cita -> ajax]: " + ex_ajax);
                }

                $(".loader").fadeOut("slow");                

            },
            error: function(e){
                
                $(".loader").fadeOut("slow");                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("[registrar_cita -> function]: " + ex);
    }
}


function reagendar_cita(id,fecha){
    
    try{

        var resultado = "";
        $(".loader").css("display","block");
                        

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : "reagendar", "id": id , "fecha":fecha},
            success: function(response)
            {                

                try{
                    
                    //console.log(response);
                    var jsonData = JSON.parse(response);                     
                    
                    if(jsonData.mensaje=="correcto"){

                        Swal.fire({
                            heightAuto: false,
                            backdrop:false,
                            title: 'La cita se ha registrado correctamente',                            
                            icon: 'success',
                            confirmButtonText: `Salir`,
                        }).then((result) => {
                                                                
                            $("#modal_cita").modal('hide');
                        });

                    }else{

                        resultado = jsonData.mensaje;
                    }
                    

                }catch(ex_ajax){

                    alert("[registrar_cita -> ajax]: " + ex_ajax);
                }

                $(".loader").fadeOut("slow");                

            },
            error: function(e){
                
                $(".loader").fadeOut("slow");                
                alert(e.responseText);                
            }
        });        

    }catch(ex){
        alert("[registrar_cita -> function]: " + ex);
    }

    return resultado;
}



function consultar_citas_sin_sala(){

    try{

        //consultamos todas las citas que se no tengan sala asignada
        $.ajax({
            type: 'POST',
            url: '../controladores/operaciones/citas_controller.php',
            data: {"funcion" : 'consultar_citas_sin_sala'},
            async: false,            
            success: function (data) {

                console.log(data);
                var datos = JSON.parse(data);

                if(datos.length>=1){

                    //buscamos cuales de esas citas le corresponden al proveedor logeado
                    var citas_pendientes=[];
                    for(var i=0;i<datos.length;i++){

                        if(Usuiaro_ID == datos[i].citas_proveedor_id){
                            citas_pendientes.push(datos[i]);
                        }
                    }

                    //si el usuario logeado tiene citas pendientes las mostramos
                    if(citas_pendientes.length>=1){
                        
                        var contenido = '<div style="width:100%; height:350px; max-height:350px; overflow-y:scroll;">'+
                                            '<div class="table-responsive" style="width:100%;">'+
                                                '<table class="table table-striped">'+
                                                    '<thead style="font-weight:bold;"><tr><td>Datos de la cita</td><td>Asignar</td></tr></thead>'+
                                                    '<tbody>';

                        for(var i=0;i<citas_pendientes.length;i++){

                            contenido += '<tr><td>' + citas_pendientes[i].clientes_nombre_completo + ' (' + citas_pendientes[i].citas_fecha + ', '+citas_pendientes[i].citas_hora+') ' + citas_pendientes[i].servicios_nombre + '</td>'+
                                         "<td><button class='btn btn-primary' onclick='activar_editar("+JSON.stringify(citas_pendientes[i])+")'>Editar</button></td></tr>";
                        }


                        contenido +=                '</tbody>'+
                                                '</table>'+
                                            '</div>'+
                                        '</div>';

                        Swal.fire({
                            title: 'Tienes nuevas citas registradas.<br> asígnales una ubicación',                            
                            width: 800,
                            padding: '10px',                            
                            html:contenido                                
                        });
                    }
                }
            
            },
            error: function (datos) {
                alert(datos.responseText);
            }
        });
    

    }catch(ex){
        alert("error [consultar_citas_sin_sala->function] : " + ex);
    }
}


function activar_editar(json_datos){

    //cerramos el modal en donde muestra todas las citas pendientes de sala
    swal.close();

    Cliente_ID = json_datos.clientes_id;
    $("#hid_cita_id").val(json_datos.citas_id);
    $("#hid_cambio_estatus").val("");
    $("#hid_cambio_fecha_hora").val("");

    $("#select_estatus_modal").val(json_datos.citas_estatus);

    $("#txt_nota_modal").val(json_datos.citas_notas);                           
    $("#date_fecha_modal").val(json_datos.citas_fecha);
    $("#select_servicio_modal").val(json_datos.servicios_id);
    $("#select_cliente_modal").val(json_datos.clientes_id);
    $("#select_sala_modal").val(json_datos.citas_sala);
    
    _llenar_combo_proveedores(json_datos.servicios_id);
    $('#select_proveedor_modal').val(json_datos.citas_proveedor_id);                        

    $("#date_fecha_modal").prop("disabled",false);
    consultar_info_servicio(json_datos.servicios_id);
    generar_lista_horarios(json_datos.citas_fecha);
    document.getElementById('select_hora_modal').innerHTML += "<option value='"+json_datos.citas_hora+"'>"+json_datos.citas_hora+"</option>";
    $("#select_hora_modal").val(json_datos.citas_hora);


    $("#btn_cancelar").css("display","none");
    $("#btn_agregar_cliente").css("display","block");
    $("#contenedor_nuevo_cliente").css("display","none");
    $("#select_cliente_modal").prop("disabled",false);





    //preparamos la consulta para que no seleccione una sala ocupada
    try{

        if($("#select_hora_modal").val()!="selecciona"){

            $("#select_sala_modal").val("");

            //habilitamos todas las opciones de las salas
            $("#select_sala_modal option").each(function() {                                                
                $(this).attr('disabled',false);                
            });


            //consultamos todas las citas que se tengan para ese dia, para evaluar em que horarios ya no se tendrian disponibles las salas en las que ya se les haya registrado una cita
            $.ajax({
                type: 'POST',
                url: '../controladores/operaciones/citas_controller.php',
                data: {"funcion" : 'consultar_salas_ocupadas',"fecha": $("#date_fecha_modal").val()},
                async: false,            
                success: function (data) {

                    //console.log(data);
                    var datos = JSON.parse(data);

                    if(datos.length>=1){

                        for(var i=0;i<datos.length;i++){

                            //evaluamos si la hora seleccionada cae dentro de alguna otra en la que ya se tenga una cita
                            if(evaluar_entre_horas(datos[i].hora_inicio,sumar_minutos(datos[i].hora_inicio,datos[i].duracion),$("#select_hora_modal").val())==true){
                                
                                //deshabilitamos la sala que ya se tiene ocupada para esa hora
                                $("#select_sala_modal option").each(function() {
                                    
                                    if($(this).val()==datos[i].citas_sala){

                                        $(this).attr('disabled',true);
                                    }                                
                                });                            
                            }
                        }
                    }
                
                },
                error: function (datos) {
                    alert(datos.responseText);
                }
            });
        }

    }catch(ex){
        alert("error [activar_editar->ajax] : " + ex);
    }







    $("#modal_cita").modal('show');
}



function obtener_fecha(fecha){
    
    var fecha_in = fecha.toString().split(' ');    

    var resultado = "";
    var meses = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];    
    

    var mes = (meses.indexOf(fecha_in[1])+1);
    if(parseInt(mes,10)<10 && mes.toString().substring(0,1)!='0')
        mes = "0" + mes;

    var dia = fecha_in[2];
    if(parseInt(dia,10)<10 && dia.toString().substring(0,1)!='0')
        dia = "0" + dia;

    resultado += (fecha_in[3]) + "-";//año
    resultado += mes + "-";//mes
    resultado += dia;//dia

    return resultado;
}


function limpiar_modal(){

    $("#hid_cita_id").val("");
    $("#hid_cambio_fecha_hora").val("");
    $("#hid_cambio_estatus").val("");

    $("#txt_nota_modal").val("");
    $("#txt_nombre_modal").val("");
    $("#txt_apellido_p_modal").val("");
    $("#txt_apellido_p_modal").val("");
    $("#txt_telefono_modal").val("");
    $("#txt_domicilio_modal").val("");
    $("#txt_correo_modal").val("");    
    $("#txt_edad_modal").val("");    

    $("#date_fecha_modal").val("");
    $("#date_fecha_modal").prop("disabled",true);

    $("#select_estatus_modal").val("activo");
    $("#select_servicio_modal").val("-1");
    $("#select_cliente_modal").val("-1");
    $('#select_proveedor_modal option').remove();
    $('#select_hora_modal option').remove();
    $("#select_sala_modal").val("");

    $("#btn_cancelar").css("display","none");
    $("#btn_agregar_cliente").css("display","block");
    $("#contenedor_nuevo_cliente").css("display","none");
    $("#select_cliente_modal").prop("disabled",false);
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

                Usuiaro_ID = jsonData.usuarios_id;
                Usuario_Rol = jsonData.rol;
                
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