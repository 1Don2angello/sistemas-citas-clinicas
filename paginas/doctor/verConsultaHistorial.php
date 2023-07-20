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
                                    <!-- <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                                    <button type="submit" name="editar" class="btn btn-primary">Guardar</button> -->
                                </div>
                                <tr>
                                    <th>Clave</th>
                                    <th colspan="1"><?php echo $fila5['clave']; ?></th>
                                    <th>Nombre</th>
                                    <th colspan="7"><?php echo $fila5['nombre']; ?></th>
                                </tr>
                                <tr>
                                    <th>Sexo</th>
                                    <!-- <td><input name="sexo" value=""></td> -->
                                    <td style="width: auto;"><?php echo $fila5['sexo']; ?>
                                        
                                    </td>

                                    <th>Edad</th>
                                    <td><?php echo $fila5['edad']; ?>
                                        
                                    </td>
                                    <th>Altura</th>
                                    <td><?php echo $fila5['altura']; ?>
                                        
                                    </td>

                                    </td>
                                    <th>Peso</th>
                                    <td><?php echo $fila5['peso']; ?> kg
                                        
                                    </td>


                                    <th>Analisis Covid</th>
                                    <td> <?php echo $fila5['analisisCovid']; ?>
                                        
                                    </td>

                                </tr>
                                <tr>
                                    <th style="height:100px">Síntomas</th>
                                    <td colspan="9"><?php echo $fila5['sintomas']; ?></td>
                                </tr>
                                <tr>
                                    <th style="height:100px">Diagnóstico (IDX)</th>
                                    <td colspan="9"><?php echo $fila5['diagnostico']; ?></td>
                                </tr>
                                <tr>
                                    <th style="height:150px">Tratamiento (TTO)</th>
                                    <td colspan="9"><?php echo $fila5['tratamiento']; ?></td>
                                </tr>
                                <tr>
                                    <th style="height:150px">Instrucciones</th>
                                    <td colspan="9"><?php echo $fila5['instrucciones']; ?></td>
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