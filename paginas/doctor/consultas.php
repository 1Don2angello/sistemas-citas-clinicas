<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>

    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../estilos/panel_control.css" />
    <script src="../../javascript/panel_dashboard_doctor.js"></script>
</head>

<body>
    <div id="menu"></div>
    <section id="area_trabajo">

        <h2 style="font-weight: bold">Dashboard</h2>
        <hr />
        <br />

        <div class="panel">
            <div class="panel_titulo">
                <h5>Consultorio</h5>
            </div>

            <div class="panel_body">
                <h1></h1>
                <button class="btn btn-secondary" onClick="window.location.reload();" title="Recargar página">
                    <i class="fa fa-sync-alt"></i>
                </button>

                <a href="crearConsulta.php" class="btn btn-secondary"">Crear Consulta </a>
    <?php
    if (isset($_GET['respuesta'])) {
        echo "<div class='card-panel red darken-1'>" . $_GET['respuesta'] . "</div>";
    }
    ?>
    <table class=" table">
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
                        // Consulta a la base de datos
                        include('conexion.php'); // Conexión a la base de datos SQL Server

                        $consulta2 = "select * from gestion_citas.pacientes;";

                        $resultado2 = $conn->query($consulta2);

                        if ($resultado2 === false) {
                            die(print_r($conn->errorInfo(), true));
                        }

                        while ($fila2 = $resultado2->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $fila2["id"] ?></th>
                                <td><?php echo $fila2["clave"] ?></td>
                                <td><?php echo $fila2["hora"] ?></td>
                                <td><?php echo $fila2["nombre"] ?></td>
                                <td><?php echo $fila2["fecha"] ?></td>
                                <td><?php echo $fila2["edad"] ?></td>
                                <!-- Acciones -->
                                <td>
                                    <a class='btn btn-secondary' href='verConsulta.php?id=<?php echo $fila2["id"]; ?>'>Ver</a>
                                    <a class='btn btn-primary' href='altas.php?id=<?php echo $fila2["id"]; ?>'>Imprimir</a>
                                    <a class='btn btn-secondary' href='edicionConsulta.php?id=<?php echo $fila2["id"]; ?>'>Editar</a>
                                    <a class='btn btn-primary' href='eliminarConsulta.php?id=<?php echo $fila2["id"]; ?>'>Eliminar</a>

                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                    </table>
            </div>
        </div>
        </div>
        <br /><br />
    </section>
    <div id="footer_nav"></div>
</body>

</html>