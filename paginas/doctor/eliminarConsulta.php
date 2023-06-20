<?php
include('../../configDBsqlserver.php');
try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $eliminarConsulta = "DELETE FROM gestion_citas.pacientes WHERE id=:id";
        $stmt = $conn2->prepare($eliminarConsulta);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header('location:consultas.php?respuesta=ELIMINADO CORRECTAMENTE');
        }
    }
} catch (Exception $e) {
    header('location:consultas.php?respuesta=ERROR'. $e->getMessage());
}
?>
