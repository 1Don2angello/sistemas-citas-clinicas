
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
        $("#nav_reportes").addClass("activo");       
        
        _llenar_combo_servicios();
        _llenar_combo_clientes();  
        _llenar_combo_proveedores_filtro();      
        

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        
        $("#date_fecha_inicio").val(today);
        $("#date_fecha_fin").val(today);



        consultar_reportes();        

    }catch(ex){
        alert("[inicializar_pagina -> function]: " + ex);
    }    
}



function eventos(){

    $("#btn_buscar").on('click',function(e){
        e.preventDefault();

        try{

            var validacion="";
            if($("#txt_hora_inicio").val().length<5 && $("#txt_hora_inicio").val().length>0){
                validacion+="- Favor de ingresar una hora de inicio válida.<br>";
            }

            if($("#txt_hora_fin").val().length<5 && $("#txt_hora_fin").val().length>0){
                validacion+="- Favor de ingresar una hora final válida.<br>";
            }

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

            consultar_reportes();

        }catch(ex){
            alert("[btn_buscar -> click]:" + ex);
        }   

    });



    $("#btn_excel").on('click',function(e){
        e.preventDefault();

        try{
            
            $(".loader").css("display","block");        
                                    
                            
            $.ajax({
    
                type: "POST",
                async: false,
                url: '../controladores/operaciones/reportes_controller.php',
                data: {"funcion" : "exportar_excel", "obj_json": tabla_to_json("table_citas")},
                success: function(response)
                {                
    
                    try{
                        
                        //console.log(response);
                        var jsonData = JSON.parse(response); 
                
                        if(jsonData.mensaje=="correcto"){
                                                        
                            window.location.href="../controladores/utils/descargar_archivo.php?file_path=" + jsonData.file;
                        }else{

                            Swal.fire({
                                title: 'Ha ocurrido un error generando el reporte, favor de intentarlo de nuevo más tarde',                            
                                icon: 'error',
                                confirmButtonText: `Salir`,
                            });
                        }
    
                    }catch(ex_ajax){
    
                        alert("[btn_excel -> ajax]: " + ex_ajax);
                    }
    
                },
                error: function(e){
                    
                    alert(e.responseText);                
                }
            });
    
            $(".loader").fadeOut("slow");
    
        }catch(ex){
            alert("[btn_excel -> click]: " + ex);
        }
    });


    $("#btn_pdf").on('click',function(e){
        e.preventDefault();

        try{
            
            var hoy=new Date();
            var fecha = hoy.getFullYear()+"-"+(hoy.getMonth()+1)+"-"+hoy.getDate()+"-"+hoy.getHours()+"-"+hoy.getMinutes()+"-"+hoy.getSeconds();

            var doc = new jsPDF('p', 'pt', 'a4');
            doc.setFontSize(12);

            var res = doc.autoTableHtmlToJson(document.getElementById("table_citas"));                            
            doc.autoTable(res.columns, res.data,{margin: {top: 50}});
            doc.save("reporte_citas_"+fecha+".pdf");
            
        }catch(ex){
            alert("[btn_pdf -> click]:" + ex);
        }
    });
       


    $("#txt_hora_inicio").keydown(function(e){
        var key = e.charCode || e.keyCode || 0;        

        if($("#txt_hora_inicio").val().length==2 && key!=190 && key!=8){
            $("#txt_hora_inicio").val($("#txt_hora_inicio").val()+":");
        }
        
        // allow :, backspace, tab, delete, arrows, numbers and keypad numbers ONLY
        return (
          key==190 ||
          key == 8 ||
          key == 9 ||
          key == 46 ||
          (key >= 37 && key <= 40) ||
          (key >= 48 && key <= 57) ||
          (key >= 96 && key <= 105));
    });


    $("#txt_hora_fin").keydown(function(e){
        var key = e.charCode || e.keyCode || 0;        

        if($("#txt_hora_fin").val().length==2 && key!=190 && key!=8){
            $("#txt_hora_fin").val($("#txt_hora_fin").val()+":");
        }
        
        // allow :, backspace, tab, delete, arrows, numbers and keypad numbers ONLY
        return (
          key==190 ||
          key == 8 ||
          key == 9 ||
          key == 46 ||
          (key >= 37 && key <= 40) ||
          (key >= 48 && key <= 57) ||
          (key >= 96 && key <= 105));
    });
}


