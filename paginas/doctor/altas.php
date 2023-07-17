<?php
if (isset($_GET['respuesta'])) {
    echo "<div class='card-panel red darken-1'>" . $_GET['respuesta'] . "</div>";
}
?>
<html>

<head>
    <!-- <base href="https://demos.telerik.com/kendo-ui/pdf-export/page-layout">
    <style>html { font-size: 14px; font-family: Arial, Helvetica, sans-serif; } -->
    <title></title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/pdf.css">

    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../estilos/panel_control.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.common.min.css" />
    <!--      <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.black.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.black.mobile.min.css" /> -->

    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/jquery.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/jszip.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/kendo.all.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">

    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/pdf.css">




    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <!--  <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
 -->
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="../../estilos/panel_control.css" />
</head>

<body>
    <div id="menu"></div>

    <br>
    <div id="example">
        <div class="page-container hidden-on-narrow">
            <section id="area_trabajo">
                <div class="box wide hidden-on-narrow">
                    <div class="box-col">
                        <h1><?php
                            // consulta a la db
                            include('../../configDBsqlserver.php'); // Conexión a la db
                            $id = $_GET['id'];
                            $consulta2 = "SELECT * FROM gestion_citas.pacientes WHERE id = :id";

                            $stmt = $conn2->prepare($consulta2);
                            $stmt->bindParam(':id', $id);
                            $stmt->execute(); ?>
                        </h1>
                        <h4>Select Page size</h4>
                        <select id="paper" style="width: 100px;">
                            <option value="size-a4" selected>A4</option>
                            <option value="size-letter">Letter</option>
                            <option value="size-executive">Executive</option>
                        </select>
                    </div>
                    <div class="box-col">
                        <h4>Get PDF</h4>
                        <button class="export-pdf k-button btn btn-danger" onclick="getPDF('.pdf-page')">Export</button>
                    </div>
                </div>
                <div class="pdf-page size-a4">
                    <div class="margen">
                        <div class="pdf-header">

                            <img src="./css/HEADER.png" class="imagenes" />
                        </div>
                        <div class="pdf-footer">
                            <img src="./css/FOOTER con firma.png" class="imagenes2" />
                        </div>
                        <div class="pdf-body">
                            <div  style="width: 100%; text-align: center;">
                                <table class="tabla" style="width: 100%; max-width: 8.5in; ">
                                    <tbody>
                                        <?php
                                        while ($fila2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <thead>

                                                <tr>

                                                    <th colspan="1" scope="col">clave</th>
                                                    <td style="width: auto;"><?php echo $fila2["clave"] ?></td>
                                                    <th colspan="1" scope="col">nombre</th>
                                                    <td colspan="4" style="width: auto;"><?php echo $fila2["nombre"] ?></td>
                                                    <th colspan="1" scope="col">Fecha</th>
                                                    <td colspan="3" style="width: auto;"><?php echo $fila2["fecha"] ?></td>

                                                </tr>
                                                <tr>



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
                                                <tr style="height: 10px;">

                                                </tr>
                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="1" scope="col">ahf</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["ahf"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">apnp</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["apnp"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">app</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["app"] ?></td>
                                                </tr>
                                                <!-- Resto de las columnas -->
                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="1" scope="col">P. Actual</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["pActual"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">eFisica</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["eFisica"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" scope="col">fecha de Nacimiento</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["fechaN"] ?></td>
                                                    <th colspan="3" scope="col">Escolaridad</th>
                                                    <td colspan="3" style="width: auto;"><?php echo $fila2["escolaridad"] ?></td>

                                                </tr>
                                                <tr>
                                                    <th colspan="3" scope="col">Puesto Solicitado</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["puestoS"] ?></td>
                                                    <th colspan="3" scope="col">lugar de Origen</th>
                                                    <td colspan="3" style="width: auto;"><?php echo $fila2["lugarOrigen"] ?></td>
                                                </tr>

                                                <!-- Resto de las columnas -->
                                                <tr style="height: 10px;">

                                                </tr>
                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="1" scope="col">Analisis Covid</th>
                                                    <td colspan="4" style="width: auto;"><?php echo $fila2["analisisCovid"] ?></td>
                                                    <th colspan="3" scope="col">Visitar UFM</th>
                                                    <td colspan="5" style="width: auto;"><?php echo $fila2["visitarUFM"] ?></td>

                                                </tr>
                                                <tr>

                                                    <th colspan="1" scope="col">indicaciones</th>
                                                    <td colspan="10" style="width: auto;"><?php echo $fila2["indicaciones"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">Cirugias</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["cirugias"] ?></td>
                                                </tr>

                                                <tr>
                                                    <th colspan="1" scope="col">Traumatismos</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["traumatismos"] ?></td>
                                                </tr>
                                                <!-- Resto de las columnas -->

                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="1" scope="col">Fracturas</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["fracturas"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">Luxaciones</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["luxaciones"] ?></td>
                                                </tr>
                                                <tr> </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">Alergias</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["alergias"] ?></td>
                                                </tr>
                                                <tr style="height: 10px;">

                                                </tr>
                                                <tr>
                                                    <th colspan="2" scope="col">Agudeza Visual</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["agudezaVisual"] ?></td>
                                                    <th colspan="2" scope="col">envioOpto</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["envioOpto"] ?></td>
                                                    <th colspan="2" scope="col">Examenes de Laboratorio</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["examLab"] ?></td>

                                                </tr>
                                                <!-- Resto de las columnas -->
                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="2" scope="col">Licencia Indica Uso de Lentes</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["licenciaLentes"] ?></td>
                                                    <th colspan="2" scope="col">¿Usa Lentes Graduados?</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["lentGraduadios"] ?></td>
                                                    <th colspan="2" scope="col">Tipo de Sangre</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["tipoSangre"] ?></td>

                                                </tr>
                                                <tr>
                                                    <th colspan="2" scope="col">Riesgo para la Salud</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["riesgoSalub"] ?></td>
                                                    <th colspan="2" scope="col">Perimetro Abdominal</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["perAbdominal"] ?></td>
                                                    <th colspan="2" scope="col">Glucosa Capilar</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["glucosaCapilar"] ?></td>
                                                </tr>
                                                <tr style="height: 10px;">

                                                </tr>
                                                <tr>
                                                    <th colspan="2" scope="col">Observacio visual</th>
                                                    <td colspan="10" style="width: auto;"><?php echo $fila2["observaciones"] ?></td>
                                                </tr>
                                                <tr style="height: 10px;">

                                                </tr>
                                                <tr>


                                                    <th colspan="2" scope="col">I.R.A.S</th>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["iras"] ?></td>
                                                    <th colspan="4" scope="col">Porcentaje de Oxigeno</th>
                                                    <td colspan="4" style="width: auto;"><?php echo $fila2["porcentajeOxigeno"] ?></td>
                                                </tr>
                                                <!-- Resto de las columnas -->
                                                <br>
                                                <tr style="height: 10px;">

                                                </tr>
                                                <!-- Salto de línea -->
                                                <tr>
                                                    <th colspan="2" scope="col">prueba Aplicada</th>
                                                    <td class="sinBorde"></td>
                                                    <!-- prueba aplicada -->
                                                    <th colspan="2" scope="col">Fecha Aplicacion</th>
                                                    <td class="sinBorde"></td>
                                                    <!-- fecha aplicada -->
                                                    <th colspan="2" scope="col">Hora Aplicacion</th>
                                                    <td class="sinBorde"></td>
                                                    <!-- hora aplicada -->
                                                    <th colspan="2" scope="col">Resultado</th>
                                                    </td>

                                                <tr>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["pruevaAplicada"] ?></td>
                                                    <td class="sinBorde"></td>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["FechaAplicacion"] ?></td>
                                                    <td class="sinBorde"></td>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["horaAplicacion"] ?></td>
                                                    <td class="sinBorde"></td>
                                                    <td colspan="2" style="width: auto;"><?php echo $fila2["resultado"] ?></td>
                                                </tr>
                                                <!-- Resto de las columnas -->
                                                <tr style="height: 10px;">

                                                </tr>
                                                <!-- Salto de línea -->
                                                <tr>


                                                    <th colspan="1" scope="col">Diagnostico</th>
                                                    <td style="width: auto;" colspan="10"><?php echo $fila2["diagnostico"] ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="1" scope="col">Indica.F:</th>
                                                    <td style="width: auto;" colspan="10" style="width: auto"><?php echo $fila2["indicacionesFinales"] ?></td>
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




                </div>
            </section>

        </div>

        <div class="responsive-message"></div>

        <style>
            /*
            Use the DejaVu Sans font for display and embedding in the PDF file.
            The standard PDF fonts have no support for Unicode characters.
        */
            .pdf-page {
                font-family: "DejaVu Sans", "Arial", sans-serif;
            }
        </style>

        <script>
            // Import DejaVu Sans font for embedding

            // NOTE: Only required if the Kendo UI stylesheets are loaded
            // from a different origin, e.g. cdn.kendostatic.com
            kendo.pdf.defineFont({
                "DejaVu Sans": "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
                "DejaVu Sans|Bold": "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
                "DejaVu Sans|Bold|Italic": "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
                "DejaVu Sans|Italic": "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf"
            });
        </script>

        <!-- Load Pako ZLIB library to enable PDF compression -->
        <script src="../content/shared/js/pako.min.js"></script>
        <script src="./css/javascript.js"></script>
    </div>
    <div id="footer_nav"></div>
    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>

</html>