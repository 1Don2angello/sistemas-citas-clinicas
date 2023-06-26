<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/ope_citas.php";
    require "../../entidades/cls/cls_ope_citas.php";
    require "../../entidades/cls/cls_horas_ocupadas.php";
    require "../../entidades/cls/cls_salas_ocupadas.php";
    
        


    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;        

        case "consultar_citas_sin_sala":
            consultar_citas_sin_sala();
            break; 

        case "consultar_cls":
            consultar_cls($_POST['obj_filtros']);
            break;

        case "consultar_horas_ocupadas":
            consultar_horas_ocupadas($_POST['proveedor_id'],$_POST['fecha']);
            break;

        case "consultar_salas_ocupadas":
            consultar_salas_ocupadas($_POST['fecha']);
            break;

        case "verificar_citas_cliente":
            verificar_citas_cliente($_POST['id']);
            break;

        case "agregar":
            agregar($_POST['obj_filtros']);
            break;

        case "actualizar":
            actualizar($_POST['obj_filtros']);
            break;

        case "reagendar":
            reagendar($_POST['id'],$_POST['fecha']);
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
        $query = "INSERT INTO  gestion_citas.ope_citas (citas_id, citas_servicios_id, citas_proveedor_id, citas_clientes_id, citas_estatus, citas_fecha, citas_hora, citas_notas, citas_fecha_creo, citas_sala) " .
            "VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";
    
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query, array(
            &$filtros->citas_servicios_id,
            &$filtros->citas_proveedor_id,
            &$filtros->citas_clientes_id,
            &$filtros->citas_estatus,
            &$filtros->citas_fecha,
            &$filtros->citas_hora,
            &$filtros->citas_notas,
            &$filtros->citas_sala
        ));
    
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
    
        // Evaluamos si la operación se realizó correctamente
        if ($result) {
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
        $query = "UPDATE  gestion_citas.ope_citas SET " .
            "citas_servicios_id = ?, " .
            "citas_proveedor_id = ?, " .
            "citas_estatus = ?, " .
            "citas_fecha = ?, " .
            "citas_hora = ?, " .
            "citas_notas = ?, " .
            "citas_sala = ? " .
            "WHERE citas_id = ?";
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query, array(
            array(&$filtros->citas_servicios_id, SQLSRV_PARAM_IN),
            array(&$filtros->citas_proveedor_id, SQLSRV_PARAM_IN),
            array(&$filtros->citas_estatus, SQLSRV_PARAM_IN),
            array(&$filtros->citas_fecha, SQLSRV_PARAM_IN),
            array(&$filtros->citas_hora, SQLSRV_PARAM_IN),
            array(&$filtros->citas_notas, SQLSRV_PARAM_IN),
            array(&$filtros->citas_sala, SQLSRV_PARAM_IN),
            array(&$filtros->citas_id, SQLSRV_PARAM_IN)
        ));
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
        // Evaluamos si la operación se realizó correctamente
        if ($result) {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"" . sqlsrv_errors()[0]['message'] . "\"}";
        }
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
    }




    function reagendar($id, $fecha) {
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
    
        // --- VERIFICAR QUE EN LA NUEVA FECHA NO HAYA OTRA CITA A LA MISMA HORA ----
        $hora_cita = "";
        $consulta_hora = "SELECT * FROM  gestion_citas.ope_citas WHERE citas_id = ?";
        $stmt_hora = sqlsrv_prepare($db_context->conexion, $consulta_hora, array(&$id));
        $result_hora = sqlsrv_execute($stmt_hora);
    
        if ($result_hora) {
            if ($row = sqlsrv_fetch_array($stmt_hora, SQLSRV_FETCH_ASSOC)) {
                $hora_cita = $row['citas_hora'];
            }
        }
    
        $consulta_fecha = "SELECT * FROM gestion_citas.ope_citas WHERE citas_fecha = ? AND citas_hora = ?";
        $stmt_fecha = sqlsrv_prepare($db_context->conexion, $consulta_fecha, array(&$fecha, &$hora_cita));
        $result_fecha = sqlsrv_execute($stmt_fecha);
    
        if ($result_fecha) {
            if ($row = sqlsrv_fetch_array($stmt_fecha, SQLSRV_FETCH_ASSOC)) {
                echo "{\"mensaje\":\"No se puede reagendar la cita porque ya se tiene otra cita a la misma hora, favor de modificar la cita desde la ventana de edición\"}";
                return;
            }
        }
        // --------------------------------------------------------------------------
        // Variable de la consulta SQL
        $query = "UPDATE  gestion_citas.ope_citas SET " .
            "citas_fecha = ? " .
            "WHERE citas_id = ?";
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query, array(&$fecha, &$id));
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
        // Evaluamos si la operación se realizó correctamente
        if ($result) {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"" . sqlsrv_errors()[0]['message'] . "\"}";
        }
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
    }
    



    function eliminar($id) {
        // Creamos la conexión con la base de datos
        $db_context = new BaseDatos();
    
        // Variable de la consulta SQL
        $query = "DELETE FROM gestion_citas.ope_citas WHERE citas_id = ?";
    
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($db_context->conexion, $query, array(&$id));
    
        // Ejecutamos la consulta
        $result = sqlsrv_execute($stmt);
    
        // Evaluamos si la operación se realizó correctamente
        if ($result) {
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
    
        // Cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
    }

    function consultar($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.ope_citas WHERE citas_estatus='activo' ";
        if($filtros->citas_servicios_id!=-1){
            $query.= "AND citas_servicios_id = " . $filtros->citas_servicios_id . " ";
        }
        if($filtros->citas_proveedor_id!=-1){
            $query.= "AND citas_proveedor_id = " . $filtros->citas_proveedor_id . " ";
        }
        if($filtros->citas_fecha!=""){            
            $query.= "AND citas_fecha LIKE '%" . $filtros->citas_fecha . "%' ";
        }
        if($filtros->citas_sala!=""){
            $query.= "AND citas_sala = '".$filtros->citas_sala."' ";
        }
        //variable para mostrar o ocultar citas que ya hayan pasado
        if($filtros->citas_atendidas==""){
            setlocale(LC_TIME,"es_ES");
            $fechaActual = strftime("%Y-%m-%d");
            $query.= "AND citas_fecha >= '".$fechaActual."' ";
        }
        //variable que contiene el resultado de la consulta
        $stmt = sqlsrv_query($db_context->conexion, $query);
        
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
        
        //recorremos el resultado fila por fila
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new ope_citas(
                $row['citas_id'],
                $row['citas_servicios_id'],
                $row['citas_proveedor_id'],
                $row['citas_clientes_id'],
                $row['citas_estatus'],
                $row['citas_fecha']->format("Y-m-d"),
                $row['citas_hora'],
                $row['citas_notas'],
                $row['citas_fecha_creo']->format("Y-m-d H:i:s"),
                $row['citas_sala']
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        
        //cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
    
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }

    function consultar_citas_sin_sala(){
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.ope_citas AS oc "
        ."INNER JOIN cat_clientes AS cc ON oc.citas_clientes_id = cc.clientes_id "
        ."INNER JOIN cat_usuarios AS cu ON oc.citas_proveedor_id = cu.usuarios_id "
        ."INNER JOIN cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id "
        ."INNER JOIN cat_categorias AS cca ON cs.servicios_categoria_id = cca.categorias_id "
        ."WHERE citas_estatus='activo' AND citas_sala = ''";
        $stmt = sqlsrv_query($db_context->conexion, $query);
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
        //recorremos el resultado fila por fila
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_ope_citas(
                $row['citas_id'],
                $row['citas_servicios_id'],
                $row['citas_proveedor_id'],
                $row['citas_clientes_id'],
                $row['citas_estatus'],
                $row['citas_fecha']->format("Y-m-d"),
                $row['citas_hora'],
                $row['citas_notas'],
                $row['citas_fecha_creo']->format("Y-m-d H:i:s"),
                $row['citas_sala'],
                $row['servicios_id'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],
                $row['servicios_precio'],
                $row['categorias_id'],
                $row['categorias_nombre'],
                $row['clientes_id'],
                $row['clientes_nombre'] . " " . $row['clientes_apellido_p'] . " " . $row['clientes_apellido_m'],
                $row['clientes_correo'],
                $row['clientes_telefono'],
                $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m']
            );            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }        //cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    

    function consultar_cls($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.ope_citas AS oc "
        ."INNER JOIN cat_clientes AS cc ON oc.citas_clientes_id = cc.clientes_id "
        ."INNER JOIN cat_usuarios AS cu ON oc.citas_proveedor_id = cu.usuarios_id "
        ."INNER JOIN cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id "
        ."INNER JOIN cat_categorias AS cca ON cs.servicios_categoria_id = cca.categorias_id "
        ."WHERE citas_estatus='". $filtros->citas_estatus ."' ";
        if($filtros->citas_servicios_id!=-1){
            $query.= "AND citas_servicios_id = " . $filtros->citas_servicios_id . " ";
        }
        if($filtros->citas_proveedor_id!=-1){
            $query.= "AND citas_proveedor_id = " . $filtros->citas_proveedor_id . " ";
        }
        if($filtros->citas_fecha!=""){            
            $query.= "AND citas_fecha LIKE '%" . $filtros->citas_fecha . "%' ";
        }
        if($filtros->citas_sala!=""){
            $query.= "AND citas_sala = '".$filtros->citas_sala."' ";
        }
        //variable para mostrar o ocultar citas que ya hayan pasado
        if($filtros->citas_atendidas==""){
            setlocale(LC_TIME,"es_ES");            
            $query.= "AND citas_fecha >= '".strftime("%Y-%m-%d")."' ";
        }
        $query.="ORDER BY oc.citas_hora ASC";
        $stmt = sqlsrv_query($db_context->conexion, $query);
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
        //recorremos el resultado fila por fila
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_ope_citas(
                $row['citas_id'],
                $row['citas_servicios_id'],
                $row['citas_proveedor_id'],
                $row['citas_clientes_id'],
                $row['citas_estatus'],
                $row['citas_fecha']->format("Y-m-d"),
                $row['citas_hora'],
                $row['citas_notas'],
                $row['citas_fecha_creo']->format("Y-m-d H:i:s"),
                $row['citas_sala'],
                $row['servicios_id'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],
                $row['servicios_precio'],
                $row['categorias_id'],
                $row['categorias_nombre'],
                $row['clientes_id'],
                $row['clientes_nombre'] . " " . $row['clientes_apellido_p'] . " " . $row['clientes_apellido_m'],
                $row['clientes_correo'],
                $row['clientes_telefono'],
                $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m']
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        //cerramos la conexión con la base de datos
        $db_context->desconectar($db_context->conexion);
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    




    function consultar_horas_ocupadas($proveedor_id, $fecha){
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT oc.citas_hora as hora_inicio, cs.servicios_duracion as duracion, oc.citas_proveedor_id, oc.citas_fecha 
                  FROM gestion_citas.ope_citas AS oc
                  INNER JOIN gestion_citas.cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id
                  WHERE oc.citas_proveedor_id = ".$proveedor_id." AND oc.citas_fecha = '".$fecha."'";
    
        $stmt = sqlsrv_query($db_context->conexion, $query);
    
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
    
        //recorremos el resultado fila por fila
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_horas_ocupadas(
                $row['hora_inicio'],
                intval($row['duracion']) - 1,
                $row['citas_proveedor_id'],
                $row['citas_fecha']->format("Y-m-d")
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
    
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
    
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    
    

    function consultar_horas_ocupadas($proveedor_id, $fecha){
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT oc.citas_hora as hora_inicio, cs.servicios_duracion as duracion, oc.citas_proveedor_id, oc.citas_fecha 
                  FROM gestion_citas.ope_citas AS oc
                  INNER JOIN gestion_citas.cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id
                  WHERE oc.citas_proveedor_id = ".$proveedor_id." AND oc.citas_fecha = '".$fecha."'";
    
        $stmt = sqlsrv_query($db_context->conexion, $query);
    
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
    
        //recorremos el resultado fila por fila
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $item = new cls_horas_ocupadas(
                $row['hora_inicio'],
                intval($row['duracion']) - 1,
                $row['citas_proveedor_id'],
                $row['citas_fecha']->format("Y-m-d")
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
    
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
    
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    


    function verificar_citas_cliente($id){
        $resultado = "";
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.ope_citas WHERE citas_clientes_id = " . $id;
    
        $stmt = sqlsrv_query($db_context->conexion, $query);
    
        //verificamos si la consulta se ejecutó correctamente
        if ($stmt === false) {
            echo "{\"mensaje\":\"error\"}";
            die(print_r(sqlsrv_errors(), true));
        }
    
        //verificamos si se encontraron resultados
        if (sqlsrv_has_rows($stmt)) {
            $resultado = "{\"mensaje\":\"encontrado\"}";
        } else {
            $resultado = "{\"mensaje\":\"sin_citas\"}";
        }
    
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
    
        //retornamos el resultado obtenido
        echo $resultado;
    }
    
?>