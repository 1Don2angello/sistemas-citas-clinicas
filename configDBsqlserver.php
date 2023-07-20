<?php

$serverName2 = "LAPTOP-GOI9E2B5\SQLEXPRESS";/* LAPTOP-GOI9E2B5\SQLEXPRESS */
$database2 = "gestion_citas";
$username2 = "admin";
$password2 = "admin123456789";
try {
    $conn2 = new PDO("sqlsrv:Server=$serverName2;Database=$database2", $username2, $password2);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Tabla pacientes";
} catch (PDOException $e) {
    echo "Error al conectar a SQL Server 2: " . $e->getMessage();
}

