<?php
include('../../configDBsqlserver.php'); // Conexión a la base de datos SQL Server 
//
//
try {
    if (isset($_POST['procesoHistorial'])) {
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
        $sqlGuardarHistorial = "INSERT INTO gestion_citas.historial(clave, nombre, sexo, edad, altura, peso, analisisCovid, sintomas, diagnostico, tratamiento, instrucciones) 
                VALUES(:clave,:nombre,:sexo,:edad,:altura,:peso,:analisisCovid,:sintomas,:diagnostico,:tratamiento,:instrucciones);";
        
        $stmt = $conn2->prepare($sqlGuardarHistorial);
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
    header('location:historial.php?respuesta=Error' . $e->getMessage());
}
