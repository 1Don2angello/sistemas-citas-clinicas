eliminarHistorial.php

<?php
include('../../configDBsqlserver.php');
try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $eliminarConsulta = "DELETE FROM gestion_citas.historial WHERE id=:id";
        $stmt = $conn2->prepare($eliminarConsulta);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('location:historial.php?respuesta=Exito ');
        } else {
            header('location:historial.php?respuesta=Error ');
        }
    }
} catch (Exception $e) {
    header('location:historial.php?respuesta=MAL');
}
