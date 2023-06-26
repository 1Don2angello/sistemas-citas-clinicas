<?php
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/cat_clientes.php";        
    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];
    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;
        case "consultar_exacto":
            consultar_exacto($_POST['obj_filtros']);
            break;                        
        case "consultar_por_id":
            consultar_por_id($_POST['id']);
            break;
        case "agregar":
            agregar($_POST['obj_filtros']);
            break;
        case "actualizar":
            actualizar($_POST['obj_filtros']);
            break;
        case "eliminar":
            eliminar($_POST['id']);
            break;    
        default:
            echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
            break;
    }

    function agregar($obj_filtros) {
        $filtros = json_decode($obj_filtros);
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "INSERT INTO  gestion_citas.cat_clientes " .
            "(clientes_id, clientes_nombre, clientes_apellido_p, clientes_apellido_m, clientes_telefono, clientes_correo, clientes_direccion, clientes_sexo, clientes_edad) " .
            "VALUES (NULL, " .
            "'".$filtros->clientes_nombre."', " .
            "'".$filtros->clientes_apellido_p."', " .
            "'".$filtros->clientes_apellido_m."', " .
            "'".$filtros->clientes_telefono."', " .
            "'".$filtros->clientes_correo."', " .
            "'".$filtros->clientes_direccion."', " .
            "'".$filtros->clientes_sexo."', " .
            "'".$filtros->clientes_edad."')";
            
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query);
        
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
        
        // Evaluamos si la operación se realizó correctamente
        if ($result === true) {
            echo "{\"mensaje\":\"correcto\",\"id\":". $db_context->conexion->lastInsertId() ."}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);  
    }
    

    function actualizar($obj_filtros) {
        $filtros = json_decode($obj_filtros);
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "UPDATE  gestion_citas.cat_clientes SET " .
            "clientes_nombre = '".$filtros->clientes_nombre."', " .
            "clientes_apellido_p = '".$filtros->clientes_apellido_p."', " .
            "clientes_apellido_m = '".$filtros->clientes_apellido_m."', " .
            "clientes_telefono = '".$filtros->clientes_telefono."', " .
            "clientes_correo = '".$filtros->clientes_correo."', " .
            "clientes_direccion = '".$filtros->clientes_direccion."', " .
            "clientes_sexo = '".$filtros->clientes_sexo."', " .
            "clientes_edad = '".$filtros->clientes_edad."' " .
            "WHERE clientes_id = ".$filtros->clientes_id;
            
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query);
        
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
        
        // Evaluamos si la operación se realizó correctamente
        if ($result === true) {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
    }
    

    function eliminar($id) {
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Eliminar todas las citas a su nombre
        $query = "DELETE FROM ope_citas WHERE citas_clientes_id = " . $id;
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Variable de la consulta SQL
        $query = "DELETE FROM  gestion_citas.cat_clientes WHERE clientes_id = " . $id;
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Evaluamos si la operación se realizó correctamente
        if ($result === true) {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
    }
    


    function consultar($obj_filtros) {
        $filtros = json_decode($obj_filtros);
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_clientes " .
            "WHERE clientes_nombre LIKE '%" . $filtros->clientes_nombre . "%' " .
            "AND clientes_apellido_p LIKE '%" . $filtros->clientes_apellido_p . "%' " .
            "AND clientes_apellido_m LIKE '%" . $filtros->clientes_apellido_m . "%'";
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while (($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))) {
            $item = new  cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    



    function consultar_exacto($obj_filtros) {
        $filtros = json_decode($obj_filtros);
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_clientes " .
            "WHERE clientes_nombre = '" . $filtros->clientes_nombre . "' " .
            "AND clientes_apellido_p = '" . $filtros->clientes_apellido_p . "' " .
            "AND clientes_apellido_m = '" . $filtros->clientes_apellido_m . "'";
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while (($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))) {
            $item = new  cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    
    function consultar_por_id($id) {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_clientes " .
            "WHERE clientes_id = " . $id;
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        if (($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))) {
            $item = new  cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    
?>