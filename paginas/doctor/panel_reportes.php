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

</head>

<body>
    <div id="menu">
    </div>
    <section id="area_trabajo">

        <h2 style="font-weight: bold">Pacientes</h2>
        <hr />
        <br />

        <div class="panel">
            <div class="panel_titulo">
                <h5>Búsqueda de <?php
                        // Consulta a la base de datos para pacientes aptos
                        include('../../configDBsqlserver.php'); // Conexión a la base de datos SQL Server
                        ?> </h5>
            </div>

            <div class="panel_body">
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="apto-tab" data-bs-toggle="tab" href="#apto" role="tab" aria-controls="apto" aria-selected="false">Apto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="no-apto-tab" data-bs-toggle="tab" href="#no-apto" role="tab" aria-controls="no-apto" aria-selected="false">No Apto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="condicionado-tab" data-bs-toggle="tab" href="#condicionado" role="tab" aria-controls="condicionado" aria-selected="false">Condicionado</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="muy-condicionado-tab" data-bs-toggle="tab" href="#muy-condicionado" role="tab" aria-controls="muy-condicionado" aria-selected="true">Muy Condicionado</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabsContent">
                    <div class="tab-pane fade show active" id="apto" role="tabpanel" aria-labelledby="apto-tab">
                        <?php

                        $consulta_apto = "SELECT * FROM gestion_citas.pacientes WHERE aptos = 'apto' ORDER BY fecha DESC";

                        $resultado_apto = $conn2->query($consulta_apto);

                        if ($resultado_apto === false) {
                            die(print_r($conn2->errorInfo(), true));
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
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fila_apto = $resultado_apto->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $fila_apto["id"] ?></th>
                                        <td><?php echo $fila_apto["clave"] ?></td>
                                        <td><?php echo $fila_apto["hora"] ?></td>
                                        <td><?php echo $fila_apto["nombre"] ?></td>
                                        <td><?php echo $fila_apto["fecha"] ?></td>
                                        <td><?php echo $fila_apto["edad"] ?></td>
                                       
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tabpane fade hidden" id="no-apto" role="tabpanel" aria-labelledby="no-apto-tab">
                        <?php
                        // Consulta a la base de datos para pacientes no aptos
                        $consulta_no_apto = "SELECT * FROM gestion_citas.pacientes WHERE aptos = 'no-apto' ORDER BY fecha DESC";

                        $resultado_no_apto = $conn2->query($consulta_no_apto);

                        if ($resultado_no_apto === false) {
                            die(print_r($conn2->errorInfo(), true));
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
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fila_no_apto = $resultado_no_apto->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $fila_no_apto["id"] ?></th>
                                        <td><?php echo $fila_no_apto["clave"] ?></td>
                                        <td><?php echo $fila_no_apto["hora"] ?></td>
                                        <td><?php echo $fila_no_apto["nombre"] ?></td>
                                        <td><?php echo $fila_no_apto["fecha"] ?></td>
                                        <td><?php echo $fila_no_apto["edad"] ?></td>
                                       
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tabpane fade hidden" id="condicionado" role="tabpanel" aria-labelledby="condicionado-tab">
                        <?php
                        // Consulta a la base de datos para pacientes condicionados
                        $consulta_condicionado = "SELECT * FROM gestion_citas.pacientes WHERE aptos = 'condicion' ORDER BY fecha DESC";

                        $resultado_condicionado = $conn2->query($consulta_condicionado);

                        if ($resultado_condicionado === false) {
                            die(print_r($conn2->errorInfo(), true));
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
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fila_condicionado = $resultado_condicionado->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $fila_condicionado["id"] ?></th>
                                        <td><?php echo $fila_condicionado["clave"] ?></td>
                                        <td><?php echo $fila_condicionado["hora"] ?></td>
                                        <td><?php echo $fila_condicionado["nombre"] ?></td>
                                        <td><?php echo $fila_condicionado["fecha"] ?></td>
                                        <td><?php echo $fila_condicionado["edad"] ?></td>
                                       
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tabpane fade hidden" id="muy-condicionado" role="tabpanel" aria-labelledby="muy-condicionado-tab">
                        <?php
                        // Consulta a la base de datos para pacientes muy condicionados
                        $consulta_muy_condicionado = "SELECT * FROM gestion_citas.pacientes WHERE aptos = 'mcondicion' ORDER BY fecha DESC";

                        $resultado_muy_condicionado = $conn2->query($consulta_muy_condicionado);

                        if ($resultado_muy_condicionado === false) {
                            die(print_r($conn2->errorInfo(), true));
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
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($fila_muy_condicionado = $resultado_muy_condicionado->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $fila_muy_condicionado["id"] ?></th>
                                        <td><?php echo $fila_muy_condicionado["clave"] ?></td>
                                        <td><?php echo $fila_muy_condicionado["hora"] ?></td>
                                        <td><?php echo $fila_muy_condicionado["nombre"] ?></td>
                                        <td><?php echo $fila_muy_condicionado["fecha"] ?></td>
                                        <td><?php echo $fila_muy_condicionado["edad"] ?></td>
                                        
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
        <br /><br />
    </section>
    <div id="footer_nav"></div>

<style>
    .nav-tabs .nav-item {
  margin-bottom: 0;
}
.hidden {
  display: none;
}


</style>

    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>

</html>