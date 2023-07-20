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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
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
                <h1> Crear consulta</h1>
                <br>
                <hr>
                <table class="table table-bordered " style="width: auto">
                    <tbody>
                        <form action="procesoConsulta.php" method="POST">
                            <input type="hidden" name="id" value="" />
                            <div>

                                <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                                <button type="submit" name="procesoConsulta" class="btn btn-primary">Guardar</button>
                            </div>
                            <thead>
                                <tr>
                                    <th colspan="1" scope="col">Clave</th>
                                    <td style="width: auto;">
                                        <input type="text" name="clave" id="clave" value="">

                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Nombre</th>
                                    <td colspan="3" style="width: auto;"><input type="text" name="nombre" id="nombre_completo" value="" style="width: 500px;"></td>
                                    <th colspan="1" scope="col">Fecha</th>
                                    <td colspan="4" style="width: auto;"> <input type="date" name="fecha" value=""></td>
                                </tr>

                                <tr>
                                    <th colspan="1" scope="col">Edad</th>
                                    <td style="width: auto;">
                                        <select class="pequenio" id="txt_edad" name="edad">
                                            <?php
                                            $selectedValue = $fila5["edad"]; // Valor seleccionado actualmente
                                            for ($i = 17; $i <= 66; $i++) {
                                                $selected = ($i == $selectedValue) ? "selected" : ""; // Marcar el valor seleccionado actualmente
                                                echo "<option value='$i' $selected>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">Sexo</th>
                                    <td style="width: auto;">
                                        <select name="sexo" id="sexo">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">Tensión Arterial</th>
                                    <td colspan="1" style="width: auto;"><input type="text" class="grande" name="tensArt" value=""></td>

                                </tr>


                                <tr>
                                    <th colspan="1" scope="col">Peso</th>
                                    <td tyle="width: auto;">
                                        <input type="text" name="peso" class="grande" id="pesoInput" value="" required>kg
                                        <script>
                                            var pesoInput = document.getElementById("pesoInput");
                                            pesoInput.addEventListener("input", function(event) {
                                                var input = event.target;
                                                var inputValue = input.value.trim();

                                                // Eliminar cualquier carácter no numérico
                                                var numericValue = inputValue.replace(/[^0-9.]/g, "");

                                                // Validar si el valor es un número
                                                if (!isNaN(numericValue)) {
                                                    // Agregar "kg" al final del valor numérico
                                                    input.value = numericValue;
                                                } else {
                                                    // Limpiar el campo si no es un número válido
                                                    input.value = "";
                                                }
                                            });
                                        </script>
                                    </td>

                                    <th>Altura</th>
                                    <td>
                                        <select name="talla" id="altura">m
                                            <?php
                                            for ($i = 100; $i <= 200; $i++) {
                                                $altura = $i / 100;
                                                echo '<option value="' . $altura . '">' . $altura;
                                            }
                                            ?>
                                        </select>

                                    </td>
                                    <th colspan="1" scope="col">Índice de Masa Corporal</th>
                                    <td style="width: auto;"><input type="text" class="grande" name="imc" id="imcInput" value="" readonly></td>
                                </tr>
                                <script>
                                    var pesoInput = document.getElementById("pesoInput");
                                    var alturaSelect = document.getElementById("altura");
                                    var imcInput = document.getElementById("imcInput");

                                    pesoInput.addEventListener("input", function(event) {
                                        calcularIMC();
                                    });

                                    alturaSelect.addEventListener("change", function(event) {
                                        calcularIMC();
                                    });

                                    function calcularIMC() {
                                        var peso = parseFloat(pesoInput.value);
                                        var altura = parseFloat(alturaSelect.value);
                                        var imc = peso / (altura * altura);
                                        imcInput.value = imc.toFixed(2);
                                    }
                                </script>

                                <tr>
                                    <th colspan="1" scope="col">Frecuencia Cardíaca</th>
                                    <td style="width: auto;"><input type="text" class="grande" name="frCard" value=""></td>


                                    <th colspan="1" scope="col">Estado Civil</th>
                                    <td style="width: auto;">
                                        <select type="text" class="grande" name="edoCivil" value="" style="border-color: gainsboro;">
                                            <option value="Seleccionar">----</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Separado">Separado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select>
                                    </td>
                                    <th colspan="2" scope="col">HORA </th>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Frecuencia Respiratoria</th>
                                    <td colspan="1" style="width: auto;"><input type="text" class="grande" name="frResp" value=""></td>
                                    <th colspan="1" scope="col">Temperatura corporal</th>
                                    <td style="width: auto;"><input type="text" class="grande" name="temp" value="">
                                    </td>
                                    <td colspan="2" style="width: auto;"> <input class="sinborde" type="time" name="hora" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Antecedentes Heredo-Familiares</th>
                                    <td colspan="5" style="width: auto;" colspan="5"><input class="grande" type="text" class="" name="ahf" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Antecedentes Personales No Patológicos</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="apnp" value="" "></td>
                                </tr>
                                <tr>
                                    <th colspan=" 1" scope="col">Antecedentes Personales Patológicos</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="app" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Padecimiento Actual.</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="pActual" value="" "pAc></td>
                                </tr>
                                <tr>
                                    <th colspan=" 1" scope="col">Exploración Física</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="eFisica" value="" "eFi></td>
                                </tr>
                                <tr>
                                    <th colspan=" 1" scope="col">Fecha de Nacimiento</th>
                                    <td colspan="2" style="width: auto;"><input class="grande" type="date" class="fechaN"  id="fechaN" name="fechaN" value=""></td>
                                    <th colspan="1" scope="col">Escolaridad</th>
                                    <td colspan="2" style="width: auto;">
                                        <select name="escolaridad">
                                            <option value="Seleccionar">----</option>
                                            <option value="Primaria">Primaria</option>
                                            <option value="Secundaria">Secundaria</option>
                                            <option value="Preparatoria">Preparatoria</option>
                                            <option value="Universidad">Universidad</option>
                                            <option value="Posgrado">Posgrado</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Puesto Solicitado</th>
                                    <td colspan="2" style="width: auto;"><input class="grande" type="text" class="" name="puestoS" value=""></td>
                                    <th colspan="1" scope="col">Lugar de Origen</th>
                                    <td colspan="2" style="width: auto;">
                                        <select name="lugarOrigen">
                                            <option value="">Selecciona un estado</option>
                                            <?php
                                            $estados = array("Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Coahuila", "Colima", "Chiapas", "Chihuahua", "Ciudad de México", "Durango", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "México", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas");

                                            foreach ($estados as $estado) {
                                                echo '<option value="' . $estado . '">' . $estado . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Analisis Covid</th>
                                    <td colspan="2" style="width: auto;"><input class="grande" type="text" class="" name="analisisCovid" value=""></td>

                                    <th colspan="1" scope="col" arUFM">Visitar UFM</th>
                                    <td colspan="2" style="width: auto;">
                                        <select name="visitarUFM" id="visitarUFM">
                                            <option value="Seleccionar">----</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Indicaciones</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="indicaciones" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Cirugias</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="cirugias" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Traumatismos</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="traumatismos" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fracturas</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="fracturas" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Luxaciones</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="luxaciones" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Alergias</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="alergias" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Agudeza Visual</th>
                                    <td style="width: auto;"><input type="text" class="" name="agudezaVisual" value=""></td>
                                    <th colspan="1" scope="col">¿Envio al Optometrista?</th>
                                    <td style="width: auto;">
                                        <select name="envioOpto" id="envioOpto">
                                            <option value="Seleccionar">----</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">Examenes de Laboratorio</th>
                                    <td style="width: auto;"><input type="text" class="" name="examLab" value=""></td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Licencia Indica Uso de Lentes</th>
                                    <td style="width: auto;">
                                        <select name="licenciaLentes" id="licenciaLentes">
                                            <option value="Seleccionar">----</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">¿Usa Lentes Graduadios?</th>
                                    <td style="width: auto;">
                                        <select name="lentGraduadios" id="lentGraduadios">
                                            <option value="Seleccionar">----</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <th colspan="1" scope="col">Tipo de Sangre</th>
                                    <td style="width: auto;">
                                        <select name="tipoSangre" id="tipoSangre">
                                            <option value="Seleccionar">----</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Riesgo para la Salub</th>
                                    <td style="width: auto;"><input type="text" class="" name="riesgoSalub" value=""></td>
                                    <th colspan="1" scope="col">Perimetro Abdominal</th>
                                    <td style="width: auto;"><input type="text" class="" name="perAbdominal" value=""></td>
                                    <th colspan="1" scope="col">Glucosa Capilar</th>
                                    <td style="width: auto;"><input type="text" class="" name="glucosaCapilar" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Observacion visual</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="observaciones" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Infecciones Respiratorias Agudas</th>
                                    <td style="width: auto;"><input type="text" class="" "iras" name="iras" value="" "></td>
                                    <th colspan=" 1" scope="col">Porcentaje de Oxigeno</th>
                                    <td style="width: auto;"><input type="text" class="" name="porcentajeOxigeno" value=""></td>
                                    <th colspan="1" scope="col" aAplicada">Prueva Aplicada</th>
                                    <td style="width: auto;"><input type="text" class="" name="pruevaAplicada" value=""></td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Fecha Aplicacion</th>
                                    <td style="width: auto;"><input type="date" class="FechaAplicacion" name="FechaAplicacion" value=""></td>
                                    <th colspan="1" scope="col">Hora Aplicacion</th>
                                    <td style="width: auto;"><input type="time" class="horaAplicacion" name="horaAplicacion" value=""></td>
                                    <th colspan="1" scope="col">Resultado</th>
                                    <td style="width: auto;"><input type="text" class="" name="resultado" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Diagnostico</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" class="" name="diagnostico" value=""></td>
                                </tr>
                                <tr>
                                    <th colspan="1" scope="col">Indicaciones Finales</th>
                                    <td colspan="5" style="width: auto;"><input class="grande" type="text" name="indicacionesFinales" value=""></td>
                                </tr>
                                <tr>

                                    <th colspan="1" scope="col"> Estado del paciente</th>
                                    <td colspan="1" style="width: auto;"><select name="aptos" id="aptos">
                                            <option value="apto">Apto</option>
                                            <option value="no-apto">No apto</option>
                                            <option value="condicion">Condicionado</option>
                                            <option value="mcondicion">Muy condicionado</option>
                                        </select>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" name="procesoConsulta" class="btn btn-primary">Guardar</button>
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
            // Función para calcular la edad a partir de la fecha de nacimiento
            function calcularEdad(fechaNacimiento) {
                var fechaNac = new Date(fechaNacimiento);
                var fechaActual = new Date();

                var edad = fechaActual.getFullYear() - fechaNac.getFullYear();

                // Si el cumpleaños de este año aún no ha sucedido, restar 1 a la edad
                var mesActual = fechaActual.getMonth() + 1;
                var mesNacimiento = fechaNac.getMonth() + 1;
                if (mesActual < mesNacimiento || (mesActual === mesNacimiento && fechaActual.getDate() < fechaNac.getDate())) {
                    edad--;
                }

                return edad;
            }

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
                        // Calcular la edad a partir de la fecha de nacimiento
                        var fechaNacimiento = resultado.Fecha_Nacimiento; // Asegúrate de que el campo sea el adecuado
                        var edad = calcularEdad(fechaNacimiento);
                        $('#txt_edad').val(edad);
                        // Imprimir la fecha de nacimiento en el campo de entrada con clase "fechaN"
                        $('#fechaN').val(fechaNacimiento);

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