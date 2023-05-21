<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDB.php";
    require "../../entidades/cat_clientes.php";        
        


    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;

        case "consultar_exacto":
            consultar_exacto($_POST['obj_filtros']);
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

        default:
            echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
            break;
    }

    
    

    function agregar($obj_filtros){                        
        
        $filtros = json_decode($obj_filtros);                

        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL

        $query = "INSERT INTO `cat_clientes` ". 
        "(`clientes_id`,`clientes_nombre`,`clientes_apellido_p`,`clientes_apellido_m`,`clientes_telefono`,`clientes_correo`,`clientes_direccion`,`clientes_sexo`,`clientes_edad`) ".
        "VALUES (NULL, ".        
        "'".$filtros->clientes_nombre."', ".
        "'".$filtros->clientes_apellido_p."', ".
        "'".$filtros->clientes_apellido_m."', ".
        "'".$filtros->clientes_telefono."', ".
        "'".$filtros->clientes_correo."', ".
        "'".$filtros->clientes_direccion."', ".
        "'".$filtros->clientes_sexo."', ".
        "'".$filtros->clientes_edad."')";
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);
        
        //evaluamos si la operacion se realizó correctamente
        if($result==true){
            
            echo "{\"mensaje\":\"correcto\",\"id\":". $db_context->conexion->insert_id ."}";
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
        //variable de la consulta SQL
        
    
        $query = "UPDATE `cat_clientes` SET ".
        "clientes_nombre = '".$filtros->clientes_nombre."', ".
        "clientes_apellido_p = '".$filtros->clientes_apellido_p."', ".        
        "clientes_apellido_m = '".$filtros->clientes_apellido_m."', ".        
        "clientes_telefono = '".$filtros->clientes_telefono."', ".        
        "clientes_correo = '".$filtros->clientes_correo."', ".        
        "clientes_direccion = '".$filtros->clientes_direccion."', ".        
        "clientes_sexo = '".$filtros->clientes_sexo."', ".        
        "clientes_edad = '".$filtros->clientes_edad."' ".        
        "WHERE clientes_id = ".$filtros->clientes_id."
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



        //--------- eliminar todas las citas a su nombre -----------

        mysqli_query($db_context->conexion,"DELETE FROM ope_citas WHERE citas_clientes_id = " . $id);

        //----------------------------------------------------------



        //variable de la consulta SQL        
        $query = "DELETE FROM `cat_clientes` WHERE clientes_id = " . $id;
        
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



    function consultar($obj_filtros){
        
        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_clientes ".
        "WHERE clientes_nombre LIKE '%".$filtros->clientes_nombre."%' ".
        "AND clientes_apellido_p LIKE '%".$filtros->clientes_apellido_p."%' ".
        "AND clientes_apellido_m LIKE '%".$filtros->clientes_apellido_m."%'";        
        
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
            
            $item = new cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']                
            );
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }




    function consultar_exacto($obj_filtros){

        $filtros = json_decode($obj_filtros);
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_clientes ".
        "WHERE clientes_nombre = '".$filtros->clientes_nombre."' ".
        "AND clientes_apellido_p = '".$filtros->clientes_apellido_p."' ".
        "AND clientes_apellido_m = '".$filtros->clientes_apellido_m."'";        
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
            
            $item = new cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']                
            );
            
            //agregamos el array interno al array de resultado
            array_push($lista_resultado, $item);
        }

        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        

        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }




    function consultar_por_id($id){
                
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_clientes ".
        "WHERE clientes_id = ".$id;        
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        if(($row = mysqli_fetch_array($result))==true){                               
            
            $item = new cat_clientes(
                $row['clientes_id'],
                $row['clientes_nombre'],
                $row['clientes_apellido_p'],
                $row['clientes_apellido_m'],
                $row['clientes_telefono'],
                $row['clientes_correo'],
                $row['clientes_direccion'],
                $row['clientes_sexo'],
                $row['clientes_edad']                
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