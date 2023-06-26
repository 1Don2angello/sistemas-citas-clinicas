<?php
//agregamos todas las referencias necesarias
require "../../configDBsqlserver%20copy.php";
require "../../entidades/cat_categorias.php";
require "../../entidades/utils/cls_combo.php";
//variable que indica a cual funcion hace referencia la peticion ajax
$funcion = $_POST['funcion'];
//evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
switch ($funcion) {
    case "consultar":
        consultar($_POST['obj_filtros']);
        break;
    case "combo_categorias":
        combo_categorias();
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


function agregar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);

    // Obtenemos la instancia de la clase BaseDatos existente
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "INSERT INTO  gestion_citas.cat_categorias (categorias_nombre, categorias_descripcion) VALUES (?, ?)";
    $params = array($filtros->categorias_nombre, $filtros->categorias_descripcion);

    // Preparamos la consulta
    $stmt = sqlsrv_prepare($db_context->conexion, $query, $params);

    // Ejecutamos la consulta
    $result = sqlsrv_execute($stmt);

    // Evaluamos si la operación se realizó correctamente
    if ($result !== false) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    // Cerramos la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);
}



function actualizar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    // Obtenemos la instancia de la clase BaseDatos existente
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "UPDATE  gestion_citas.cat_categorias SET " .
        "categorias_nombre = ?, " .
        "categorias_descripcion = ? " .
        "WHERE categorias_id = ?";

    $params = array($filtros->categorias_nombre, $filtros->categorias_descripcion, $filtros->categorias_id);

    // Preparamos la consulta
    $stmt = sqlsrv_prepare($db_context->conexion, $query, $params);

    // Ejecutamos la consulta
    $result = sqlsrv_execute($stmt);

    // Evaluamos si la operación se realizó correctamente
    if ($result !== false) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    // No cerramos la conexión con la base de datos aquí, ya que la conexión está siendo manejada externamente
}




function eliminar($id)
{
    // Obtenemos la instancia de la clase BaseDatos existente
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "DELETE FROM  gestion_citas.cat_categorias WHERE categorias_id = ?";

    $params = array($id);

    // Preparamos la consulta
    $stmt = sqlsrv_prepare($db_context->conexion, $query, $params);

    // Ejecutamos la consulta
    $result = sqlsrv_execute($stmt);

    // Evaluamos si la operación se realizó correctamente
    if ($result !== false) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }

    // No cerramos la conexión con la base de datos aquí, ya que la conexión está siendo manejada externamente
}

function consultar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; // variable en la que se almacena el resultado de la consulta

    // Obtenemos la instancia de la clase BaseDatos existente
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "SELECT * FROM  gestion_citas.cat_categorias WHERE categorias_nombre LIKE '%' + ? + '%'";
    $params = array($filtros->categorias_nombre);

    // Preparamos la consulta
    $stmt = sqlsrv_prepare($db_context->conexion, $query, $params);

    // Ejecutamos la consulta
    $result = sqlsrv_execute($stmt);

    // Recorremos el resultado fila por fila
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $item = new  gestion_citas.cat_categorias(
            $row['categorias_id'],
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

function combo_categorias()
{
    $lista_resultado = []; // variable en la que se almacena el resultado de la consulta

    // Obtenemos la instancia de la clase BaseDatos existente
    $db_context = new BaseDatos();

    // Variable de la consulta SQL
    $query = "SELECT * FROM  gestion_citas.cat_categorias";

    // Preparamos la consulta
    $stmt = sqlsrv_prepare($db_context->conexion, $query);

    // Ejecutamos la consulta
    $result = sqlsrv_execute($stmt);

    // Recorremos el resultado fila por fila
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $item = new cls_combo(
            $row['categorias_id'],
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
