<?php
$serverName = "LAPTOP-GOI9E2B5\SQLEXPRESS";
$database = "BD Empleados";
$username = "admin";
$password = "admin123456789";

try {
  // Establecer la conexión a la base de datos
  $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Obtener el valor de la clave enviada desde el formulario
  $clave = $_GET['clave'];

  // Realizar la consulta en la base de datos
  $query = "SELECT Nombre, Paterno, Materno, Depto, Fecha_Nacimiento,Telefono, Correo FROM dbo.BD2 WHERE clave = '$clave'";
  $stmt = $conn->query($query);
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);

  // Devolver los resultados en formato JSON
  echo json_encode($rows);
} catch (PDOException $e) {
  // Manejar errores de conexión o consulta
  echo "Error al realizar la consulta: " . $e->getMessage();
}



