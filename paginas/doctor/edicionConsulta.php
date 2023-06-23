<?php
if (isset($_GET['respuesta'])) {
    echo "<div class='card-panel red darken-1'>" . $_GET['respuesta'] . "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consulta</title>

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

        <h2 class="font-weght: bold">Guardar cambios</h2>
        <br />
        <br />
        <div class="panel">
            <div class="panel_titulo">
                <h5>Datos del pacientes</h5>
            </div>
            <div class="panel_body">
                <h1> <?php
                        include('../../configDBsqlserver.php'); //Conexión a la base de datos
                        $id = $_GET['id']; //Variable enviada desde la página consultas.php
                        // Asegúrate de que $id sea un número
                        // Consulta SQL
                        $consulta = "SELECT * FROM gestion_citas.pacientes WHERE id = :id";
                        // Preparar la consulta
                        $stmt = $conn2->prepare($consulta);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        // Ejecutar la consulta
                        $resultado = $stmt->execute();
                        if ($resultado === false) {
                            die(print_r($stmt->errorInfo(), true));
                        }
                        // Obtener el registro
                        $fila5 = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?></h1>
                <br>
                <hr>
                <table class="table table-bordered " style="width: 90%">
                    <tbody>
                        <form action="editarConsulta.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $fila5["id"] ?>" />
                            <div>

                                <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                                <button type="submit" name="editar" class="btn btn-primary">Guardar</button>

                            </div>
                            <thead>
                                <tr>
                                    <th colspan="1" scope="col">Clave</th>
                                    <td style="width: auto;">
                                        <input type="text" name="clave" id="clave" value="<?php echo $fila5['clave']; ?>">

                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Nombre</th>
                                    <td colspan="4" style="width: auto;"><input type="text" name="nombre" id="nombre_completo" value="<?php echo $fila5['nombre']; ?>" style="width: 500px;"></td>
                                    <th colspan="1" scope="col">Fecha</th>
                                    <td colspan="4" style="width: auto;"> <input type="date" name="fecha" value="<?php echo $fila5["fecha"] ?>"></td>
                                </tr>

                                <tr>
                                    <th colspan="1" scope="col">Edad</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "edad" name="edad" value="<?php echo $fila5["edad"] ?>"></td>
                                    <th colspan="1" scope="col">Sexo</th>
                                    <td style="width: auto;">
                                        <select name="sexo" id="sexo">
                                            <option value="Masculino" <?php if ($fila5["sexo"] == "Masculino") echo "selected"; ?>>Masculino</option>
                                            <option value="Femenino" <?php if ($fila5["sexo"] == "Femenino") echo "selected"; ?>>Femenino</option>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">Tens.Art.</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "tensArt" name="tensArt" value="<?php echo $fila5["tensArt"] ?>"></td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Peso</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "peso" name="peso" value="<?php echo $fila5["peso"] ?>"></td>
                                    <th colspan="1" scope="col">Talla</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "talla" name="talla" value="<?php echo $fila5["talla"] ?>"></td>
                                    <th colspan="1" scope="col">Edo.Civil</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "edoCivil" name="edoCivil" value="<?php echo $fila5["edoCivil"] ?>"></td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fr.Card</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "frCard" name="frCard" value="<?php echo $fila5["frCard"] ?>"></td>
                                    <th colspan="1" scope="col">I.M.C</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "imc" name="imc" value="<?php echo $fila5["imc"] ?>"></td>
                                    <th colspan="1" scope="col">HORA </th>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fr.Resp</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "frResp" name="frResp" value="" <?php echo $fila5["frResp"] ?>"></td>
                                    <th colspan="1" scope="col">Temp.</th>
                                    <td style="width: auto;"><input type="text" class="pequenio" "temp" name="temp" value="<?php echo $fila5["temp"] ?>">
                                    </td>
                                    <td style="width: auto;"> <input class="sinborde" type="time" name="hora" value="<?php echo $fila5["hora"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">A.H.F.</th>
                                    <td colspan="10" style="width: auto;" colspan="10"><input class="grande" type="text" class="" "ahf" name="ahf" value="<?php echo $fila5["ahf"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">A.P.N.P</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "apnp" name="apnp" value="<?php echo $fila5["apnp"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">A.P.P</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "app" name="app" value="<?php echo $fila5["app"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">P.Actual</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "pActual" name="pActual" value="<?php echo $fila5["pActual"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">eFisica</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "eFisica" name="eFisica" value="<?php echo $fila5["eFisica"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fecha de Nacimiento</th>
                                    <td style="width: auto;"><input type="date" class="fechaN" name="fechaN" value="<?php echo $fila5["fechaN"] ?>"></td>
                                    <th colspan="1" scope="col">Escolaridad</th>
                                    <td style="width: auto;"><input type="text" class="" "escolaridad" name="escolaridad" value="<?php echo $fila5["escolaridad"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Puesto Solicitado</th>
                                    <td style="width: auto;"><input type="text" class="" "puestoS" name="puestoS" value="<?php echo $fila5["puestoS"] ?>"></td>
                                    <th colspan="1" scope="col">Lugar de Origen</th>
                                    <td style="width: auto;"><input type="text" class="" "lugarOrigen" name="lugarOrigen" value="<?php echo $fila5["lugarOrigen"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Analisis Covid</th>
                                    <td style="width: auto;"><input type="text" class="" "analisisCovid" name="analisisCovid" value="<?php echo $fila5["analisisCovid"] ?>"></td>
                                    <th colspan="1" scope="col">Indicaciones</th>
                                    <td style="width: auto;"><input type="text" class="" "indicaciones" name="indicaciones" value="<?php echo $fila5["indicaciones"] ?>"></td>
                                    <th colspan="1" scope="col" arUFM">Visitar UFM</th>
                                    <td style="width: auto;"><input type="text" class="" "visitarUFM" name="visitarUFM" value="<?php echo $fila5["visitarUFM"] ?>"></td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Observaciones</th>
                                    <td style="width: auto;"><input class="grande" type="text" class="" "observaciones" name="observaciones" value="<?php echo $fila5["observaciones"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Cirugias</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "cirugias" name="cirugias" value="<?php echo $fila5["cirugias"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Traumatismos</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "traumatismos" name="traumatismos" value="<?php echo $fila5["traumatismos"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fracturas</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "fracturas" name="fracturas" value="<?php echo $fila5["fracturas"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Luxaciones</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "luxaciones" name="luxaciones" value="<?php echo $fila5["luxaciones"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Alergias</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "alergias" name="alergias" value="<?php echo $fila5["alergias"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Agudeza Visual</th>
                                    <td style="width: auto;"><input type="text" class="" "agudezaVisual" name="agudezaVisual" value="<?php echo $fila5["agudezaVisual"] ?>"></td>
                                    <th colspan="1" scope="col">¿Envio al Optometrista?</th>
                                    <td style="width: auto;"><input type="text" class="" "envioOpto" name="envioOpto" value="<?php echo $fila5["envioOpto"] ?>"></td>
                                    <th colspan="1" scope="col">Examenes de Laboratorio</th>
                                    <td style="width: auto;"><input type="text" class="" "examLab" name="examLab" value="<?php echo $fila5["examLab"] ?>"></td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Licencia Indica Uso de Lentes</th>
                                    <td style="width: auto;"><input type="text" class="" "licenciaLentes" name="licenciaLentes" value="<?php echo $fila5["licenciaLentes"] ?>"></td>
                                    <th colspan="1" scope="col">¿Usa Lentes Graduadios?</th>
                                    <td style="width: auto;"><input type="text" class="" "lentGraduadios" name="lentGraduadios" value="<?php echo $fila5["lentGraduadios"] ?>"></td>
                                    <th colspan="1" scope="col">Tipo de Sangre</th>
                                    <td style="width: auto;"><input type="text" class="" "lentGraduadios" name="tipoSangre" value="<?php echo $fila5["tipoSangre"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Riesgo para la Salub</th>
                                    <td style="width: auto;"><input type="text" class="" "riesgoSalub" name="riesgoSalub" value="<?php echo $fila5["riesgoSalub"] ?>"></td>
                                    <th colspan="1" scope="col">Perimetro Abdominal</th>
                                    <td style="width: auto;"><input type="text" class="" "perAbdominal" name="perAbdominal" value="<?php echo $fila5["perAbdominal"] ?>"></td>
                                    <th colspan="1" scope="col">Glucosa Capilar</th>
                                    <td style="width: auto;"><input type="text" class="" "glucosaCapilar" name="glucosaCapilar" value="<?php echo $fila5["glucosaCapilar"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">I.R.A.S</th>
                                    <td style="width: auto;"><input type="text" class="" "iras" name="iras" value="<?php echo $fila5["iras"] ?>"></td>
                                    <th colspan="1" scope="col">Porcentaje de Oxigeno</th>
                                    <td style="width: auto;"><input type="text" class="" "porcentajeOxigeno" name="porcentajeOxigeno" value="<?php echo $fila5["porcentajeOxigeno"] ?>"></td>
                                    <th colspan="1" scope="col" aAplicada">Prueva Aplicada</th>
                                    <td style="width: auto;"><input type="text" class="" "pruevaAplicada" name="pruevaAplicada" value="<?php echo $fila5["pruevaAplicada"] ?>"></td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fecha Aplicacion</th>
                                    <td style="width: auto;"><input type="date" class="FechaAplicacion" name="FechaAplicacion" value="<?php echo $fila5["FechaAplicacion"] ?>"></td>
                                    <th colspan="1" scope="col">Hora Aplicacion</th>
                                    <td style="width: auto;"><input type="time" class="horaAplicacion" name="horaAplicacion" value="<?php echo $fila5["horaAplicacion"] ?>"></td>
                                    <th colspan="1" scope="col">Resultado</th>
                                    <td style="width: auto;"><input type="text" class="" "resultado" name="resultado" value="<?php echo $fila5["resultado"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Diagnostico</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" class="" "diagnostico" name="diagnostico" value="<?php echo $fila5["diagnostico"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Indicaciones Finales</th>
                                    <td colspan="10" style="width: auto;"><input class="grande" type="text" name="indicacionesFinales" value="<?php echo $fila5["indicacionesFinales"] ?>"></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col" > Es apto?</th>
                                    <td colspan="1" style="width: auto;"><select name="aptos" id="aptos">
                                            <option value="si" <?php if ($fila5["aptos"] == "si") echo "selected"; ?>>Si</option>
                                            <option value="no" <?php if ($fila5["aptos"] == "no") echo "selected"; ?>>No</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                    <button type="submit" name="editar" class="btn btn-primary">Guardar</button>
                                    </td>
                                </tr>
                                
                            </thead>
                        </form>
                    </tbody>



                </table>
            </div>
        </div>
        </div>
        <br /><br />
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Manejar el evento de clic del botón "Buscar"
            $('#buscar-btn').click(function() {
                buscar();
            });
            // Manejar el evento de presionar la tecla Enter en el campo de texto "Clave"
            $('#clave').keydown(function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    buscar(); // Llamar a la función buscar
                    $('#nombre_completo').focus();
                }
            });
            $('#nombre_completo').keydown(function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    // Aquí puedes realizar la acción de guardar o desplazarte al siguiente campo
                }
            });
            // Manejar el evento de presionar la tecla Enter en los campos de texto
            $('input').keydown(function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    var inputs = $('input'); // Obtener todos los campos de texto
                    var currentIndex = inputs.index(this); // Obtener el índice del campo actual
                    var nextIndex = currentIndex + 1; // Calcular el índice del siguiente campo
                    // Mover el foco al siguiente campo de texto o al primer campo si es el último
                    if (nextIndex < inputs.length) {
                        inputs[nextIndex].focus();
                    } else {
                        inputs[0].focus();
                    }
                }
            });

            // Manejar el evento de presionar la tecla Tab en los campos de texto
            $('input').keydown(function(event) {
                if (event.which === 9) {
                    var inputs = $('input'); // Obtener todos los campos de texto
                    var currentIndex = inputs.index(this); // Obtener el índice del campo actual
                    var nextIndex = currentIndex + 1; // Calcular el índice del siguiente campo

                    // Mover el foco al siguiente campo de texto o al primer campo si es el último
                    if (nextIndex < inputs.length) {
                        inputs[nextIndex].focus();
                    } else {
                        inputs[0].focus();
                    }

                    event.preventDefault(); // Evitar el comportamiento predeterminado de la tecla Tab
                }
            });
            // Función para realizar la búsqueda
            function buscar() {
                var clave = $('#clave').val();
                // Realizar la solicitud AJAX
                $.ajax({
                    url: '../../paginas/consulta.php',
                    method: 'GET',
                    data: {
                        clave: clave
                    },
                    success: function(data) {
                        // Actualizar el campo de nombre completo con los datos devueltos
                        var resultado = JSON.parse(data);
                        var nombreCompleto = resultado.Nombre + ' ' + resultado.Paterno + ' ' + resultado.Materno;
                        $('#nombre_completo').val(nombreCompleto);
                    },
                    error: function() {
                        alert('Error al realizar la consulta.');
                    }
                });
            }
        });
    </script>
    <div id="footer_nav"></div>



    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>


</html>