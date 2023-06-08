<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Pacientes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Consulta de Pacientes</h1>

    <form method="GET" action="">
    <label for="clave">Buscar por clave:</label>
        <input type="text" id="clave" name="clave" onchange="this.form.submit()">

        <button type="button" id="clave2" name="clave2" >Mostrar todo</button>
    </form>

    <?php
    $serverName = "LAPTOP-GOI9E2B5\SQLEXPRESS";
    $database = "BD Empleados";
    $username = "admin";
    $password = "admin123456789";

    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT Id, Clave, Nombre, Paterno, Materno, FechaAlta, IdDepto, Depto FROM dbo.BD"; /* Reemplaza "dbo.BD" con el nombre de tu tabla en la base de datos */
        if (isset($_GET['clave'])) {
            $clave = $_GET['clave'];
            $query .= " WHERE Clave = '$clave'";
        }
        if (isset($_GET['clave2'])) {
            $clave2 = $_GET['clave2'];
            $query .= " ";
        }
        $stmt = $conn->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Id</th>";
            echo "<th>Clave</th>";
            echo "<th>Nombre</th>";
            echo "<th>Paterno</th>";
            echo "<th>Materno</th>";
            echo "<th>FechaAlta</th>";
            echo "<th>IdDepto</th>";
            echo "<th>Depto</th>";
            echo "</tr>";

            foreach ($rows as $row) {
                echo "<tr>";
                echo "<td>".$row['Id']."</td>";
                echo "<td>".$row['Clave']."</td>";
                echo "<td>".$row['Nombre']."</td>";
                echo "<td>".$row['Paterno']."</td>";
                echo "<td>".$row['Materno']."</td>";
                echo "<td>".$row['FechaAlta']."</td>";
                echo "<td>".$row['IdDepto']."</td>";
                echo "<td>".$row['Depto']."</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }
    } catch (PDOException $e) {
        echo "Error al conectar a la base de datos SQL Server: " . $e->getMessage();
    }
    ?>

</body>
</html>
