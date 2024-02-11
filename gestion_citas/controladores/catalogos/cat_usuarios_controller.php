<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDB.php";
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

    
    

    function agregar($obj_filtros){                        
        
        $filtros = json_decode($obj_filtros);                

        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL

        $query = "INSERT INTO `cat_usuarios` ". 
        "(`usuarios_id`,`usuarios_nombre`,`usuarios_apellido_p`,`usuarios_apellido_m`,`usuarios_telefono`,`usuarios_correo`,`usuarios_direccion`,`usuarios_usuario`,`usuarios_clave`,`usuarios_rol`) ".
        "VALUES (NULL, ".
        "'".$filtros->usuarios_nombre."', ".
        "'".$filtros->usuarios_apellido_p."', ".
        "'".$filtros->usuarios_apellido_m."', ".        
        "'".$filtros->usuarios_telefono."', ".
        "'".$filtros->usuarios_correo."', ".
        "'".$filtros->usuarios_direccion."', ".
        "'".$filtros->usuarios_usuario."', ".
        "'".$filtros->usuarios_clave."', ".
        "'".$filtros->usuarios_rol."')";
                

        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);


        //evaluamos si la operacion se realizó correctamente
        if($result == true){
            echo "{\"mensaje\":\"correcto\",\"id\":".$db_context->conexion->insert_id."}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
        
        
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);  
        
    }



    function actualizar($obj_filtros){
        
        $filtros = json_decode($obj_filtros);

        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();


        //------ verificar que no tenga servicios -------

        $servicios = mysqli_query($db_context->conexion,"SELECT * FROM ope_rel_usuario_servicio WHERE usuarios_id = " . $filtros->usuarios_id);

        if($servicios == true){
            mysqli_query($db_context->conexion,"DELETE FROM ope_rel_usuario_servicio WHERE usuarios_id = " . $filtros->usuarios_id);
        }

        //-----------------------------------------------


        //variable de la consulta SQL
        $query = "UPDATE `cat_usuarios` SET ".
        "usuarios_nombre = '".$filtros->usuarios_nombre."', ".
        "usuarios_apellido_p = '".$filtros->usuarios_apellido_p."', ".        
        "usuarios_apellido_m = '".$filtros->usuarios_apellido_m."', ".        
        "usuarios_telefono = '".$filtros->usuarios_telefono."', ".        
        "usuarios_correo = '".$filtros->usuarios_correo."', ".        
        "usuarios_direccion = '".$filtros->usuarios_direccion."', ".        
        "usuarios_usuario = '".$filtros->usuarios_usuario."', ".        
        "usuarios_clave = '".$filtros->usuarios_clave."', ".        
        "usuarios_rol = '".$filtros->usuarios_rol."' ".        
        "WHERE usuarios_id = ".$filtros->usuarios_id."
        ";        
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);   
        


        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
        
        //evaluamos si la operacion se realizó correctamente
        if($result==true){
            echo "{\"mensaje\":\"correcto\"}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
    }



    function eliminar($id){

        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();


        //------ verificar que no tenga servicios -------

        $servicios = mysqli_query($db_context->conexion,"SELECT * FROM ope_rel_usuario_servicio WHERE usuarios_id = " . $id);

        if($servicios == true){
            mysqli_query($db_context->conexion,"DELETE FROM ope_rel_usuario_servicio WHERE usuarios_id = " . $id);
        }

        //-----------------------------------------------



        //variable de la consulta SQL        
        $query = "DELETE FROM `cat_usuarios` WHERE usuarios_id = " . $id;
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
                

        //evaluamos si la operacion se realizó correctamente
        if($result==true){
            echo "{\"mensaje\":\"correcto\"}";
        }else{
            echo "{\"mensaje\":\"error\"}";
        }
    }


    function consultar_por_id($id){
        
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query = "SELECT * FROM cat_usuarios ".
        "WHERE usuarios_id = ".$id;
                

        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        if(($row = mysqli_fetch_array($result))==true){                               
                        
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
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }


    function consultar($obj_filtros){
        
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query = "SELECT * FROM cat_usuarios ".
        "WHERE usuarios_nombre LIKE '%".$filtros->usuarios_nombre."%' ".
        "AND usuarios_apellido_p LIKE '%".$filtros->usuarios_apellido_p."%' ".
        "AND usuarios_apellido_m LIKE '%".$filtros->usuarios_apellido_m."%'";
        
        if($filtros->usuarios_rol!="Todos")
            $query .= "AND usuarios_rol LIKE '%".$filtros->usuarios_rol."%'"; 
        

        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
                        
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
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }



    function registrar_servicios_usuario($obj_filtros){

        $error="";
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        for($i=0;$i<sizeof($filtros);$i++){

            //variable de la consulta SQL
            $query = "INSERT INTO ope_rel_usuario_servicio ".
                    "(relacion_id,usuarios_id,servicios_id) ".
                    "VALUES (NULL,".$filtros[$i]->usuarios_id.",".$filtros[$i]->servicios_id.")";
                    

            //variable que contiene el resultado de la consulta
            $result = mysqli_query($db_context->conexion,$query);        

            //evaluamos si la operacion se realizó correctamente
            if($result==false){
                
                $error = "{\"mensaje\":\"error\"}";
                break;            
            }

        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        


        //retornamos el resultado obtenido
        if($error!=""){
            echo "{\"mensaje\":\"error\"}";
        }else{
            echo "{\"mensaje\":\"correcto\"}";
        }
    }



    function consultar_servicios_usuario($id){
        
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query = "SELECT * FROM ope_rel_usuario_servicio WHERE usuarios_id = " . $id;
                
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
                        
            $item = new ope_rel_usuario_servicio(
                $row['relacion_id'],
                $row['usuarios_id'],
                $row['servicios_id']                
            );
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }


    function consultar_usuarios_servicio($id){
        
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query = "SELECT cu.* FROM ope_rel_usuario_servicio AS orus ".
        "INNER JOIN cat_usuarios AS cu ON orus.usuarios_id = cu.usuarios_id ".
        "WHERE servicios_id = " . $id;
                
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
                        
            $item = new cls_combo(
                $row['usuarios_id'],
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



    function consultar_usuarios_servicio_sin_id(){

        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query="SELECT DISTINCT cu.usuarios_id,cu.* FROM cat_usuarios AS cu INNER JOIN ope_rel_usuario_servicio as orus ON orus.usuarios_id = cu.usuarios_id";        
                
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
                        
            $item = new cls_combo(
                $row['usuarios_id'],
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
?>