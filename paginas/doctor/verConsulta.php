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
    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css">

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

                <table class="table table-bordered">
                    <tbody>
                        <?php
                        while ($fila2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?><div>
                                <a class='btn btn-secondary' href='Consultas.php?id=<?php echo $fila2["id"]; ?>'>Volver</a>
                                <a class='btn btn-secondary' href='edicionConsulta.php?id=<?php echo $fila2["id"]; ?>'>Editar</a>
                                <a class='btn btn-secondary' href='eliminarConsulta.php?id=<?php echo $fila2["id"]; ?>'>Eliminar</a>
                                <button class="btn btn-secondary" onClick="window.location.reload();" title="Recargar página">
                                    <i class="fa fa-sync-alt"></i>
                                </button>
                            </div>
                            <thead>

                                <tr>
                                    <th colspan="1" scope="col">#</th>
                                    <td style="width: auto;"><?php echo $fila2["id"] ?></td>
                                    <th colspan="1" scope="col">clave</th>
                                    <td style="width: auto;"><?php echo $fila2["clave"] ?></td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">nombre</th>
                                    <td colspan="4"><?php echo $fila2["nombre"] ?></td>
                                    <th colspan="1" scope="col">Fecha</th>
                                    <td colspan="4" style="width: auto;"><?php echo $fila2["fecha"] ?></td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Edad</th>
                                    <td style="width: auto;"><?php echo $fila2["edad"] ?></td>
                                    <th colspan="1" scope="col">Sexo</th>
                                    <td style="width: auto;"><?php echo $fila2["sexo"] ?></td>
                                    <th colspan="1" scope="col">TensArt</th>
                                    <td style="width: auto;"><?php echo $fila2["tensArt"] ?></td>
                                    <th colspan="1" scope="col">frCard</th>
                                    <td style="width: auto;"><?php echo $fila2["frCard"] ?></td>
                                    <th colspan="1" scope="col">imc</th>
                                    <td style="width: auto;"><?php echo $fila2["imc"] ?></td>
                                    <th colspan="1" scope="col">hora</th>
                                    
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Peso</th>
                                    <td style="width: auto;"><?php echo $fila2["peso"] ?></td>
                                    <th colspan="1" scope="col">Talla</th>
                                    <td style="width: auto;"><?php echo $fila2["talla"] ?></td>
                                    <th colspan="1" scope="col">edoCivil</th>
                                    <td style="width: auto;"><?php echo $fila2["edoCivil"] ?></td>
                                    <th colspan="1" scope="col">frResp</th>
                                    <td style="width: auto;"><?php echo $fila2["frResp"] ?></td>
                                    <th colspan="1" scope="col">temp</th>
                                    <td style="width: auto;"><?php echo $fila2["temp"] ?></td>
                                    <td style="width: auto;"><?php echo $fila2["hora"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->
                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">ahf</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["ahf"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">apnp</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["apnp"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">app</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["app"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->
                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">P. Actual</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["pActual"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">eFisica</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["eFisica"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">fecha de Nacimiento</th>
                                    <td style="width: auto;"><?php echo $fila2["fechaN"] ?></td>
                                    <th colspan="1" scope="col">Escolaridad</th>
                                    <td style="width: auto;"><?php echo $fila2["escolaridad"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Puesto Solicitado</th>
                                    <td style="width: auto;"><?php echo $fila2["puestoS"] ?></td>

                                    <th colspan="1" scope="col">lugar de Origen</th>
                                    <td style="width: auto;"><?php echo $fila2["lugarOrigen"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->

                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">Analisis Covid</th>
                                    <td style="width: auto;"><?php echo $fila2["analisisCovid"] ?></td>
                                    <th colspan="1" scope="col">indicaciones</th>
                                    <td style="width: auto;"><?php echo $fila2["indicaciones"] ?></td>
                                    <th colspan="1" scope="col">Visitar UFM</th>
                                    <td style="width: auto;"><?php echo $fila2["visitarUFM"] ?></td>
                                    <th colspan="1" scope="col">Observaciones</th>
                                    <td style="width: auto;"><?php echo $fila2["observaciones"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Cirugias</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["cirugias"] ?></td>
                                </tr>

                                <tr>
                                    <th colspan="1" scope="col">Traumatismos</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["traumatismos"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->

                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">Fracturas</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["fracturas"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Luxaciones</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["luxaciones"] ?></td>
                                </tr>
                                <tr> </tr>
                                <tr>
                                    <th colspan="1" scope="col">Alergias</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["alergias"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Agudeza Visual</th>
                                    <td style="width: auto;"><?php echo $fila2["agudezaVisual"] ?></td>
                                    <th colspan="1" scope="col">envioOpto</th>
                                    <td style="width: auto;"><?php echo $fila2["envioOpto"] ?></td>
                                    <th colspan="1" scope="col">Examenes de Laboratorio</th>
                                    <td style="width: auto;"><?php echo $fila2["examLab"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->
                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">Licencia Indica Uso de Lentes</th>
                                    <td style="width: auto;"><?php echo $fila2["licenciaLentes"] ?></td>
                                    <th colspan="1" scope="col">¿Usa Lentes Graduados?</th>
                                    <td style="width: auto;"><?php echo $fila2["lentGraduadios"] ?></td>
                                    <th colspan="1" scope="col">Tipo de Sangre</th>
                                    <td style="width: auto;"><?php echo $fila2["tipoSangre"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Riesgo para la Salud</th>
                                    <td style="width: auto;"><?php echo $fila2["riesgoSalub"] ?></td>
                                    <th colspan="1" scope="col">Perimetro Abdominal</th>
                                    <td style="width: auto;"><?php echo $fila2["perAbdominal"] ?></td>
                                    <th colspan="1" scope="col">Glucosa Capilar</th>
                                    <td style="width: auto;"><?php echo $fila2["glucosaCapilar"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->

                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">I.R.A.S</th>
                                    <td style="width: auto;"><?php echo $fila2["iras"] ?></td>
                                    <th colspan="1" scope="col">Porcentaje de Oxigeno</th>
                                    <td style="width: auto;"><?php echo $fila2["porcentajeOxigeno"] ?></td>
                                    <th colspan="1" scope="col">prueba Aplicada</th>
                                    <td style="width: auto;"><?php echo $fila2["pruevaAplicada"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fecha Aplicacion</th>
                                    <td style="width: auto;"><?php echo $fila2["FechaAplicacion"] ?></td>
                                    <th colspan="1" scope="col">Hora Aplicacion</th>
                                    <td style="width: auto;"><?php echo $fila2["horaAplicacion"] ?></td>
                                    <th colspan="1" scope="col">Resultado</th>
                                    <td style="width: auto;"><?php echo $fila2["resultado"] ?></td>
                                </tr>
                                <!-- Resto de las columnas -->

                                <!-- Salto de línea -->
                                <tr>
                                    <th colspan="1" scope="col">Diagnostico</th>
                                    <td colspan="10" style="width: auto;"><?php echo $fila2["diagnostico"] ?></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Indicaciones Finales</th>
                                    <td colspan="10" style="width: auto"><?php echo $fila2["indicacionesFinales"] ?></td>
                                </tr>
                            </thead>



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