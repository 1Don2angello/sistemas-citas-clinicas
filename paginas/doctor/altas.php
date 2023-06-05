<?php
    include("conexion.php");
    /* $PersonID = isset($_GET["PersonID"]) ? $_GET["PersonID"] : null;
    $CustomerName = isset($_GET["CustomerName"]) ? $_GET["CustomerName"] : null;
    $LastName = isset($_GET["LastName"]) ? $_GET["LastName"] : null;
    $FirstName = isset($_GET["FirstName"]) ? $_GET["FirstName"] : null; */
    /* echo "ID: " . $PersonID . "<br>";
    echo "Nombre: " . $CustomerName . "<br>";
    echo "Paterno: " . $LastName . "<br>";
    echo "Materno: " . $FirstName . "<br>"; */

    $PersonID = $_GET["PersonID"];
    $CustomerName = $_GET["CustomerName"];
    $LastName = $_GET["LastName"];
    $FirstName = $_GET["FirstName"];

    $query="INSERT INTO Customers (PersonID, CustomerName, LastName, FirstName) 
            VALUES ('$PersonID','$CustomerName','$LastName','$FirstName')";
    $resultado=sqlsrv_prepare($conn,$query);

    if(sqlsrv_execute($resultado)){
        header('location:insertar.php?respuesta=El médico fue AGREGAD correctamente');//echo " Datos Insertados";
    }else{
        echo " error al insertardatods";
    }
?>