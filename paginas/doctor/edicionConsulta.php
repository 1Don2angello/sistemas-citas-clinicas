<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consulta</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

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
                <table class="tabla table-bordered">
                    <form action="editarConsulta.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $fila5["id"] ?>" />
                        <div>
                            <tr>
                                <th colspan="1" for="" class="clave">Clave</th>
                                <th>
                                    <input class="sinborde" type="text" name="clave" id="clave" value="<?php echo $fila5['clave']; ?>">
                                </th>
                                <th colspan="1">
                                    <button id="buscar-btn" type="button">Buscar</button>
                                </th>

                            </tr>
                            <tr>
                                <th colspan="1" class="nombre">Nombre</th>
                                <td><input type="text" readonly name="nombre" id="nombre_completo" value="<?php echo $fila5['nombre']; ?>" style="width: 500px;"></td>
                                <th class="fecha">Fecha</th>
                                <td> <input type="date" class="fecha" name="fecha" value="<?php echo $fila5["fecha"] ?>"></td>
                            </tr>

                            <tr>
                                <th class="edad">Edad</th>
                                <td><input type="text" class="edad" name="edad" value="<?php echo $fila5["edad"] ?>"></td>
                                <th class="sexo">Sexo</th>
                                <td>
                                    <select name="sexo" id="sexo">
                                        <option value="Masculino" <?php if ($fila5["sexo"] == "Masculino") echo "selected"; ?>>Masculino</option>
                                        <option value="Femenino" <?php if ($fila5["sexo"] == "Femenino") echo "selected"; ?>>Femenino</option>
                                    </select>
                                </td>
                                <th class="tensArt">Tens.Art.</th>
                                <td><input type="text" class="tensArt" name="tensArt" value="<?php echo $fila5["tensArt"] ?>"></td>
                                <th class="frCard">Fr.Card</th>
                                <td><input type="text" class="frCard" name="frCard" value="<?php echo $fila5["frCard"] ?>"></td>
                                <th class="imc">I.M.C</th>
                                <td><input type="text" class="imc" name="imc" value="<?php echo $fila5["imc"] ?>"></td>
                                <th class="hora">HORA <input class="sinborde" type="time" name="hora" value="<?php echo $fila5["hora"] ?>"></th>
                            </tr>

                            <tr>
                                <th class="peso">Peso</th>
                                <td><input type="text" class="peso" name="peso" value="<?php echo $fila5["peso"] ?>"></td>
                                <th class="talla">Talla</th>
                                <td><input type="text" class="talla" name="talla" value="<?php echo $fila5["talla"] ?>"></td>
                                 <th class="edoCivil">Edo.Civil</th>
                                <td><input type="text" class="edoCivil" name="edoCivil" value="<?php echo $fila5["edoCivil"] ?>"></td>
                                 <th class="frResp">Fr.Resp</th>
                                <td><input type="text" class="frResp" name="frResp" value="" <?php echo $fila5["frResp"] ?>"></td>
                                 <th class="temp">Temp.</th>
                                <td><input type="text" class="temp" name="temp" value="<?php echo $fila5["temp"] ?>"></td>
                            </tr>
                            <tr>
                               
                               
                            </tr>
                            <tr>
                               
                                <th colspan="1" class="ahf">A.H.F.</th>
                                <td colspan="10"><input type="text" class="ahf" name="ahf" value="<?php echo $fila5["ahf"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="apnp">A.P.N.P</th>
                                <td colspan="1"><input type="text" class="apnp" name="apnp" value="<?php echo $fila5["apnp"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="app">A.P.P</th>
                                <td colspan="1"><input type="text" class="app" name="app" value="<?php echo $fila5["app"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="pActual">P.Actual</th>
                                <td colspan="1"><input type="text" class="pActual" name="pActual" value="<?php echo $fila5["pActual"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="eFisica">eFisica</th>
                                <td colspan="1"><input type="text" class="eFisica" name="eFisica" value="<?php echo $fila5["eFisica"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="fechaN">Fecha de Nacimiento</th>
                                <td colspan="1"><input type="date" class="fechaN" name="fechaN" value="<?php echo $fila5["fechaN"] ?>"></td>
                                <th colspan="1" class="escolaridad">Escolaridad</th>
                                <td colspan="1"><input type="text" class="escolaridad" name="escolaridad" value="<?php echo $fila5["escolaridad"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="puestoS">Puesto Solicitado</th>
                                <td colspan="1"><input type="text" class="puestoS" name="puestoS" value="<?php echo $fila5["puestoS"] ?>"></td>
                                <th colspan="1" class="lugarOrigen">Lugar de Origen</th>
                                <td colspan="1"><input type="text" class="lugarOrigen" name="lugarOrigen" value="<?php echo $fila5["lugarOrigen"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="analisisCovid">Analisis Covid</th>
                                <td colspan="1"><input type="text" class="analisisCovid" name="analisisCovid" value="<?php echo $fila5["analisisCovid"] ?>"></td>
                                <th colspan="1" class="indicaciones">Indicaciones</th>
                                <td colspan="1"><input type="text" class="indicaciones" name="indicaciones" value="<?php echo $fila5["indicaciones"] ?>"></td>
                                 <th class="visitarUFM">Visitar UFM</th>
                                <td><input type="text" class="visitarUFM" name="visitarUFM" value="<?php echo $fila5["visitarUFM"] ?>"></td>
                                <th colspan="1" class="observaciones">Observaciones</th>
                                <td colspan="1"><input type="text" class="observaciones" name="observaciones" value="<?php echo $fila5["observaciones"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="cirugias">Cirugias</th>
                                <td colspan="1"><input type="text" class="cirugias" name="cirugias" value="<?php echo $fila5["cirugias"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="traumatismos">Traumatismos</th>
                                <td colspan="1"><input type="text" class="traumatismos" name="traumatismos" value="<?php echo $fila5["traumatismos"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="fracturas">Fracturas</th>
                                <td colspan="1"><input type="text" class="fracturas" name="fracturas" value="<?php echo $fila5["fracturas"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="luxaciones">Luxaciones</th>
                                <td colspan="1"><input type="text" class="luxaciones" name="luxaciones" value="<?php echo $fila5["luxaciones"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="alergias">Alergias</th>
                                <td colspan="1"><input type="text" class="alergias" name="alergias" value="<?php echo $fila5["alergias"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="agudezaVisual">Agudeza Visual</th>
                                <td colspan="1"><input type="text" class="agudezaVisual" name="agudezaVisual" value="<?php echo $fila5["agudezaVisual"] ?>"></td>
                                <th colspan="1" class="envioOpto">¿Envio al Optometrista?</th>
                                <td colspan="1"><input type="text" class="envioOpto" name="envioOpto" value="<?php echo $fila5["envioOpto"] ?>"></td>
                                 <th colspan="1" class="examLab">Examenes de Laboratorio</th>
                                <td colspan="1"><input type="text" class="examLab" name="examLab" value="<?php echo $fila5["examLab"] ?>"></td>
                            </tr>
                            <tr>
                               
                            </tr>
                            <tr>
                                <th colspan="1" class="licenciaLentes">Licencia Indica Uso de Lentes</th>
                                <td colspan="1"><input type="text" class="licenciaLentes" name="licenciaLentes" value="<?php echo $fila5["licenciaLentes"] ?>"></td>
                                <th colspan="1" class="lentGraduadios">¿Usa Lentes Graduadios?</th>
                                <td colspan="1"><input type="text" class="lentGraduadios" name="lentGraduadios" value="<?php echo $fila5["lentGraduadios"] ?>"></td>
                                <th colspan="1" class="lentGraduadios">Tipo de Sangre</th>
                                <td colspan="1"><input type="text" class="lentGraduadios" name="tipoSangre" value="<?php echo $fila5["tipoSangre"] ?>"></td>
                            </tr>
                            <tr>
                                <th colspan="1" class="riesgoSalub">Riesgo para la Salub</th>
                                <td colspan="1"><input type="text" class="riesgoSalub" name="riesgoSalub" value="<?php echo $fila5["riesgoSalub"] ?>"></td>
                                <th colspan="1" class="perAbdominal">Perimetro Abdominal</th>
                                <td colspan="1"><input type="text" class="perAbdominal" name="perAbdominal" value="<?php echo $fila5["perAbdominal"] ?>"></td>
                                <th colspan="1" class="glucosaCapilar">Glucosa Capilar</th>
                                <td colspan="1"><input type="text" class="glucosaCapilar" name="glucosaCapilar" value="<?php echo $fila5["glucosaCapilar"] ?>"></td>
                            </tr>
                            <tr>
                                
                                <th colspan="1" class="iras">I.R.A.S</th>
                                <td colspan="1"><input type="text" class="iras" name="iras" value="<?php echo $fila5["iras"] ?>"></td>
                                <th colspan="1" class="porcentajeOxigeno">Porcentaje de Oxigeno</th>
                                <td colspan="1"><input type="text" class="porcentajeOxigeno" name="porcentajeOxigeno" value="<?php echo $fila5["porcentajeOxigeno"] ?>"></td>
                                <th class="pruevaAplicada">Prueva Aplicada</th>
                                <td><input type="text" class="pruevaAplicada" name="pruevaAplicada" value="<?php echo $fila5["pruevaAplicada"] ?>"></td>
                            </tr>
                            <tr>
                                
                            </tr>
                            <tr>
                                <th class="FechaAplicacion">Fecha Aplicacion</th>
                                <td><input type="date" class="FechaAplicacion" name="FechaAplicacion" value="<?php echo $fila5["FechaAplicacion"] ?>"></td>
                                <th class="horaAplicacion">Hora Aplicacion</th>
                                <td><input type="time" class="horaAplicacion" name="horaAplicacion" value="<?php echo $fila5["horaAplicacion"] ?>"></td> 
                                <th class="resultado">Resultado</th>
                                <td><input type="text" class="resultado" name="resultado" value="<?php echo $fila5["resultado"] ?>"></td>
                            </tr>
                            <tr>
                               
                                <th class="diagnostico">Diagnostico</th>
                                <td><input type="text" class="diagnostico" name="diagnostico" value="<?php echo $fila5["diagnostico"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="indicacionesFinales">Indicaciones Finales</th>
                                <td><input type="text" name="indicacionesFinales" value="<?php echo $fila5["indicacionesFinales"] ?>"></td>
                            </tr>
                            <tr>
                                <th class="">¿Es apto?</th>
                                <td><select name="aptos" id="aptos">
                                        <option value="si" <?php if ($fila5["aptos"] == "si") echo "selected"; ?>>Si</option>
                                        <option value="no" <?php if ($fila5["aptos"] == "no") echo "selected"; ?>>No</option>
                                    </select><button type="submit" name="editar" class="btn btn-primary">Guardar</button>
                                </td>
                            </tr>

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

                        </div>
                    </form>
                </table>
            </div>
        </div>


    </section>

    <div id="footer_nav"></div>



    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>


</html>