<?php

    $file = $_GET["file_path"];

    header("Content-disposition: attachment; filename=" . basename($file));
    header("Content-type: application/vnd.ms-excel");
    readfile($file);

    unlink($file);

/* 
 $file = $_GET["file_path"];
 
 if (file_exists($file)) {
     header("Content-disposition: attachment; filename=" . basename($file));
     header("Content-type: application/vnd.ms-excel");
     readfile($file);
 } else {
     echo "El archivo no se encontró en la ubicación especificada.";
 }

  */

?>

