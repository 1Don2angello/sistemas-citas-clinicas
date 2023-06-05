<?php
    /*  define('BD_SERVER', 'localhost');
     define('DB_USER','root');
     define('DB_PASS','');
     define('DB_NAME','AutocarV4');
     
     $conn = mysqli_connect(BD_SERVER, DB_USER, DB_PASS, DB_NAME);
     
     if(!$conn) {
          echo 'Conexión fallida';
     }
     else {
          echo '';
     } */
$serverName = "LAPTOP-GOI9E2B5\SQLEXPRESS";
$database = "gestion_citas";
$username = "admin";
$password = "admin123456789";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a SQL Server";
} catch (PDOException $e) {
    echo "Error al conectar a SQL Server: " . $e->getMessage();
}
