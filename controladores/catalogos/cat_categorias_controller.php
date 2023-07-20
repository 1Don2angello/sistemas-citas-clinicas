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

<<<<<<< HEAD
    function agregar($obj_filtros){                        
        $filtros = json_decode($obj_filtros); 
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "INSERT INTO gestion_citas.cat_categorias (categorias_nombre, categorias_descripcion) VALUES ('".$filtros->categorias_nombre."', '".$filtros->categorias_descripcion."')";
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //evaluamos si la operacion se realizó correctamente
        if($result == true){
            echo "{\"mensaje\":\"correcto\"}";
        } else{
            echo "{\"mensaje\":\"error\"}";
        }
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
    }
    


    function actualizar($obj_filtros){
        $filtros = json_decode($obj_filtros);
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "UPDATE gestion_citas.cat_categorias SET ".
        "categorias_nombre = '".$filtros->categorias_nombre."', ".
        "categorias_descripcion = '".$filtros->categorias_descripcion."' ".
        "WHERE categorias_id = ".$filtros->categorias_id;
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        //evaluamos si la operacion se realizó correctamente
        if($result == true){
            echo "{\"mensaje\":\"correcto\"}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
=======


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
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
    }
    

    // No cerramos la conexión con la base de datos aquí, ya que la conexión está siendo manejada externamente
}

function consultar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; // variable en la que se almacena el resultado de la consulta

<<<<<<< HEAD
    function eliminar($id){
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "DELETE FROM gestion_citas.cat_categorias WHERE categorias_id = " . $id;
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        //evaluamos si la operacion se realizó correctamente
        if($result == true){
            echo "{\"mensaje\":\"correcto\"}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
    }
    
=======
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
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25

    // Retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}

<<<<<<< HEAD
    function consultar($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_categorias WHERE categorias_nombre LIKE '%".$filtros->categorias_nombre."%'";
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //recorremos el resultado fila por fila
        while(($row = $result->fetch(PDO::FETCH_ASSOC)) == true){
            $item = new cat_categorias(
                $row['categorias_id'],
                $row['categorias_nombre'],
                $row['categorias_descripcion']
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
=======
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
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
    }
    

    // Cerramos la conexión con la base de datos
    $db_context->desconectar($db_context->conexion);

<<<<<<< HEAD
    function combo_categorias(){
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_categorias";
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
        //recorremos el resultado fila por fila
        while(($row = $result->fetch(PDO::FETCH_ASSOC)) == true){
            $item = new cls_combo(
                $row['categorias_id'],
                $row['categorias_nombre']
            );
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }
    
=======
    // Retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
