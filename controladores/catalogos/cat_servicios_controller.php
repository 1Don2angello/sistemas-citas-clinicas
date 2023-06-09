<?php
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/cat_servicios.php";        
    require "../../entidades/utils/cls_combo.php";        
    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];
    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;
        case "consultar_info_servicio":
            consultar_info_servicio($_POST['id']);
            break;
        case "combo_servicios":
            combo_servicios();
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
        $query = "INSERT INTO `gestion_citas.cat_servicios` " .
            "(`servicios_id`,`servicios_categoria_id`,`servicios_descripcion`,`servicios_nombre`,`servicios_duracion`,`servicios_precio`) " .
            "VALUES (NULL, " .
            "'" . $filtros->servicios_categoria_id . "', " .
            "'" . $filtros->servicios_descripcion . "', " .
            "'" . $filtros->servicios_nombre . "', " .
            "'" . $filtros->servicios_duracion . "', " .
            "'" . $filtros->servicios_precio . "')";
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Evaluamos si la operación se realizó correctamente
        if ($result === true) {
            echo "{\"mensaje\":\"correcto\"}";
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
        $query = "UPDATE `gestion_citas.cat_servicios` SET " .
            "servicios_categoria_id = '" . $filtros->servicios_categoria_id . "', " .
            "servicios_descripcion = '" . $filtros->servicios_descripcion . "', " .
            "servicios_nombre = '" . $filtros->servicios_nombre . "', " .
            "servicios_duracion = '" . $filtros->servicios_duracion . "', " .
            "servicios_precio = '" . $filtros->servicios_precio . "' " .
            "WHERE servicios_id = " . $filtros->servicios_id;
        
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
        
        // Variable de la consulta SQL
        $query = "DELETE FROM `gestion_citas.cat_servicios` WHERE servicios_id = " . $id;
        
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
        $query = "SELECT cs.*, cc.categorias_nombre FROM  gestion_citas.cat_servicios AS cs " .
                 "INNER JOIN cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id " .
                 "WHERE servicios_nombre LIKE '%" . $filtros->servicios_nombre . "%'";
                 
        if ($filtros->servicios_categoria_id != -1) {
            $query .= " AND servicios_categoria_id = " . $filtros->servicios_categoria_id;
        }
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cat_servicios(
                $row['servicios_id'],
                $row['servicios_categoria_id'],
                $row['servicios_descripcion'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],                
                $row['servicios_precio'],
                $row['categorias_nombre']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    

    function consultar_info_servicio($id) {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_servicios AS cs " .
                 "INNER JOIN cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id " .
                 "WHERE servicios_id = " . $id;
                 
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cat_servicios(
                $row['servicios_id'],
                $row['servicios_categoria_id'],
                $row['servicios_descripcion'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],                
                $row['servicios_precio'],
                $row['categorias_nombre'],
                $row['categorias_descripcion']
            );
            
            // Agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        
        // Retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    

    function combo_servicios() {
        $lista_resultado = []; // Variable en la que se almacena el resultado de la consulta
        
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
        
        // Variable de la consulta SQL
        $query = "SELECT * FROM  gestion_citas.cat_servicios AS cs INNER JOIN  gestion_citas.cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id";
        
        // Variable que contiene el resultado de la consulta
        $result = sqlsrv_query($db_context->conexion, $query);
        
        // Recorremos el resultado fila por fila
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_combo(
                $row['servicios_id'],
                $row['servicios_nombre'],
                $row['categorias_nombre']
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