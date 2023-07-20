<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Citas</title>
    <link rel="icon" href="images/favicon.jpg" type="image/x-icon" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/vendor/components/jquery/jquery.min.js"></script>

    <link rel="stylesheet" href="../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="../estilos/agendar_cita.css" />
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear</title>
    <link rel="stylesheet" href="../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <div class="container cont-principal">
        <div class="barra_titulo" style="border: 1px solid #ccc;">
            <div class="row">
                <div class="col-lg-5">
                    <h1 style="width: 100%">Datos</h1>
                </div>
                <div class="col-lg-4">
                    <br />
                    <div class="progress" style="width: 100%; height: 30px">
                        <div id="barra_progreso" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                            95%
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h3 style="width: 100%">Registrar cliente</h3>
                </div>
            </div>
        </div>

        <section id="area_trabajo">
            <div class="container">
                <div class="panel p-5" style="background-color: white; border: none solid #ccc; border-radius: 2px;">

                    <form action="registro_cliente.php" method="POST">
                        <input type="hidden" name="id" value="" />
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txt_nombre" class="form-label">Nombre</label>
                                <input type="text" id="txt_nombre" name="txt_nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="txt_apellido_p" class="form-label">Apellido Paterno</label>
                                <input type="text" id="txt_apellido_p" name="txt_apellido_p" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txt_apellido_m" class="form-label">Apellido Materno</label>
                                <input type="text" id="txt_apellido_m" name="txt_apellido_m" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="txt_telefono" class="form-label">Teléfono</label>
                                <input type="number" id="txt_telefono" name="txt_telefono" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="txt_correo" class="form-label">Correo</label>
                                <input type="email" id="txt_correo" name="txt_correo" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="txt_domicilio" class="form-label">Dirección</label>
                                <input type="text" id="txt_domicilio" name="txt_direccion" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="select_sexo" class="form-label">Sexo</label>
                                <select name="select_sexo" class="form-control" required>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="txt_edad" class="form-label">Edad</label>
                                <input type="number" id="txt_edad" name="txt_edad" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" name="registro" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <form id="buscar-form" method="GET" action="">
                                <label for="clave" class="form-label">Buscar por clave:</label>
                                <input type="text" id="clave" class="form-control">
                                <button id="buscar-btn" type="button" class="btn btn-primary">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <div class="loader"></div>

    <script>
        $(document).ready(function() {
            // Manejar el evento de presionar una tecla en el campo "clave"
            $('#clave').keypress(function(event) {
                // Verificar si la tecla presionada es "Enter"
                if (event.which === 13) {
                    event.preventDefault(); // Evitar el envío del formulario
                    realizarBusqueda();
                    $('#txt_nombre').focus(); // Mover el foco al campo "txt_nombre"
                }
            });
            // Manejar el evento de presionar una tecla en los campos "txt_nombre", "txt_apellido_p" y "txt_domicilio"
            $('#txt_nombre, #txt_apellido_p, #txt_domicilio').keypress(function(event) {
                // Verificar si la tecla presionada es "Enter"
                if (event.which === 13) {
                    event.preventDefault(); // Evitar el envío del formulario
                    $('#txt_apellido_m').focus(); // Mover el foco al campo "txt_apellido_m"
                }
            });
            // Manejar el evento de presionar una tecla en el campo "txt_apellido_m"
            $('#txt_apellido_m').keypress(function(event) {
                // Verificar si la tecla presionada es "Enter"
                if (event.which === 13) {
                    event.preventDefault(); // Evitar el envío del formulario
                    // Puedes realizar alguna acción adicional aquí si es necesario
                }
            });
            // Manejar el evento de clic del botón "Buscar"
            $('#buscar-btn').click(function() {
                realizarBusqueda();
                $('#txt_nombre').focus(); // Mover el foco al campo "txt_nombre"
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

            // Función para realizar la búsqueda y actualizar los campos
            function realizarBusqueda() {
                var clave = $('#clave').val();
                // Realizar la solicitud AJAX
                $.ajax({
                    url: 'consulta.php',
                    method: 'GET',
                    data: {
                        clave: clave
                    },
                    success: function(data) {
                        // Actualizar los campos con los datos devueltos
                        var resultado = JSON.parse(data);
                        $('#txt_nombre').val(resultado.Nombre);
                        $('#txt_apellido_p').val(resultado.Paterno);
                        $('#txt_apellido_m').val(resultado.Materno);
                        $('#txt_domicilio').val(resultado.Depto);
                        $('#txt_telefono').val(resultado.Telefono);
                        // Calcular la edad a partir de la fecha de nacimiento
                        var fechaNacimiento = resultado.Fecha_Nacimiento; // Asegúrate de que el campo sea el adecuado
                        var edad = calcularEdad(fechaNacimiento);
                        $('#txt_edad').val(edad);
                        $('#txt_correo').val(resultado.Correo);
                        

                    },
                    error: function() {
                        alert('Error al realizar la consulta.');
                    }
                });
            }
        });
    </script>




</body>



</html>