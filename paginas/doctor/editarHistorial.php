<?php
include('../../configDBsqlserver.php'); // Conexión a la base de datos SQL Server

try {
    if (isset($_POST['editar'])) {
        $id = $_POST['id']; // Se obtiene el ID del registro a editar
        $clave = $_POST['clave'];
        $nombre = $_POST['nombre'];
        $sexo = $_POST['sexo'];
        $edad = $_POST['edad'];
        $altura = $_POST['altura'];
        $peso = $_POST['peso'];
        $analisisCovid = $_POST['analisisCovid'];
        $sintomas = $_POST['sintomas'];
        $diagnostico = $_POST['diagnostico'];
        $tratamiento = $_POST['tratamiento'];
        $instrucciones = $_POST['instrucciones'];

        $sqlEditarHistorial = "UPDATE gestion_citas.historial SET clave = :clave, nombre = :nombre, sexo = :sexo, edad = :edad, altura = :altura, peso = :peso, analisisCovid = :analisisCovid, sintomas = :sintomas, diagnostico = :diagnostico, tratamiento = :tratamiento, instrucciones = :instrucciones WHERE id = :id";

        $stmt = $conn2->prepare($sqlEditarHistorial);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':edad', $edad);
        $stmt->bindParam(':altura', $altura);
        $stmt->bindParam(':peso', $peso);
        $stmt->bindParam(':analisisCovid', $analisisCovid);
        $stmt->bindParam(':sintomas', $sintomas);
        $stmt->bindParam(':diagnostico', $diagnostico);
        $stmt->bindParam(':tratamiento', $tratamiento);
        $stmt->bindParam(':instrucciones', $instrucciones);
        
        if ($stmt->execute()) {
            header('location:historial.php?respuesta=Exito ');
        } else {
            header('location:historial.php?respuesta=Error ');
        }
    }
} catch (Exception $e) {
    header('location:consultas.php?respuesta=Error' . $e->getMessage());
}
?>
catch (Exception $e) {
    header('location:consultas.php?respuesta=Error' . $e->getMessage());
}
