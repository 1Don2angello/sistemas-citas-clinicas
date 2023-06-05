<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consultas</title>
    </head>
    <body>
        <h1></h1>
        <a href="crearConsulta.php" class="btn">Crear Consulta </a>
        <?php
            if (isset($_GET['respuesta'])) {
                echo "<div class='card-panel red darken-1'>" . $_GET['respuesta'] . "</div>";
            }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">clave</th>
                    <th scope="col">hora</th>
                    <th scope="col">nombre</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Edad</th> 
                    <!-- Acciones -->
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //consulta a la db
                include('conexion.php'); //Conexión a la db
                $consulta2 = "SELECT * FROM pacientes";
                
                $resultado2 = mysqli_query($conn, $consulta2);
                
                if($resultado2 === false) {
                    die( print_r( mysqli_connect_errno(), true));
                }
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $fila2["id"] ?></th>
                        <td><?php echo $fila2["clave"] ?></td>
                        <td><?php echo $fila2["hora"] ?></td>
                        <td><?php echo $fila2["nombre"] ?></td>
                        <td><?php echo $fila2["fecha"] ?></td>
                        <td><?php echo $fila2["edad"] ?></td>
                        <!--Acciones-->
                        <td>
                            <a class='btn' href='verConsulta.php?id=<?php echo $fila2["id"]; ?>'>Ver</a>
                            <a class='btn' href='notificarConsulta.php?id=<?php echo $fila2["id"]; ?>'>Notificar</a>
                            <a class='btn' href='edicionConsulta.php?id=<?php echo $fila2["id"]; ?>'>Editar</a>
                            <a class='btn' href='eliminarConsulta.php?id=<?php echo $fila2["id"]; ?>'>Eliminar</a>
                        </td>
                    </tr>
                    <?php  
                } ?>
            </tbody>
        </table>
    </body>
</html> 