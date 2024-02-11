<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDB.php";
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

    
    

    /*
    * - programó: Juan Carlos Gómez Rangel
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
                
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_usuarios WHERE usuarios_usuario = '".$filtros->usuarios_usuario."' AND usuarios_clave = '".$filtros->usuarios_clave."'";

        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        
        $nombre_usuario;

        //recorremos el resultado fila por fila
        if(($row = mysqli_fetch_array($result))==true){                       
            $encontrado=true;
            $nombre_usuario = $row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m'];
        }else{
            $encontrado=false;
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        if($encontrado)
            echo "{\"mensaje\":\"correcto\",\"nombre\":\"".$nombre_usuario."\"}";
        else
            echo "{\"mensaje\":\"error\"}";
    }

    


    function validar_usuario(){
        session_start();        

        if(isset($_SESSION["usuario"])){
            
            echo "{\"mensaje\":\"correcto\",\"rol\":\"".$_SESSION["rol"]."\" , \"nombre_usuario\":\"".$_SESSION['nombre_usuario']."\" , \"usuarios_id\" : ".$_SESSION['usuario_id']."}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        } 
    }





    function crear_session($user,$pass){

    
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_usuarios WHERE usuarios_usuario = '".$user."' AND usuarios_clave = '".$pass."'";

        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        if(($row = mysqli_fetch_array($result))==true){                       
            
            session_start();
            $_SESSION["usuario"]=$user;
            $_SESSION["clave"]=$pass;            
            $_SESSION["rol"]=$row['usuarios_rol'];
            $_SESSION["nombre_usuario"]=$row['usuarios_nombre'] . " " . $row['usuarios_apellido_p'] . " " . $row['usuarios_apellido_m'];
            $_SESSION["usuario_id"] = $row['usuarios_id'];
            echo "{\"mensaje\":\"correcto\"}";

        }else{
            echo "{\"mensaje\":\"error\"}";
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
        

    }

    
?>