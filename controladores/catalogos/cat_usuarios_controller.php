<?php
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/cat_usuarios.php";
    require "../../entidades/ope_rel_usuario_servicio.php";
    require "../../entidades/utils/cls_combo.php";
    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];
    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        case "consultar":
            consultar($_POST['obj_filtros']);
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
        case "consultar_servicios_usuario":
            consultar_servicios_usuario($_POST['id']);
            break;
        case "consultar_usuarios_servicio":
            consultar_usuarios_servicio($_POST['id']);
            break;
        case "consultar_usuarios_servicio_sin_id":
            consultar_usuarios_servicio_sin_id();
            break;
        case "registrar_servicios_usuario":
            registrar_servicios_usuario($_POST['obj_filtros']);
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
    $query = "INSERT INTO `gestion_citas.cat_usuarios` " . 
    "(`usuarios_id`,`usuarios_nombre`,`usuarios_apellido_p`,`usuarios_apellido_m`,`usuarios_telefono`,`usuarios_correo`,`usuarios_direccion`,`usuarios_usuario`,`usuarios_clave`,`usuarios_rol`) " .
    "VALUES (NULL, " .
    "'" . $filtros->usuarios_nombre . "', " .
    "'" . $filtros->usuarios_apellido_p . "', " .
    "'" . $filtros->usuarios_apellido_m . "', " .        
    "'" . $filtros->usuarios_telefono . "', " .
    "'" . $filtros->usuarios_correo . "', " .
    "'" . $filtros->usuarios_direccion . "', " .
    "'" . $filtros->usuarios_usuario . "', " .
    "'" . $filtros->usuarios_clave . "', " .
    "'" . $filtros->usuarios_rol . "')";
    
    // Variable que contiene el resultado de la consulta
    $result = sqlsrv_query($db_context->conexion, $query);
    
    // Evaluamos si la operación se realizó correctamente
    if ($result === true) {
        $lastInsertIdQuery = "SELECT SCOPE_IDENTITY() AS LastInsertId";
        $lastInsertIdResult = sqlsrv_query($db_context->conexion, $lastInsertIdQuery);
        $lastInsertId = sqlsrv_fetch_array($lastInsertIdResult)['LastInsertId'];
        echo "{\"mensaje\":\"correcto\",\"id\":" . $lastInsertId . "}";
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
    
    // ------ Verificar que no tenga servicios -------
    $servicios = sqlsrv_query($db_context->conexion, "SELECT * FROM  gestion_citas.ope_rel_usuario_servicio WHERE usuarios_id = " . $filtros->usuarios_id);
    
    if ($servicios === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if (sqlsrv_has_rows($servicios)) {
        sqlsrv_query($db_context->conexion, "DELETE FROM  gestion_citas.ope_rel_usuario_servicio WHERE usuarios_id = " . $filtros->usuarios_id);
    }
    // -----------------------------------------------
    
    // Variable de la consulta SQL
    $query = "UPDATE `gestion_citas.cat_usuarios` SET " .
        "usuarios_nombre = '" . $filtros->usuarios_nombre . "', " .
        "usuarios_apellido_p = '" . $filtros->usuarios_apellido_p . "', " .        
        "usuarios_apellido_m = '" . $filtros->usuarios_apellido_m . "', " .        
        "usuarios_telefono = '" . $filtros->usuarios_telefono . "', " .        
        "usuarios_correo = '" . $filtros->usuarios_correo . "', " .        
        "usuarios_direccion = '" . $filtros->usuarios_direccion . "', " .        
        "usuarios_usuario = '" . $filtros->usuarios_usuario . "', " .        
        "usuarios_clave = '" . $filtros->usuarios_clave . "', " .        
        "usuarios_rol = '" . $filtros->usuarios_rol . "' " .        
        "WHERE usuarios_id = " . $filtros->usuarios_id;
        
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

function eliminar($id) {
    // Creamos la conexión con la base de datos
    $db_context = new BaseDatos();
    
    // ------ Verificar que no tenga servicios -------
    $servicios = sqlsrv_query($db_context->conexion, "SELECT * FROM  gestion_citas.ope_rel_usuario_servicio WHERE usuarios_id = " . $id);
    
    if ($servicios === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if (sqlsrv_has_rows($servicios)) {
        sqlsrv_query($db_context->conexion, "DELETE FROM  gestion_citas.ope_rel_usuario_servicio WHERE usuarios_id = " . $id);
    }
    // -----------------------------------------------
    
    // Variable de la consulta SQL
    $query = "DELETE FROM `gestion_citas.cat_usuarios` WHERE usuarios_id = " . $id;
    
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

function consultar_por_id($id) {
    $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
    
    // Creamos la conexión con la base de datos
    $db_context = new BaseDatos();
    
    // Variable de la consulta SQL
    $query = "SELECT * FROM  gestion_citas.cat_usuarios " .
        "WHERE usuarios_id = " . $id;
    
    // Variable que contiene el resultado de la consulta
    $result = sqlsrv_query($db_context->conexion, $query);
    
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Recorremos el resultado fila por fila
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $item = new cat_usuarios(
            $row['usuarios_id'],
            $row['usuarios_nombre'],
            $row['usuarios_apellido_p'],
            $row['usuarios_apellido_m'],
            $row['usuarios_telefono'],
            $row['usuarios_correo'],
            $row['usuarios_direccion'],
            $row['usuarios_usuario'],
            $row['usuarios_clave'],
            $row['usuarios_rol']
        );
        
        // Agregamos el objeto al array de resultado
        array_push($lista_resultado, $item);
    }
    
    // Cerramos la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
    
    // Retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}

    
    function consultar($obj_filtros) {
        $filtros = json_decode($obj_filtros);
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_usuarios " .
            "WHERE usuarios_nombre LIKE '%" . $filtros->usuarios_nombre . "%' " .
            "AND usuarios_apellido_p LIKE '%" . $filtros->usuarios_apellido_p . "%' " .
            "AND usuarios_apellido_m LIKE '%" . $filtros->usuarios_apellido_m . "%'";
        
        if ($filtros->usuarios_rol != "Todos") {
            $query .= "AND usuarios_rol LIKE '%" . $filtros->usuarios_rol . "%'";
        }
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cat_usuarios(
                $row['usuarios_id'],
                $row['usuarios_nombre'],
                $row['usuarios_apellido_p'],
                $row['usuarios_apellido_m'],
                $row['usuarios_telefono'],
                $row['usuarios_correo'],
                $row['usuarios_direccion'],
                $row['usuarios_usuario'],
                $row['usuarios_clave'],
                $row['usuarios_rol']
            );
            
            // Agregamos el objeto al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }

    
    function registrar_servicios_usuario($obj_filtros) {
        $error = "";
        $filtros = json_decode($obj_filtros);
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        for ($i = 0; $i < sizeof($filtros); $i++) {
            // Variable de la consulta SQL
            $query = "INSERT INTO ope_rel_usuario_servicio " .
                "(relacion_id,usuarios_id,servicios_id) " .
                "VALUES (NULL," . $filtros[$i]->usuarios_id . "," . $filtros[$i]->servicios_id . ")";
            
            // Variable que contiene el resultado de la consulta
            $result = sqlsrv_query($db_context->conexion, $query);
            
            if ($result === false) {
                $error = "{\"mensaje\":\"error\"}";
                break;
            }
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        if ($error != "") {
            echo "{\"mensaje\":\"error\"}";
        } else {
            echo "{\"mensaje\":\"correcto\"}";
        }
    }

    


    function consultar_servicios_usuario($id) {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.ope_rel_usuario_servicio WHERE usuarios_id = " . $id;
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new ope_rel_usuario_servicio(
                $row['relacion_id'],
                $row['usuarios_id'],
                $row['servicios_id']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }


    function consultar_usuarios_servicio($id) {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT cu.* FROM  gestion_citas.ope_rel_usuario_servicio AS orus " .
            "INNER JOIN cat_usuarios AS cu ON orus.usuarios_id = cu.usuarios_id " .
            "WHERE servicios_id = " . $id;
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_combo(
                $row['usuarios_id'],
                $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    


    function consultar_usuarios_servicio_sin_id() {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT DISTINCT cu.usuarios_id, cu.* FROM  gestion_citas.cat_usuarios AS cu " .
            "INNER JOIN ope_rel_usuario_servicio as orus ON orus.usuarios_id = cu.usuarios_id";
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_combo(
                $row['usuarios_id'],
                $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
