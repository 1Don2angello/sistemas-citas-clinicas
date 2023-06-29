<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/ope_descansos.php";
    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        
        case "consultar":
            consultar();
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
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //eliminamos todos los registros existentes en la tabla ope_descansos
        $query_delete = "DELETE FROM gestion_citas.ope_descansos";
        $stmt_delete = sqlsrv_query($db_context->conexion, $query_delete);
        //verificamos si la eliminación se realizó correctamente
        if ($stmt_delete === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        //insertamos los nuevos registros en la tabla ope_descansos
        for ($i = 0; $i < sizeof($filtros); $i++) {
            //variable de la consulta SQL
            $query_insert = "INSERT INTO gestion_citas.ope_descansos (descansos_id, descansos_dia, descansos_inicio, descansos_final) VALUES (NULL, '".$filtros[$i]->descansos_dia."', '".$filtros[$i]->descansos_inicio."', '".$filtros[$i]->descansos_final."')";
            //variable que contiene el resultado de la consulta
            $stmt_insert = sqlsrv_query($db_context->conexion, $query_insert);
            //verificamos si la inserción se realizó correctamente
            if ($stmt_insert === false) {
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


    function consultar(){
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.ope_descansos";
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        
        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
            $item = new ope_descansos(
                $row['descansos_id'],
                $row['descansos_dia'],
                $row['descansos_inicio'],
                $row['descansos_final']
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