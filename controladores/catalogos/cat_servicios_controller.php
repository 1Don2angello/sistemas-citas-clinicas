<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDB.php";
    require "../../entidades/cat_servicios.php";        
    require "../../entidades/utils/cls_combo.php";        
        


    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];

    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        
        case "consultar":
            consultar($_POST['obj_filtros']);
            break;

        case "consultar_info_servicio":
            consultar_info_servicio($_POST['id']);
            break;

        case "combo_servicios":
            combo_servicios();
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

        $query = "INSERT INTO `cat_servicios` ". 
        "(`servicios_id`,`servicios_categoria_id`,`servicios_descripcion`,`servicios_nombre`,`servicios_duracion`,`servicios_precio`) ".
        "VALUES (NULL, ".        
        "'".$filtros->servicios_categoria_id."', ".
        "'".$filtros->servicios_descripcion."', ".
        "'".$filtros->servicios_nombre."', ".
        "'".$filtros->servicios_duracion."', ".        
        "'".$filtros->servicios_precio."')";
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);
        
        //evaluamos si la operacion se realizó correctamente
        if($result==true){
            
            echo "{\"mensaje\":\"correcto\"}";
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
                
        $query = "UPDATE `cat_servicios` SET ".
        "servicios_categoria_id = '".$filtros->servicios_categoria_id."', ".
        "servicios_descripcion = '".$filtros->servicios_descripcion."', ".        
        "servicios_nombre = '".$filtros->servicios_nombre."', ".        
        "servicios_duracion = '".$filtros->servicios_duracion."', ".        
        "servicios_precio = '".$filtros->servicios_precio."' ".                
        "WHERE servicios_id = ".$filtros->servicios_id."
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
        //variable de la consulta SQL
        
        $query = "DELETE FROM `cat_servicios` WHERE servicios_id = " . $id;
        
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
        $query = "SELECT cs.*,cc.categorias_nombre FROM cat_servicios AS cs ".
        "INNER JOIN cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id ".
        "WHERE servicios_nombre LIKE '%".$filtros->servicios_nombre."%'";

        if($filtros->servicios_categoria_id != -1)
            $query.= "AND servicios_categoria_id = " . $filtros->servicios_categoria_id;
            
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        
        
        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
            
            $item = new cat_servicios(
                $row['servicios_id'],
                $row['servicios_categoria_id'],
                $row['servicios_descripcion'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],                
                $row['servicios_precio'],
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



    function consultar_info_servicio($id){
        
        
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        

        //variable de la consulta SQL
        $query = "SELECT * FROM cat_servicios AS cs ".
        "INNER JOIN cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id ".
        "WHERE servicios_id = ".$id;
        
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        
        
        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
            
            $item = new cat_servicios(
                $row['servicios_id'],
                $row['servicios_categoria_id'],
                $row['servicios_descripcion'],
                $row['servicios_nombre'],
                $row['servicios_duracion'],                
                $row['servicios_precio'],
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
    }



    function combo_servicios(){
                
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        
        //variable de la consulta SQL
        $query = "SELECT * FROM cat_servicios AS cs INNER JOIN cat_categorias AS cc ON cs.servicios_categoria_id = cc.categorias_id";
        
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        

        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               

            $item = new cls_combo(
                $row['servicios_id'],
                $row['servicios_nombre'],
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

?>