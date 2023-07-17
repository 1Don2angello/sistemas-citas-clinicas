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
                <h1> <?php
                        include('../../configDBsqlserver.php'); //Conexión a la base de datos
                        $id = $_GET['id']; //Variable enviada desde la página consultas.php
                        // Asegúrate de que $id sea un número
                        // Consulta SQL
                        $consulta = "SELECT * FROM gestion_citas.historial WHERE id = :id";
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
                <table class="table table-bordered " style="width: 60%">
                    <tbody>
                        <div>
                            <form action="editarHistorial.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $fila5["id"] ?>" />
                                <div>
                                    <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                                    <button type="submit" name="editar" class="btn btn-primary">Guardar</button>
                                </div>
                                <tr>
                                    <th>Clave</th>
                                    <th colspan="1"><input type="text" name="clave" id="" value="<?php echo $fila5['clave']; ?>"></th>
                                    <th>Nombre</th>
                                    <th colspan="7"><input type="text" name="nombre" id="" style="width: 752px;" value="<?php echo $fila5['nombre']; ?>"></th>
                                </tr>
                                <tr>
                                    <th>Sexo</th>
                                    <!-- <td><input name="sexo" value=""></td> -->
                                    <td style="width: auto;">
                                        <select name="sexo" id="sexo">
                                            <option value="Masculino" <?php if ($fila5["sexo"] == "Masculino") echo "selected"; ?>>Masculino</option>
                                            <option value="Femenino" <?php if ($fila5["sexo"] == "Femenino") echo "selected"; ?>>Femenino</option>
                                        </select>
                                    </td>

                                    <th>Edad</th>
                                    <td>
                                        <select name="edad" id="edad">
                                            <?php
                                            $selectedEdad = $fila5["edad"]; // Obtener el valor de edad del registro actual
                                            for ($i = 17; $i <= 66; $i++) {
                                                $selected = ($i == $selectedEdad) ? "selected" : ""; // Verificar si el valor actual coincide con la edad del registro
                                                echo "<option value='$i' $selected>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <th>Altura</th>
                                    <td>
                                        <select name="altura" id="altura">
                                            <?php
                                            $selectedAltura = $fila5["altura"]; // Obtener el valor de altura del registro actual
                                            for ($i = 100; $i <= 200; $i++) {
                                                $altura = $i / 100;
                                                $selected = ($altura == $selectedAltura) ? "selected" : ""; // Verificar si el valor actual coincide con la altura del registro
                                                echo "<option value='$altura' $selected>$altura</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    </td>
                                    <th>Peso</th>
                                    <td>
                                        <input type="text" name="peso" id="pesoInput" value="<?php echo $fila5['peso']; ?>" required>kg
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
                                    <td>
                                        <select name="analisisCovid" id="analisisCovid" style="border-color: gainsboro;">
                                            <option value="Negativo" <?php if ($fila5["analisisCovid"] == "Negativo") echo "selected"; ?>>Negativo</option>
                                            <option value="Positivo" <?php if ($fila5["analisisCovid"] == "Positivo") echo "selected"; ?>>Positivo</option>
                                            <option value="Sospechoso" <?php if ($fila5["analisisCovid"] == "Sospechoso") echo "selected"; ?>>Sospechoso</option>
                                            <option value="Muy sospechoso" <?php if ($fila5["analisisCovid"] == "Muy sospechoso") echo "selected"; ?>>Muy Sospechoso</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <th style="height:100px">Síntomas</th>
                                    <td colspan="9"><textarea name="sintomas" cols="127" rows="3" style="resize: none; border-color: gainsboro;"><?php echo $fila5['sintomas']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <th style="height:100px">Diagnóstico (IDX)</th>
                                    <td colspan="9"><textarea name="diagnostico" cols="127" rows="3" style="resize: none; border-color: gainsboro;"><?php echo $fila5['diagnostico']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <th style="height:150px">Tratamiento (TTO)</th>
                                    <td colspan="9"><textarea name="tratamiento" cols="127" rows="5" style="resize: none; border-color: gainsboro;"><?php echo $fila5['tratamiento']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <th style="height:150px">Instrucciones</th>
                                    <td colspan="9"><textarea name="instrucciones" cols="127" rows="5" style="resize: none; border-color: gainsboro;"><?php echo $fila5['instrucciones']; ?></textarea></td>
                                </tr>


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