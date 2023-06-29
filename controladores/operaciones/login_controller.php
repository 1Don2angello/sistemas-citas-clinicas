<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/cat_usuarios.php";    


    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        case "consultar_usuario":
            consultar_usuario($_POST['obj_filtros']);
            break;
        case "crear_session":
            crear_session($_POST['user'],$_POST['pass']);
            break;
        case "validar_usuario":
            validar_usuario();
            break;
        case "cerrar_session":
            session_start();
            $_SESSION = array();            
            session_destroy();
            break;            
        default:
            echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
            break;
    }
    
    
    function consultar_usuario($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_usuarios WHERE usuarios_usuario = '".$filtros->usuarios_usuario."' AND usuarios_clave = '".$filtros->usuarios_clave."'";
        //variable que contiene el resultado de la consulta
        $stmt = sqlsrv_query($db_context->conexion, $query);
        //verificamos si la consulta se realizó correctamente
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $nombre_usuario;
        $encontrado = false;
        //recorremos el resultado fila por fila
        if (sqlsrv_fetch($stmt) === true) {
            $encontrado = true;
            $nombre_usuario = sqlsrv_get_field($stmt, 2) . " " . sqlsrv_get_field($stmt, 3) . " " . sqlsrv_get_field($stmt, 4);
        }
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);
        //retornamos el resultado obtenido
        if ($encontrado) {
            echo "{\"mensaje\":\"correcto\",\"nombre\":\"".$nombre_usuario."\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
    }

    function validar_usuario(){
        session_start();        
        if(isset($_SESSION["usuario"])){
            
            echo "{\"mensaje\":\"correcto\",\"rol\":\"".$_SESSION["rol"]."\" , \"nombre_usuario\":\"".$_SESSION['nombre_usuario']."\" , \"usuarios_id\" : ".$_SESSION['usuario_id']."}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        } 
    }

    function crear_session($user, $pass) {
        // Creamos la instancia de la clase BaseDatos
        $db_context = new BaseDatos();
        // Variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_usuarios WHERE usuarios_usuario = '$user' AND usuarios_clave = '$pass'";
        // Ejecutar la consulta SQL
        $result = sqlsrv_query($db_context->conexion, $query);
    
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        // Recorrer el resultado fila por fila
        if (sqlsrv_fetch($result) === true) {
            session_start();
            $_SESSION["usuario"] = $user;
            $_SESSION["clave"] = $pass;
            $_SESSION["rol"] = sqlsrv_get_field($result, 2); // Cambiar el número por el índice correcto del campo rol
            $_SESSION["nombre_usuario"] = sqlsrv_get_field($result, 3) . " " . sqlsrv_get_field($result, 4) . " " . sqlsrv_get_field($result, 5); // Cambiar los índices por los índices correctos de los campos nombre, apellido_p y apellido_m
            $_SESSION["usuario_id"] = sqlsrv_get_field($result, 0); // Cambiar el número por el índice correcto del campo usuario_id
            echo "{\"mensaje\":\"correcto\"}";
        } else {
            echo "{\"mensaje\":\"error\"}";
        }
        // Cerrar el resultado
        sqlsrv_free_stmt($result);
        // Desconectar la base de datos
        $db_context->desconectar();
    }

?>