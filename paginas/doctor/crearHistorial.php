<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Historial</title>
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
        <div class="panel">
            <div class="panel_body">
                <table class="table table-bordered " style="width: 60%">
                    <tbody>
                        <div>
                            <form action="procesoHistorial.php" method="POST">
                                <input type="hidden" name="id" value="" />
                                <div>
                                    <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                                    <button type="submit" name="procesoHistorial" class="btn btn-primary">Guardar</button>
                                </div>
                                <tr>
                                    <th>Clave</th>
                                    <th colspan="1"><input type="text" name="clave" id="" value=""></th>
                                    <th>Nombre</th>
                                    <th colspan="7"><input type="text" name="nombre" id="" value="" style="width: 752px;"></th>
                                </tr>
                                <tr>
                                    <th>Sexo</th>
                                    <!-- <td><input name="sexo" value=""></td> -->
                                    <td style="width: auto;">
                                        <select name="sexo" id="sexo">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </td>
                                    <th>Edad</th>
                                    <td>
                                        <select name="edad" id="edad">
                                            <?php
                                            for ($i = 17; $i <= 66; $i++) {
                                                echo "<option value=''>" . $i . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </td>
                                    <th>Altura</th>
                                    <td>
                                        <select name="altura" id="altura">m
                                            <?php
                                            for ($i = 100; $i <= 200; $i++) {
                                                $altura = $i / 100;
                                                echo '<option value="' . $altura . '">' . $altura;
                                            }
                                            ?>
                                        </select>

                                    </td>
                                    <th>Peso</th>
                                    <td>

                                        <input type="text" name="peso" id="pesoInput" required>kg
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
                                    <th>Analisis Covid</th>
                                        <td >
                                            <select name="analisisCovid" id="analisisCovid" style="border-color: gainsboro;">
                                                <option value="Negativo">Negativo</option>
                                                <option value="Positivo">Positivo</option>
                                                <option value="Sospechoso">Sopechoso</option>
                                                <option value="Muy sospechoso">Muy Sospechoso</option>
                                            </select>
                                        </td>
                                </tr>
                                <tr>
                                    <th style="height:100px">Sintomas</th>
                                    <td colspan="9"><textarea name="sintomas" id="" cols="127" rows="3" style="resize: none; border-color: gainsboro;"></textarea></td>
                                </tr>
                                <tr>
                                    <th style="height:100px">Diagnostico (IDX)</th>
                                    <td colspan="9"><textarea name="diagnostico" id="" cols="127" rows="3" style="resize: none; border-color: gainsboro;"></textarea></td>
                                </tr>
                                <tr>
                                    <th style="height:150px">Tratamiento (TTO)</th>
                                    <th colspan="9"><textarea name="tratamiento" id="" cols="127" rows="5" style="resize: none; border-color: gainsboro;;"></textarea></th>
                                </tr>
                                <tr>
                                    <th style="height:150px">Instrucciones</th>
                                    <th colspan="9"><textarea name="instrucciones" id="" cols="127" rows="5" style="resize: none; border-color: gainsboro;;"></textarea></th>
                                </tr>
                                <button type="submit" name="guardarHistorial" class="btn">Guardar Historial</button>
                            </form>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
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