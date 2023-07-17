<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../estilos/panel_control.css" />
    <link rel="stylesheet" href="./css/paginacion.css">
</head>

<body>
    <div id="menu"></div>
    <section id="area_trabajo">
        <h2 style="font-weight: bold">Historial</h2>
        <hr />
        <br />
        <div class="panel">
            <div class="panel_titulo">
                <h5>Consultorio</h5>
            </div>
            <div class="panel_body">
                <h1>
                    <?php
                    include('../../configDBsqlserver.php'); // Conexión a la base de datos SQL Server
                    // Variables de búsqueda y paginación
                    $clave = '';
                    $nombre = '';
                    $registrosPorPagina = 7; // Número de registros a mostrar por página
                    $paginaActual = 1; // Página actual (por defecto es la primera página)
                    // Verificar si se realizó una búsqueda
                    if (isset($_GET['claveBusqueda']) && isset($_GET['nombreBusqueda'])) {
                        // Recuperar los valores de búsqueda
                        $clave = $_GET['claveBusqueda'];
                        $nombre = $_GET['nombreBusqueda'];
                    }
                    // Verificar si se especificó una página
                    if (isset($_GET['pagina'])) {
                        $paginaActual = $_GET['pagina'];
                    }
                    // Calcular el número de registro inicial para la consulta
                    $registroInicial = ($paginaActual - 1) * $registrosPorPagina;
                    // Consulta SQL con criterios de búsqueda y paginación
                    $consulta5 = "SELECT * FROM gestion_citas.historial WHERE clave LIKE '%$clave%' AND nombre LIKE '%$nombre%' ORDER BY id OFFSET $registroInicial ROWS FETCH NEXT $registrosPorPagina ROWS ONLY;";
                    $resultado5 = $conn2->query($consulta5);
                    if ($resultado5 === false) {
                        die(print_r($conn2->errorInfo(), true));
                    }
                    ?>
                </h1>

                <section>
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="">
                        <div class="search-form">
                            <button class="btn btn-success" title="Recargar página">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                            <a href="crearHistorial.php" class="btn btn-primary">Crear Historial</a>
                            <div class="form-group">
                                <label for="claveBusqueda">Clave:</label>
                                <input type="text" name="claveBusqueda" id="claveBusqueda" class="form-control" value="<?php echo $clave; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nombreBusqueda">Nombre:</label>
                                <input type="text" name="nombreBusqueda" id="nombreBusqueda" class="form-control" value="<?php echo $nombre; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>

                    <!-- Tabla de resultados -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Sexo</th>
                                <th scope="col">Fecha</th>
                                <!-- Acciones -->
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fila5 = $resultado5->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $fila5["id"] ?></th>
                                    <td><?php echo $fila5["clave"] ?></td>
                                    <td><?php echo $fila5["nombre"] ?></td>
                                    <td><?php echo $fila5["sexo"] ?></td>
                                    <td><?php echo $fila5["fecha"] ?></td>
                                    <!-- Acciones -->
                                    <td>
                                        <a class='btn btn-primary' href='verConsultaHistorial.php?id=<?php echo $fila5["id"]; ?>'>Ver</a>
                                        <a class='btn btn-success' href='edicionHistorial.php?id=<?php echo $fila5["id"]; ?>'>Editar</a>
                                        <a class='btn btn-danger' href='eliminarHistorial.php?id=<?php echo $fila5["id"]; ?>'>Eliminar</a>
                                    </td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="pagination">
                        <?php
                        // Consulta para contar el total de registros sin la limitación de paginación
                        $consultaTotal = "SELECT COUNT(*) as total FROM gestion_citas.historial WHERE clave LIKE '%$clave%' AND nombre LIKE '%$nombre%';";
                        $resultadoTotal = $conn2->query($consultaTotal);
                        $filaTotal = $resultadoTotal->fetch(PDO::FETCH_ASSOC);
                        $totalRegistros = $filaTotal['total'];

                        // Calcular el número total de páginas
                        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                        // Generar enlaces de paginación
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            $activo = ($i == $paginaActual) ? 'active' : '';
                            echo "<a class='page-link $activo' href='historial.php?claveBusqueda=$clave&nombreBusqueda=$nombre&pagina=$i'>$i</a>";
                        }
                        ?>
                    </div>
                </section>
            </div>
    </section>
    <div id="footer_nav"></div>
    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>

</html>