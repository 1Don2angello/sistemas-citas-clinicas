<?php
//agregamos todas las referencias necesarias
require "../../configDB.php";
require "../../entidades/ope_citas.php";
require "../../entidades/cls/cls_ope_citas.php";
require "../../entidades/cls/cls_horas_ocupadas.php";
require "../../entidades/cls/cls_salas_ocupadas.php";
//variable que indica a cual funcion hace referencia la peticion ajax
$funcion = $_POST['funcion'];
//evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
switch ($funcion) {
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
        consultar_horas_ocupadas($_POST['proveedor_id'], $_POST['fecha']);
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
        reagendar($_POST['id'], $_POST['fecha']);
        break;
    case "eliminar":
        eliminar($_POST['id']);
        break;
    default:
        echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
        break;
}/* 
function agregar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    // Crear la instancia de la clase BaseDatos
    $db_context = new BaseDatos();

    // Variable de la consulta SQL con marcadores de posición
    $query = "INSERT INTO gestion_citas.ope_citas " .
        "(citas_servicios_id, citas_proveedor_id, citas_clientes_id, citas_estatus, citas_fecha, citas_hora, citas_notas, citas_fecha_creo, citas_sala) " .
        "VALUES (:servicios_id, :proveedor_id, :clientes_id, :estatus, :fecha, :hora, :notas, CURRENT_DATE(), :sala)";

    // Preparar la declaración
    $stmt = $db_context->conexion->prepare($query);

    // Vincular los valores a los marcadores de posición
    $stmt->bindValue(':servicios_id', $filtros->citas_servicios_id);
    $stmt->bindValue(':proveedor_id', $filtros->citas_proveedor_id);
    $stmt->bindValue(':clientes_id', $filtros->citas_clientes_id);
    $stmt->bindValue(':estatus', $filtros->citas_estatus);
    $stmt->bindValue(':fecha', $filtros->citas_fecha);
    $stmt->bindValue(':hora', $filtros->citas_hora);
    $stmt->bindValue(':notas', $filtros->citas_notas);
    $stmt->bindValue(':sala', $filtros->citas_sala);

    // Ejecutar la declaración
    $result = $stmt->execute();
    echo "Consulta SQL: " . $query;
    // Verificar si la operación se realizó correctamente
    if ($result) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    // Cerrar la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
} */


function agregar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    // Crear la instancia de la clase BaseDatos
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "INSERT INTO gestion_citas.ope_citas " .
    "(citas_servicios_id, citas_proveedor_id, citas_clientes_id, citas_estatus, citas_fecha, citas_hora, citas_notas, citas_fecha_creo, citas_sala) " .
    "VALUES (".$filtros->citas_servicios_id.", ".$filtros->citas_proveedor_id.", ".$filtros->citas_clientes_id.", ".$filtros->citas_estatus.", ".$filtros->citas_fecha."', '".$filtros->citas_hora."', '".$filtros->citas_notas."', GETDATE(), '".$filtros->citas_sala."')";
 // Imprimir la consulta SQL
   echo "Consulta SQL: " . $query;
    // Ejecutar la declaración
    $result = $db_context->conexion->query($query);

    // Verificar si la operación se realizó correctamente
    if ($result) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    // Cerrar la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
}

/* function agregar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    // Creamos la conexión con la base de datos
    $db_context = new BaseDatos();
    // Variable de la consulta SQL
    $query = "INSERT INTO gestion_citas.ope_citas " .
        "(citas_id, citas_servicios_id, citas_proveedor_id, citas_clientes_id, citas_estatus, citas_fecha, citas_hora, citas_notas, citas_fecha_creo, citas_sala) " .
        "VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, GETDATE(), ?)";
    // Preparamos la declaración
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
    // Verificamos si ocurrió algún error al preparar la declaración
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Imprimir los valores de los filtros y el JSON
    echo "Valores de los filtros:";
    echo "<pre>";
    print_r($filtros);
    echo "</pre>";
    
    echo "JSON de obj_filtros:";
    echo "<pre>";
    echo json_encode($filtros);
    echo "</pre>";
    
    // Ejecutamos la declaración
    $result = sqlsrv_execute($stmt);
    // Verificamos si ocurrió algún error al ejecutar la declaración
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    // Evaluamos si la operación se realizó correctamente
    if ($result) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }
    // Cerramos la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
}


 */
/* function agregar($obj_filtros) {
        $filtros = json_decode($obj_filtros); $error = "";
        // Configuración de la conexión a la base de datos
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
         $query = "INSERT INTO 'gestion_citas.ope_citas' (`citas_id`, `citas_servicios_id`, `citas_proveedor_id`,`citas_clientes_id`,`citas_estatus`,`citas_fecha`,`citas_hora`,`citas_notas`,`citas_fecha_creo`,`citas_sala`) ".
         "VALUES (NULL, ".$filtros->citas_servicios_id.", ".$filtros->citas_proveedor_id.", ".$filtros->citas_clientes_id.", '".$filtros->citas_estatus."', '".$filtros->citas_fecha."', '".$filtros->citas_hora."', '".$filtros->citas_notas."', CURRENT_TIMESTAMP, '".$filtros->citas_sala."')";
          //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //evaluamos si la operacion se realizó correctamente
        if($result == true){
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"".$db_context->conexion->$error."\"}";
        }
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
    } */

