<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/apl_configuracion.php";        
    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;        

        case "actualizar":
            actualizar($_POST['obj_filtros']);
            break;            

        default:
            echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
            break;
    }

    

    function actualizar($obj_filtros){
        $error = "";
        $filtros = json_decode($obj_filtros);
        
        //buscamos si viene el objeto extra que indica que se actualizó la imagen
        $index_img = -1;
        for ($i = 0; $i < sizeof($filtros); $i++) {
            if ($filtros[$i]->configuracion_nombre == "imagen_editada") {
                $index_img = $i;
                break;
            }
        }
        
        if ($index_img != -1) {
            unset($filtros[$index_img]);
            unlink("../../img/logotipo.jpg");
            rename("../../img/logotipo_edit.jpg", "../../img/logotipo.jpg");
        }
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        for ($i = 0; $i < sizeof($filtros); $i++) {
            $query = "UPDATE gestion_citas.apl_configuracion SET ".
                "configuracion_clase = '".$filtros[$i]->configuracion_clase."', ".
                "configuracion_valor = '".$filtros[$i]->configuracion_valor."' ".
                "WHERE configuracion_nombre = '".$filtros[$i]->configuracion_nombre."'";
            
            $stmt = sqlsrv_query($db_context->conexion, $query);
            
            //verificamos si la consulta se ejecutó correctamente
            if ($stmt === false) {
                echo "{\"mensaje\":\"error\"}";
                die(print_r(sqlsrv_errors(), true));
            }
            
            //evaluamos si la operacion se realizó correctamente
            if (sqlsrv_rows_affected($stmt) === false) {
                $error = "error";
                break;
            }
        }
        
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        //evaluamos si la operacion se realizó correctamente
        if ($error == "") {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
    }
    




    function consultar($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.apl_configuracion WHERE configuracion_clase LIKE '%".$filtros->configuracion_clase."%'";
        
        //variable que contiene el resultado de la consulta
        $stmt = sqlsrv_query($db_context->conexion, $query);
        
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        //recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new apl_configuracion(
                $row['configuracion_id'],
                $row['configuracion_nombre'],
                $row['configuracion_clase'],
                $row['configuracion_valor']
            );
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }    

?>