<?php
if (isset($_GET['respuesta'])) {
    echo "<div class='card-panel red darken-1'>" . $_GET['respuesta'] . "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel Control Citas</title>
    <link rel="stylesheet" href="./css/tablas.css">
    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../estilos/panel_control.css" />

</head>

<body>
    <div id="menu"></div>

    <section id="area_trabajo">
        <h2 style="font-weight: bold">Dashboard</h2>
        <hr />
        <br />

        <div class="panel">
            <div class="panel_titulo">
                <h5>Ver consulta</h5>
            </div>

            <div class="panel_body">
                <h1><?php
                    // consulta a la db
                    include('../../configDBsqlserver.php'); // Conexión a la db
                    $id = $_GET['id'];
                    $consulta2 = "SELECT * FROM gestion_citas.pacientes WHERE id = :id";

                    $stmt = $conn2->prepare($consulta2);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute(); ?>
                </h1>
                <br>
                <hr>
                </style>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="3" scope="col">#</th>
                            <th colspan="3" scope="col">clave</th>
                            <th colspan="3" scope="col">hora</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">nombre</th>
                            <th colspan="3" scope="col">Fecha</th>
                            <th colspan="3" scope="col">Edad</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">Peso</th>
                            <th colspan="3" scope="col">Sexo</th>
                            <th colspan="3" scope="col">Talla</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">TensArt</th>
                            <th colspan="3" scope="col">edoCivil</th>
                            <th colspan="3" scope="col">frCard</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">frResp</th>
                            <th colspan="3" scope="col">imc</th>
                            <th colspan="3" scope="col">temp</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">ahf</th>
                            <th colspan="3" scope="col">apnp</th>
                            <th colspan="3" scope="col">app</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">pActual</th>
                            <th colspan="3" scope="col">eFisica</th>
                            <th colspan="3" scope="col">fecha de Nacimiento</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">puestoS</th>
                            <th colspan="3" scope="col">Escolaridad</th>
                            <th colspan="3" scope="col">lugar de Origen</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">Analisis Covid</th>
                            <th colspan="3" scope="col">indicaciones</th>
                            <th colspan="3" scope="col">Visitar UFM</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">Observaciones</th>
                            <th colspan="3" scope="col">Cirugias</th>
                            <th colspan="3" scope="col">Traumatismos</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">Fracturas</th>
                            <th colspan="3" scope="col">Luxaciones</th>
                            <th colspan="3" scope="col">Alergias</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">Agudeza Visual</th>
                            <th colspan="3" scope="col">Licencia Indica Uso de Lentes</th>
                            <th colspan="3" scope="col">Riesgo para la Salud</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">envioOpto</th>
                            <th colspan="3" scope="col">¿Usa Lentes Graduados?</th>
                            <th colspan="3" scope="col">Perimetro Abdominal</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">Examenes de Laboratorio</th>
                            <th colspan="3" scope="col">Tipo de Sangre</th>
                            <th colspan="3" scope="col">Glucosa Capilar</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">I.R.A.S</th>
                            <th colspan="3" scope="col">Porcentaje de Oxigeno</th>
                            <th colspan="3" scope="col">prueba Aplicada</th>
                        </tr>
                        <tr>
                            <th colspan="3" scope="col">Fecha Aplicacion</th>
                            <th colspan="3" scope="col">Hora Aplicacion</th>
                            <th colspan="3" scope="col">Resultado</th>
                        </tr>
                        <!-- Resto de las columnas -->

                        <!-- Salto de línea -->
                        <tr>
                            <th colspan="3" scope="col">Diagnostico</th>
                            <th colspan="3" scope="col">Indicaciones Finales</th>
                            <th colspan="3" scope="col">Acciones</th>
                        </tr>
                    </thead>

                    
                    <tbody>
                        <?php
                        while ($fila2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $fila2["id"] ?></th>
                                <td><?php echo $fila2["clave"] ?></td>
                                <td><?php echo $fila2["hora"] ?></td>
                                <td><?php echo $fila2["nombre"] ?></td>
                                <td><?php echo $fila2["fecha"] ?></td>
                                <td><?php echo $fila2["edad"] ?></td>
                                <td><?php echo $fila2["peso"] ?></td>
                                <td><?php echo $fila2["sexo"] ?></td>
                                <td><?php echo $fila2["talla"] ?></td>
                                <td><?php echo $fila2["tensArt"] ?></td>
                                <td><?php echo $fila2["edoCivil"] ?></td>
                                <td><?php echo $fila2["frCard"] ?></td>
                                <td><?php echo $fila2["frResp"] ?></td>
                                <td><?php echo $fila2["imc"] ?></td>
                                <td><?php echo $fila2["temp"] ?></td>
                                <td><?php echo $fila2["ahf"] ?></td>
                                <td><?php echo $fila2["apnp"] ?></td>
                                <td><?php echo $fila2["app"] ?></td>
                                <td><?php echo $fila2["pActual"] ?></td>
                                <td><?php echo $fila2["eFisica"] ?></td>
                                <td><?php echo $fila2["fechaN"] ?></td>
                                <td><?php echo $fila2["puestoS"] ?></td>
                                <td><?php echo $fila2["escolaridad"] ?></td>
                                <td><?php echo $fila2["lugarOrigen"] ?></td>
                                <td><?php echo $fila2["analisisCovid"] ?></td>
                                <td><?php echo $fila2["indicaciones"] ?></td>
                                <td><?php echo $fila2["visitarUFM"] ?></td>
                                <td><?php echo $fila2["observaciones"] ?></td>
                                <td><?php echo $fila2["cirugias"] ?></td>
                                <td><?php echo $fila2["traumatismos"] ?></td>
                                <td><?php echo $fila2["fracturas"] ?></td>
                                <td><?php echo $fila2["luxaciones"] ?></td>
                                <td><?php echo $fila2["alergias"] ?></td>
                                <td><?php echo $fila2["agudezaVisual"] ?></td>
                                <td><?php echo $fila2["licenciaLentes"] ?></td>
                                <td><?php echo $fila2["riesgoSalub"] ?></td>
                                <td><?php echo $fila2["envioOpto"] ?></td>
                                <td><?php echo $fila2["lentGraduadios"] ?></td>
                                <td><?php echo $fila2["perAbdominal"] ?></td>
                                <td><?php echo $fila2["examLab"] ?></td>
                                <td><?php echo $fila2["tipoSangre"] ?></td>
                                <td><?php echo $fila2["glucosaCapilar"] ?></td>
                                <td><?php echo $fila2["iras"] ?></td>
                                <td><?php echo $fila2["porcentajeOxigeno"] ?></td>
                                <td><?php echo $fila2["pruevaAplicada"] ?></td>
                                <td><?php echo $fila2["FechaAplicacion"] ?></td>
                                <td><?php echo $fila2["horaAplicacion"] ?></td>
                                <td><?php echo $fila2["resultado"] ?></td>
                                <td><?php echo $fila2["diagnostico"] ?></td>
                                <td><?php echo $fila2["indicacionesFinales"] ?></td>
                                <!--Acciones-->
                                <td>
                                    <a class='btn btn-secondary' href='Consultas.php?id=<?php echo $fila2["id"]; ?>'>Volver</a>
                                </td>
                                <td>
                                    <a class='btn btn-secondary' href='edicionConsulta.php?id=<?php echo $fila2["id"]; ?>'>Editar</a>
                                </td>
                                <td>
                                    <a class='btn btn-secondary' href='eliminarConsulta.php?id=<?php echo $fila2["id"]; ?>'>Eliminar</a>
                                </td>
                                <td>
                                    <button class="btn btn-secondary" onClick="window.location.reload();" title="Recargar página">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
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

    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>

</html>