function actualizar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $error = ""; // Variable para almacenar mensajes de error
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "UPDATE gestion_citas.ope_citas SET " .
        "citas_servicios_id = '" . $filtros->citas_servicios_id . "', " .
        "citas_proveedor_id = '" . $filtros->citas_proveedor_id . "', " .
        "citas_estatus = '" . $filtros->citas_estatus . "', " .
        "citas_fecha = '" . $filtros->citas_fecha . "', " .
        "citas_hora = '" . $filtros->citas_hora . "', " .
        "citas_notas = '" . $filtros->citas_notas . "', " .
        "citas_sala = '" . $filtros->citas_sala . "' " .
        "WHERE citas_id = '" . $filtros->citas_id . "'";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //evaluamos si la operacion se realizó correctamente
    if ($result == true) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"" . $db_context->conexion->$error . "\"}";
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
}

function reagendar($id, $fecha)
{
    $error = ""; // Variable para almacenar mensajes de error
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //--- VERIFICAR QUE EN LA NUEVA FECHA NO HAYA OTRA CITA A LA MISMA HORA ----
    $hora_cita = "";
    $consulta_hora = $db_context->conexion->query("SELECT * FROM gestion_citas.ope_citas WHERE citas_id = '" . $id . "'");
    if (($row = $consulta_hora->fetch(PDO::FETCH_ASSOC)) == true) {
        $hora_cita = $row['citas_hora'];
    }

    $consulta_fecha = $db_context->conexion->query("SELECT * FROM gestion_citas.ope_citas WHERE citas_fecha = '" . $fecha . "'");
    while (($row = $consulta_fecha->fetch(PDO::FETCH_ASSOC)) == true) {
        if ($row['citas_hora'] == $hora_cita) {
            echo "{\"mensaje\":\"No se puede reagendar la cita porque ya se tiene otra cita a la misma hora, favor de modificar la cita desde la ventana de edición\"}";
            return;
        }
    }
    //variable de la consulta SQL
    $query = "UPDATE gestion_citas.ope_citas SET " .
        "citas_fecha = '" . $fecha . "' " .
        "WHERE citas_id = '" . $id . "'";

    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //evaluamos si la operacion se realizó correctamente
    if ($result == true) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"" . $db_context->conexion->$error . "\"}";
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
}




function eliminar($id)
{

    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();

    //variable de la consulta SQL
    $query = "DELETE FROM gestion_citas.ope_citas WHERE citas_id = " . $id;

    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);

    //evaluamos si la operacion se realizó correctamente
    if ($result == true) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
}



function consultar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT * FROM gestion_citas.ope_citas WHERE citas_estatus='activo' ";
    if ($filtros->citas_servicios_id != -1) {
        $query .= "AND citas_servicios_id = " . $filtros->citas_servicios_id . " ";
    }
    if ($filtros->citas_proveedor_id != -1) {
        $query .= "AND citas_proveedor_id = " . $filtros->citas_proveedor_id . " ";
    }
    if ($filtros->citas_fecha != "") {
        $query .= "AND citas_fecha LIKE '%" . $filtros->citas_fecha . "%' ";
    }
    if ($filtros->citas_sala != "") {
        $query .= "AND citas_sala = '" . $filtros->citas_sala . "' ";
    }
    //variable para mostrar o ocultar citas que ya hayan pasado
    if ($filtros->citas_atendidas == "") {
        setlocale(LC_TIME, "es_ES");
        $query .= "AND citas_fecha >= '" . strftime("%Y-%m-%d") . "' ";
    }
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new ope_citas(
            $row['citas_id'],
            $row['citas_servicios_id'],
            $row['citas_proveedor_id'],
            $row['citas_clientes_id'],
            $row['citas_estatus'],
            $row['citas_fecha'],
            $row['citas_hora'],
            $row['citas_notas'],
            $row['citas_fecha_creo'],
            $row['citas_sala']
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}


