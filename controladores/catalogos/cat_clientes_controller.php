<?php
//agregamos todas las referencias necesarias
require "../../configDB.php";
require "../../entidades/cat_clientes.php";

//variable que indica a cual funcion hace referencia la peticion ajax
$funcion = $_POST['funcion'];
//evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
switch ($funcion) {
    case "consultar":
        consultar($_POST['obj_filtros']);
        break;
    case "consultar_exacto":
        consultar_exacto($_POST['obj_filtros']);
        break;
    case "consultar_por_id":
        consultar_por_id($_POST['id']);
        break;
    /* case "agregar":
        agregar($_POST['obj_filtros']);
        break;
    case "actualizar":
        actualizar($_POST['obj_filtros']);
        break;
    case "eliminar":
        eliminar($_POST['id']);
        break; */
    default:
        echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
        break;
}
/* function agregar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    // Crear la instancia de la clase BaseDatos
    $db_context = new BaseDatos();
    // Variable de la consulta SQL
    $query = "INSERT INTO gestion_citas.cat_clientes " .
        "(clientes_nombre, clientes_apellido_p, clientes_apellido_m, clientes_telefono, Correo, clientes_direccion, clientes_sexo, clientes_edad) " .
        "VALUES (" .
        "'" . $filtros->clientes_nombre . "', " .
        "'" . $filtros->clientes_apellido_p . "', " .
        "'" . $filtros->clientes_apellido_m . "', " .
        "'" . $filtros->clientes_telefono . "', " .
        "'" . $filtros->Correo . "', " .
        "'" . $filtros->clientes_direccion . "', " .
        "'" . $filtros->clientes_sexo . "', " .
        "'" . $filtros->clientes_edad . "')";
    // Imprimir la consulta SQL
    echo "Consulta SQL: " . $query;

    // Variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    // Evaluamos si la operación se realizó correctamente
    if ($result == true) {
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
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //variable de la consulta SQL
    $query = "UPDATE gestion_citas.cat_clientes SET " .
        "clientes_nombre = '" . $filtros->clientes_nombre . "', " .
        "clientes_apellido_p = '" . $filtros->clientes_apellido_p . "', " .
        "clientes_apellido_m = '" . $filtros->clientes_apellido_m . "', " .
        "clientes_telefono = '" . $filtros->clientes_telefono . "', " .
        "Correo = '" . $filtros->Correo . "', " .
        "clientes_direccion = '" . $filtros->clientes_direccion . "', " .
        "clientes_sexo = '" . $filtros->clientes_sexo . "', " .
        "clientes_edad = '" . $filtros->clientes_edad . "' " .
        "WHERE clientes_id = " . $filtros->clientes_id;
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //evaluamos si la operacion se realizó correctamente
    if ($result) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }
}

function eliminar($id)
{
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos();
    //--------- eliminar todas las citas a su nombre -----------
    $db_context->conexion->query("DELETE FROM gestion_citas.ope_citas WHERE citas_clientes_id = " . $id);
    //----------------------------------------------------------
    //variable de la consulta SQL        
    $query = "DELETE FROM gestion_citas.cat_clientes WHERE clientes_id = " . $id;
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //evaluamos si la operacion se realizó correctamente
    if ($result) {
        echo "{\"mensaje\":\"correcto\"}";
    } else {
        echo "{\"mensaje\":\"error\"}";
    }
}
 */


function consultar($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos2();
    //variable de la consulta SQL
    $query = "SELECT * FROM dbo.catEmpleados " .
        "WHERE Nombre LIKE '%" . $filtros->clientes_nombre . "%' " .
        "AND Paterno LIKE '%" . $filtros->clientes_apellido_p . "%' " .
        "AND Materno LIKE '%" . $filtros->clientes_apellido_m . "%'";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cat_clientes(
            $row['Id'],
            $row['Nombre'],
            $row['Paterno'],
            $row['Materno'],
            $row['Telefono'],
            $row['Correo'],
            $row['Depto'],
          
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
} 
function consultar_exacto($obj_filtros)
{
    $filtros = json_decode($obj_filtros);
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos2();
    //variable de la consulta SQL
    $query = "SELECT * FROM dbo.catEmpleados " .
        "WHERE Nombre = '" . $filtros->clientes_nombre . "' " .
        "AND Paterno = '" . $filtros->clientes_apellido_p . "' " .
        "AND Materno = '" . $filtros->clientes_apellido_m . "'";
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cat_clientes(
            $row['Id'],
            $row['Nombre'],
            $row['Paterno'],
            $row['Materno'],
            $row['Telefono'],
            $row['Correo'],
            $row['Depto'],
            
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}





function consultar_por_id($id)
{
    $lista_resultado = []; //variable en la que se almacena el resultado de la consulta
    //creamos la conexion con la base de datos
    $db_context = new BaseDatos2();
    //variable de la consulta SQL
    $query = "SELECT * FROM dbo.catEmpleados " .
        "WHERE Id = " . $id;
    //variable que contiene el resultado de la consulta
    $result = $db_context->conexion->query($query);
    //recorremos el resultado fila por fila
    if (($row = $result->fetch(PDO::FETCH_ASSOC)) == true) {
        $item = new cat_clientes(
            $row['Id'],
            $row['Nombre'],
            $row['Paterno'],
            $row['Materno'],
            $row['Telefono'],
            $row['Correo'],
            $row['Depto'],
           
        );
        //agregamos el array interno al array de resultado
        array_push($lista_resultado, $item);
    }
    //cerramos la conexion con la base de datos
    $db_context->desconectar($db_context->conexion);
    //retornamos el resultado obtenido
    echo json_encode($lista_resultado);
}
  