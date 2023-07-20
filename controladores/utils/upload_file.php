<?php 

	//error_reporting(0);
	//$nombre=$_FILES['file_lista']['name'];
	$guardado=$_FILES['file_lista']['tmp_name'];
	$nombre="logotipo_edit.jpg";	

	$directorio_save = "../../img";

	try{

		if(!file_exists($directorio_save)){

			mkdir($directorio_save,0777,true);

			if(file_exists($directorio_save)){

				move_uploaded_file($guardado, $directorio_save.'/'.$nombre);
				echo "{\"mensaje\":\"correcto\"}";				
			}
			
		}else{

			move_uploaded_file($guardado, $directorio_save.'/'.$nombre);
			echo "{\"mensaje\":\"correcto\"}";			
		}

	}catch(Exception $e){

		echo "{\"mensaje\":\"error\",\"detalles\":\"".$e->getMessage()."\"}";	
	}

?>    