function consultar_reportes(){
    try{
            
        $(".loader").css("display","block");        

        //limpiamos el contenido de la tabla
        $('#datos_tabla_citas').empty();



        var obj_filtros = new Object();
        obj_filtros.servicios_id = $('#select_servicio').val();        
        obj_filtros.proveedores_id = $("#select_proveedor").val();
        obj_filtros.clientes_id = $("#select_clientes").val();
        obj_filtros.citas_estatus = $("#select_estatus").val();
        obj_filtros.citas_fecha = $("#date_fecha_inicio").val() + "," + $("#date_fecha_fin").val();
        obj_filtros.citas_hora = $("#txt_hora_inicio").val() + "," + $("#txt_hora_fin").val();         
                        

        $.ajax({

            type: "POST",
            async: false,
            url: '../controladores/operaciones/reportes_controller.php',
            data: {"funcion" : "consultar_cls", "obj_filtros": JSON.stringify(obj_filtros)},
            success: function(response)
            {                

                try{
                    
                    console.log(response);
                    var jsonData = JSON.parse(response); 
            
                    if(jsonData.length==0){
                        $('#datos_tabla_citas').append('<tr style="pointer-events: none;"><td colspan="8">No se han encontrado resultados</td></tr>');
                    }

                    for(var i=0;i<jsonData.length;i++){
                                        
                        var contenido="";
                                            
                        contenido +="<tr> "+
                                        '<td>'+ jsonData[i].servicios_nombre +'</td> '+
                                        '<td>'+ jsonData[i].categorias_nombre +'</td> '+
                                        '<td>'+ jsonData[i].proveedores_nombre_completo +'</td> '+
                                        '<td>'+ jsonData[i].clientes_nombre_completo +'</td> '+
                                        '<td>'+ jsonData[i].citas_fecha +'</td> '+
                                        '<td>'+ jsonData[i].citas_hora +'</td> '+
                                        '<td>'+ jsonData[i].citas_notas +'</td> '+
                                        '<td>'+ jsonData[i].citas_fecha_creo +'</td> '+
                                    '</tr>';

                        $('#datos_tabla_citas').append(contenido);
                    }

                }catch(ex_ajax){

                    alert("[consultar_reportes -> ajax]: " + ex_ajax);
                }

            },
            error: function(e){
                
                alert(e.responseText);                
            }
        });

        $(".loader").fadeOut("slow");

    }catch(ex){
        alert("[consultar_reportes -> function]: " + ex);
    }
}






function _llenar_combo_servicios() {
        
    try {
                
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
                                                            
                    document.getElementById('select_servicio').innerHTML += "<option value='-1'>- seleccionar -</option>";

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

function _llenar_combo_proveedores_filtro() {
        
    try {
        
        $('#select_proveedor option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_usuarios_controller.php',
            data: {"funcion" : 'consultar_usuarios_servicio_sin_id'},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                       
                    
                    document.getElementById('select_proveedor').innerHTML += "<option value='-1'>- seleccionar -</option>";

                    
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
                
        var filtros = new Object();
        filtros.clientes_nombre="";
        filtros.clientes_apellido_p="";
        filtros.clientes_apellido_m="";

        $('#select_clientes option').remove();

        $.ajax({
            type: 'POST',
            url: '../controladores/catalogos/cat_clientes_controller.php',
            data: {"funcion" : 'consultar' , "obj_filtros":JSON.stringify(filtros)},                        
            async: false,            
            success: function (datos) {
                if (datos !== null) {
                    
                    //console.log(datos);
                    datos = JSON.parse(datos);
                                                            
                    document.getElementById('select_clientes').innerHTML += "<option value='-1'>- seleccionar -</option>";
                
                    var contenido = "";
                    for(var i=0;i<datos.length;i++){
                                                                    
                        contenido += "<option value='" + datos[i].clientes_id + "'>" + datos[i].clientes_nombre + " " + datos[i].clientes_apellido_p + " " + datos[i].clientes_apellido_m + "</option>";
                                                                    
                    }
                    
                    document.getElementById('select_clientes').innerHTML += contenido;

                    $("#select_clientes").select2();
                                        
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




function tabla_to_json(id_tabla){
  
    var json = '{';
    var otArr = [];
    
    $('#'+id_tabla+' tr').each(function(i) {      
  
        x = $(this).children();
        var itArr = [];
        x.each(function() {
          itArr.push('"' + $(this).text() + '"');
        });
        otArr.push('"' + i + '": [' + itArr.join(',') + ']');
    });
  
    json += otArr.join(",") + '}'
  
    return json;
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
                $("#nav_calendario").css("display","none");
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