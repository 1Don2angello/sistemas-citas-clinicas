<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "gestion_citas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa";

// Opcional: seleccionar la base de datos
// if (!$conn->select_db($database)) {
//     die("No se pudo seleccionar la base de datos: " . $conn->error);
// }
?>
