<?php

$serverName = "LAPTOP-GOI9E2B5\SQLEXPRESS";
$database = "gestion_citas";
$username = "admin";
$password = "admin123456789";
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a SQL Server 1 ";
} catch (PDOException $e) {
    echo "Error al conectar a SQL Server 1: " . $e->getMessage();
}


$serverName2 = "LAPTOP-GOI9E2B5\SQLEXPRESS";
$database2 = "BD Empleados";/* SYSRH.CAT_EMPLEADOS */
$username2 = "admin";
$password2 = "admin123456789";
try {
    $conn2 = new PDO("sqlsrv:Server=$serverName2;Database=$database2", $username2, $password2);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo ",Conexión exitosa a SQL Server 2";
} catch (PDOException $e) {
    echo ",Error al conectar a SQL Server 2 : " . $e->getMessage();
}

// Utilizar $conn1 y $conn2 para realizar consultas y operaciones en las respectivas bases de datos