function consultar_citas_sin_sala()
{
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT * FROM gestion_citas.ope_citas AS oc "
        . "INNER JOIN gestion_citas.cat_clientes AS cc ON oc.citas_clientes_id = cc.clientes_id "
        . "INNER JOIN gestion_citas.cat_usuarios AS cu ON oc.citas_proveedor_id = cu.usuarios_id "
        . "INNER JOIN gestion_citas.cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id "
        . "INNER JOIN gestion_citas.cat_categorias AS cca ON cs.servicios_categoria_id = cca.categorias_id "
        . "WHERE citas_estatus='activo' AND citas_sala = ''";
    //echo $query;
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cls_ope_citas(
            $row['citas_id'],
            $row['citas_servicios_id'],
            $row['citas_proveedor_id'],
            $row['citas_clientes_id'],
            $row['citas_estatus'],
            $row['citas_fecha'],
            $row['citas_hora'],
            $row['citas_notas'],
            $row['citas_fecha_creo'],
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
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}



function consultar_cls($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexión con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT * FROM gestion_citas.ope_citas AS oc "
        . "INNER JOIN gestion_citas.cat_clientes AS cc ON oc.citas_clientes_id = cc.clientes_id "
        . "INNER JOIN gestion_citas.cat_usuarios AS cu ON oc.citas_proveedor_id = cu.usuarios_id "
        . "INNER JOIN gestion_citas.cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id "
        . "INNER JOIN gestion_citas.cat_categorias AS cca ON cs.servicios_categoria_id = cca.categorias_id "
        . "WHERE citas_estatus='" . $filtros->citas_estatus . "' ";
    if ($filtros->citas_servicios_id != -1) {
        $query .= "AND citas_servicios_id = " . $filtros->citas_servicios_id . " ";
    }
    if ($filtros->citas_proveedor_id != -1) {
        $query .= "AND citas_proveedor_id = " . $filtros->citas_proveedor_id . " ";
    }
    if ($filtros->citas_fecha != "") {
        $query .= "AND citas_fecha LIKE '%" . $filtros->citas_fecha . "%' ";
    }
    if ($filtros->citas_sala != "") {
        $query .= "AND citas_sala = '" . $filtros->citas_sala . "' ";
    }
    //variable para mostrar u ocultar citas que ya hayan pasado
    if ($filtros->citas_atendidas == "") {
        setlocale(LC_TIME, "es_ES");
        $query .= "AND citas_fecha >= '" . strftime("%Y-%m-%d") . "' ";
    }
    $query .= "ORDER BY oc.citas_hora ASC";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = [
            'citas_id' => $row['citas_id'],
            'citas_estatus' => $row['citas_estatus'],
            'citas_servicios_id' => $row['citas_servicios_id'],
            'citas_proveedor_id' => $row['citas_proveedor_id'],
            'citas_clientes_id' => $row['citas_clientes_id'],
            'citas_fecha' => $row['citas_fecha'],
            'citas_hora' => $row['citas_hora'],
            'citas_notas' => $row['citas_notas'],
            'citas_fecha_creo' => $row['citas_fecha_creo'],
            'citas_sala' => $row['citas_sala'],
            'servicios_id' => $row['servicios_id'],
            'servicios_nombre' => $row['servicios_nombre'],
            'servicios_duracion' => $row['servicios_duracion'],
            'servicios_precio' => $row['servicios_precio'],
            'categorias_id' => $row['categorias_id'],
            'categorias_nombre' => $row['categorias_nombre'],
            'clientes_id' => $row['clientes_id'],
            'clientes_nombre' => $row['clientes_nombre'] . " " . $row['clientes_apellido_p'] . " " . $row['clientes_apellido_m'],
            'clientes_correo' => $row['clientes_correo'],
            'clientes_telefono' => $row['clientes_telefono'],
            'usuarios_nombre' => $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m']
        ];
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}





function consultar_horas_ocupadas($proveedor_id, $fecha)
{
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT oc.citas_hora as hora_inicio, cs.servicios_duracion as duracion, oc.citas_proveedor_id, oc.citas_fecha FROM gestion_citas.ope_citas as oc INNER JOIN gestion_citas.cat_servicios as cs ON oc.citas_servicios_id = cs.servicios_id WHERE oc.citas_proveedor_id=" . $proveedor_id . " AND oc.citas_fecha='" . $fecha . "'";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cls_horas_ocupadas(
            $row['hora_inicio'],
            intval($row['duracion']) - 1,
            $row['citas_proveedor_id'],
            $row['citas_fecha']
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}




function consultar_salas_ocupadas($fecha)
{
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT oc.citas_sala, oc.citas_hora as hora_inicio, cs.servicios_duracion as duracion, oc.citas_id, oc.citas_fecha FROM gestion_citas.ope_citas as oc INNER JOIN gestion_citas.cat_servicios as cs ON oc.citas_servicios_id = cs.servicios_id WHERE oc.citas_fecha='" . $fecha . "'";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cls_salas_ocupadas(
            $row['hora_inicio'],
            intval($row['duracion']) - 1,
            $row['citas_id'],
            $row['citas_fecha'],
            $row['citas_sala']
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}


function verificar_citas_cliente($id)
{
    $resultado = "";
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "SELECT * FROM gestion_citas.ope_citas WHERE citas_clientes_id=" . $id;
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    if ($result->fetch(PDO::FETCH_ASSOC) == true) {
        $resultado = "{\"mensaje\":\"encontrado\"}";
    } else {
        $resultado = "{\"mensaje\":\"sin_citas\"}";
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo $resultado;
}
