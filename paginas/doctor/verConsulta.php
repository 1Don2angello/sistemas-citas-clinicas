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
                <h5>Operaciones Calendario</h5>
            </div>

            <div class="panel_body">
            </div>
        </div>
        </div>
        <br /><br />

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">clave</th>
                    <th scope="col">hora</th>
                    <th scope="col">nombre</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Talla</th>
                    <th scope="col">TensArt</th>
                    <th scope="col">edoCivil</th>
                    <th scope="col">frCard</th>
                    <th scope="col">frResp</th>
                    <th scope="col">imc</th>
                    <th scope="col">temp</th>
                    <th scope="col">ahf</th>
                    <th scope="col">apnp</th>
                    <th scope="col">app</th>
                    <th scope="col">pActual</th>
                    <th scope="col">eFisica</th>
                    <th scope="col">fecha de Nacimiento</th>
                    <th scope="col">puestoS</th>
                    <th scope="col">Escolaridad</th>
                    <th scope="col">lugar de Origen</th>
                    <th scope="col">Analisis Covid</th>
                    <th scope="col">indicaciones</th>
                    <th scope="col">Visitar UFM</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Cirugias</th>
                    <th scope="col">Traumatismos</th>
                    <th scope="col">Fracturas</th>
                    <th scope="col">Luxaciones</th>
                    <th scope="col">Alergias</th>
                    <th scope="col">Agudeza Visual</th>
                    <th scope="col">Licencia Indica Uso de Lentes</th>
                    <th scope="col">Riesgo para la Salub</th>
                    <th scope="col">envioOpto</th>
                    <th scope="col">¿Usa Lentes Graduadios?</th>
                    <th scope="col">Perimetro Abdominal</th>
                    <th scope="col">Examenes de Laboratorio</th>
                    <th scope="col">Tipo de Sangre</th>
                    <th scope="col">Glucosa Capilar</th>
                    <th scope="col">I.R.A.S</th>
                    <th scope="col">Porcentaje de3 Oxigeno</th>
                    <th scope="col">pruevaAplicada</th>
                    <th scope="col">FechaAplicacion</th>
                    <th scope="col">horaAplicacion</th>
                    <th scope="col">resultado</th>
                    <th scope="col">diagnostico</th>
                    <th scope="col">indicacionesFinales</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // consulta a la db
                include('conexion.php'); // Conexión a la db
                $id = $_GET['id'];
                $consulta2 = "SELECT * FROM gestion_citas.pacientes WHERE id = :id";

                $stmt = $conn->prepare($consulta2);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

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
                        <a class='btn btn-secondary' href='Consultas.php?id=<?php echo $fila2["id"]; ?>'>Volver</a>
                        <a class='btn btn-secondary' href='edicionConsulta.php?id=<?php echo $fila2["id"]; ?>'>Editar</a>
                        <a class='btn btn-secondary' href='eliminarConsulta.php?id=" . $registro->id . "'>Eliminar</a>
                        <button class="btn btn-secondary" onClick="window.location.reload();" title="Recargar página">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </section>
    <div id="footer_nav"></div>
</body>

</html>