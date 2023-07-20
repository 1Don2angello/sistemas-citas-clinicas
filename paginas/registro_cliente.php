<?php
//agregamos todas las referencias necesarias
include('../configDBsqlserver.php');
try {
    if (isset($_POST['registro'])) {

        $clientes_nombre = $_POST["txt_nombre"];
        $clientes_apellido_p = $_POST["txt_apellido_p"];
        $clientes_apellido_m = $_POST["txt_apellido_m"];
        $clientes_telefono = $_POST["txt_telefono"];
        $clientes_correo = $_POST["txt_correo"];
        $clientes_direccion = $_POST["txt_direccion"];
        $clientes_sexo = $_POST["select_sexo"];
        $clientes_edad = $_POST["txt_edad"];

        // Aquí puedes realizar la validación de los datos ingresados y guardarlos en la base de datos.
        // Por ejemplo, puedes usar una clase de conexión a la base de datos y realizar el INSERT en la tabla de clientes.

        // Ejemplo de inserción en la base de datos utilizando PDO
        $query = "INSERT INTO gestion_citas.cat_clientes (clientes_nombre, clientes_apellido_p, clientes_apellido_m, clientes_telefono, clientes_correo, clientes_direccion, clientes_sexo, clientes_edad) " .
            "VALUES (:clientes_nombre, :clientes_apellido_p, :clientes_apellido_m, :clientes_telefono, :clientes_correo, :clientes_direccion, :clientes_sexo, :clientes_edad)";

        $stmt = $conn2->prepare($query);
        $stmt->bindParam(':clientes_nombre', $clientes_nombre);
        $stmt->bindParam(':clientes_apellido_p', $clientes_apellido_p);
        $stmt->bindParam(':clientes_apellido_m', $clientes_apellido_m);
        $stmt->bindParam(':clientes_telefono', $clientes_telefono);
        $stmt->bindParam(':clientes_correo', $clientes_correo);
        $stmt->bindParam(':clientes_direccion', $clientes_direccion);
        $stmt->bindParam(':clientes_sexo', $clientes_sexo);
        $stmt->bindParam(':clientes_edad', $clientes_edad);
        // Imprimir la consulta SQL
        echo "Consulta SQL: " . $query;
       

        if ($stmt->execute()) {
            echo "<p>Cliente registrado correctamente.</p>";
            header('Location:../index.html'); // Redireccionar al archivo index.html después de registrar el cliente.
            exit; // Terminar la ejecución del script para evitar problemas con el encabezado de redirección.
        } else {
            echo "<p>Error al registrar el cliente.</p>";
        }
    }
} catch (Exception $e) {
    header('location:registrarse.php?respuesta=Error' . $e->getMessage());
    exit; // Terminar la ejecución del script después de la redirección.
}
