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
    
    
<<<<<<< HEAD

    /*
    * - programó: teodoro perez
    * - nombre: consultar_usuarios
    * - fecha: 8/06/2021    
    * - retorno: array json compuestos de objetos tipo "tbl_pacientes"
    * - parametros: $obj_filtros (objeto del tipo "tbl_pacientes" para realizar busquedas)
    * - descripcion: consulta todos los pacientes que esten registrados
                en la base de datos segun los filtros que le pasen
    */
    function consultar_usuario($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
    
=======
    function consultar_usuario($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_usuarios WHERE usuarios_usuario = '".$filtros->usuarios_usuario."' AND usuarios_clave = '".$filtros->usuarios_clave."'";
<<<<<<< HEAD
    
        //variable que contiene el resultado de la consulta
        $result = $db_context->conexion->query($query);
    
        //recorremos el resultado fila por fila
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if($row !== false){                       
            $encontrado = true;
            $nombre_usuario = $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m'];
        }else{
            $encontrado = false;
        }
    
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
    
=======
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
>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
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

<<<<<<< HEAD



    
    function crear_session($user, $pass){
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM gestion_citas.cat_usuarios WHERE usuarios_usuario = :user AND usuarios_clave = :pass";
        
        //preparar la consulta
        $stmt = $db_context->conexion->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':pass', $pass);
    
        //ejecutar la consulta
        $stmt->execute();
    
        //recorremos el resultado fila por fila
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row !== false){                       
            session_start();
            $_SESSION["usuario"] = $user;
            $_SESSION["clave"] = $pass;            
            $_SESSION["rol"] = $row['usuarios_rol'];
            $_SESSION["nombre_usuario"] = $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m'];
            $_SESSION["usuario_id"] = $row['usuarios_id'];
            echo "{\"mensaje\":\"correcto\"}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
    
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
    }
    
    
=======
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

>>>>>>> 7c20d1e4be1df92e621ebef12237c1223a81ca25
?>