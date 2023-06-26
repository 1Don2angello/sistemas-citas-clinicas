<?php
    
    //agregamos todas las referencias necesarias
    require "../../configDBsqlserver%20copy.php";
    require "../../entidades/ope_citas.php";
    require "../../entidades/cls/cls_ope_citas.php";
    require '../../plugins/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;        

    //variable que indica a cual funcion hace referencia la peticion ajax
    $funcion = $_POST['funcion'];
    //evaluamos el contenido del valor recibido por POST y ejecutamos la funcion segun los parametros recibidos
    switch($funcion){
        case "consultar_cls":
            consultar_cls($_POST['obj_filtros']);
            break;
        case "exportar_excel":
            exportar_excel($_POST['obj_json']);
            break;
        default:
            echo "{\"mensaje\":\"No se ha especificado una funcion valida\"}";
            break;
    }

    function consultar_cls($obj_filtros){
        $filtros = json_decode($obj_filtros);
        $fecha_inicio = explode(",",$filtros->citas_fecha)[0];
        $fecha_fin = explode(",",$filtros->citas_fecha)[1];
        $hora_inicio = explode(",",$filtros->citas_hora)[0];
        $hora_fin = explode(",",$filtros->citas_hora)[1];
        $lista_resultado = [];//variable en la que se almacena el resultado de la consulta
        //creamos la conexion con la base de datos
        $db_context = new BaseDatos();
        //variable de la consulta SQL
        $query = "SELECT * FROM ope_citas AS oc "
        ."INNER JOIN cat_clientes AS cc ON oc.citas_clientes_id = cc.clientes_id "
        ."INNER JOIN cat_servicios AS cs ON oc.citas_servicios_id = cs.servicios_id "
        ."INNER JOIN cat_categorias AS cca ON cs.servicios_categoria_id = cca.categorias_id "
        ."INNER JOIN cat_usuarios AS cu ON oc.citas_proveedor_id = cu.usuarios_id "
        ."WHERE oc.citas_estatus='". $filtros->citas_estatus ."' ";
        if($filtros->servicios_id!=-1){
            $query.= "AND oc.citas_servicios_id = " . $filtros->servicios_id . " ";
        }
        if($filtros->proveedores_id!=-1){
            $query.= "AND oc.citas_proveedor_id = " . $filtros->proveedores_id . " ";
        }
        if($filtros->clientes_id!=-1){
            $query.= "AND cc.clientes_id =".$filtros->clientes_id." ";
        }
        if($fecha_inicio!=""){
            $query.= "AND oc.citas_fecha >= '" . $fecha_inicio . "' ";
        }
        if($fecha_fin!=""){
            $query.= "AND oc.citas_fecha <= '" . $fecha_fin . "' ";
        }
        $query.="ORDER BY citas_fecha ASC";
        //echo $query;
        //variable que contiene el resultado de la consulta
        $result = mysqli_query($db_context->conexion,$query);        
        //recorremos el resultado fila por fila
        while(($row = mysqli_fetch_array($result))==true){                               
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
        if($hora_inicio==""){
            $hora_inicio="00:00";
        }
        if($hora_fin==""){
            $hora_fin="24:00";
        }
        $array_tmp=[];
        for($i=0;$i<sizeof($lista_resultado);$i++){
                        
            if(verificar_entre_horas($hora_inicio,$hora_fin,$lista_resultado[$i]->citas_hora)){
                array_push($array_tmp,$lista_resultado[$i]);
            }
        }
        $lista_resultado = $array_tmp;
        //cerramos la conexion con la base de datos
        $db_context->desconectar($db_context->conexion);        
        //retornamos el resultado obtenido
        echo json_encode($lista_resultado);
    }


    function exportar_excel($obj_json){
        
        try{


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $datos=json_decode($obj_json);
            $fila_indice=1;
            $columna_indice=1;
            
        
            foreach($datos as $fila){
        
                foreach($fila as $columna){
                            
                    $sheet->setCellValueByColumnAndRow($columna_indice, $fila_indice, $columna);            
                    $columna_indice++;
                }            
        
                $fila_indice++;     
                $columna_indice=1;   
            }
        
        
            $writer = new Xlsx($spreadsheet);
                    
            //dar tamaño automatico a las columnas
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)
                        ->setAutoSize(true);
            } 
        
        
            $ruta_archivo = "../../downloads/reporte_citas_". date('m-d-Y-h-i-s', time()).".xlsx";
            $writer->save($ruta_archivo);

            echo "{\"mensaje\":\"correcto\",\"file\":\"".$ruta_archivo."\"}";

        } catch (Exception $e) {

            echo "{\"mensaje\":\"error\"}";
        }

    }











    function verificar_entre_horas($hora_inicio,$hora_final,$hora){

        $hora_hrs = intval(explode(":",$hora)[0]);
        $hora_min = intval(explode(":",$hora)[1]);
        
        $hora_hrs_ini = intval(explode(":",$hora_inicio)[0]);
        $hora_min_ini = intval(explode(":",$hora_inicio)[1]);

        $hora_hrs_fin = intval(explode(":",$hora_final)[0]);
        $hora_min_fin = intval(explode(":",$hora_final)[1]);

        
        $estado=0;    
        while($estado != 6 && $estado != 7){
        
            switch ($estado) {
                
                case 0:
                
                    if($hora_hrs > $hora_hrs_ini){
                        $estado=3;
                    }else if($hora_hrs == $hora_hrs_ini){
                        $estado=2;
                    }else{
                        $estado=7;
                    }
                    
                    break;
                
                
                case 2:
                
                    if($hora_min >= $hora_min_ini){
                        $estado = 3;
                    }else{
                        $estado = 7;
                    }
                    
                    break;
                
                    
                case 3:
                    
                    if($hora_hrs < $hora_hrs_fin){
                        $estado=6;
                    }else if($hora_hrs == $hora_hrs_fin){
                        $estado=5;
                    }else{
                        $estado=7;
                    }
                    
                    break;
                
                
                case 5:
                
                    if($hora_min <= $hora_min_fin){
                        $estado=6;
                    }else{
                        $estado=7;
                    }
                    break;                        
                
            }
        
        }
        
        
        if($estado==6){
            return true;
        }else{
            return false;
        }
    
    }
?>