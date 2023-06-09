<!DOCTYPE html>
<html lang="es">

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

  <script src="../plugins/multilingual-calendar-date-picker/jquery.calendar.js"></script>
  <link rel="stylesheet" href="../plugins/multilingual-calendar-date-picker/jquery.calendar.css" />

  <link rel="stylesheet" href="../estilos/agendar_cita.css" />
  <script src="../javascript/agendar_cita.js"></script>

</head>

<body>
  <div class="container cont-principal">
    <div class="barra_titulo">
      <div class="row">
        <div class="col-lg-8">
          <h1 style="width: 100%">Datos</h1>
        </div>
        <div class="col-lg-4">
          <br />
          <div class="progress" style="width: 100%; height: 30px">
            <div id="barra_progreso" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
              25%
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <h3 style="width: 100%">Registrar una nueva cita</h3>
      </div>
    </div>
    <div id="paso_1" class="contenedor_paso">
      <h3 style="width: 100%; color: gray; text-align: center">
        Seleccione el servicio y el especialista
      </h3>
      <br /><br />

      <div class="row">
        <div class="col-lg-6">
          <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-11">
              <label for="select_servicio" style="font-weight: bold">Servicio:</label>
              <select class="form-control" id="select_servicio" style="width: 100%; height: 40px">
                <option value="">- seleccionar -</option>
              </select>
              <!-- <input type="text" id="select_servicio" class="form-control" style="width: 100%" readonly value="servicio medico" /> -->
            </div>
          </div>

          <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-11">
              <label for="select_proveedor" style="font-weight: bold">Especialista:</label>
              <select class="form-control" id="select_proveedor" style="width: 100%; height: 40px">
                <option value="-1">- seleccionar -</option>
              </select>
              <!--  <input class="form-control" id="select_proveedor"  style="width: 100%" readonly  type="text" value="" /> -->
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="col-lg-12" style="background-color: wheat; padding: 30px">
            <p>
              <span style="font-weight: bold">Categoria: </span>
              <span id="txt_descripcion_categoria"></span>
            </p>
            <p>
              <span style="font-weight: bold">Servicio: </span>
              <span id="txt_descripcion_servicio"></span>
            </p>
            <!-- <p><span style="font-weight: bold;">Costo: </span> <span id="txt_descripcion_costo"></span></p> -->
            <p>
              <span style="font-weight: bold">Duración: </span>
              <span id="txt_descripcion_duracion"></span>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div id="paso_2" class="contenedor_paso">
      <h3 style="width: 100%; color: gray; text-align: center">
        Seleccione la fecha y hora de cita
      </h3>
      <br /><br />

      <input type="hidden" id="hid_fecha" />
      <input type="hidden" id="hid_hora" />

      <div class="row">
        <div class="col-lg-6" style="margin-bottom: 30px">
          <div id="date_fecha"></div>
        </div>

        <div class="col-lg-1"></div>

        <div class="col-lg-5" style="margin-bottom: 30px">
          <div class="list-group" id="contenedor_horas"></div>
        </div>
      </div>
    </div>
    <div id="paso_3" class="contenedor_paso contenedor_formulario">
      <h3 style="width: 100%; color: gray; text-align: center">Ingrese su información</h3>
      <p style="width: 100%; color: gray; text-align: center">Si ya ha registrado citas anteriormente, sólo basta con ingresar su nombre completo</p>
      <br /><br />



      <div class="row" style="margin-bottom: 20px">
        <form id="buscar-form" method="GET" action="">
          <label for="clave">Buscar por clave:</label>
          <input type="text" id="clave" name="clave">
          <button id="buscar-btn" type="button">Buscar</button>
        </form>
      </div>

      <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-4">
          <label for="txt_nombre" style="font-weight: bold">Nombre :</label>
          <input type="text" id="txt_nombre" class="form-control" style="width: 100%" readonly />
        </div>
        <div class="col-lg-4">
          <label for="txt_apellido_p" style="font-weight: bold">Apellido Paterno :</label>
          <input type="text" id="txt_apellido_p" class="form-control" style="width: 100%" readonly />
        </div>
        <div class="col-lg-4">
          <label for="txt_apellido_m" style="font-weight: bold">Apellido Materno :</label>
          <input type="text" id="txt_apellido_m" class="form-control" style="width: 100%" readonly />
        </div>
      </div>

      <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-6">
          <label for="txt_domicilio" style="font-weight: bold">Depto :</label>
          <input type="text" id="txt_domicilio" class="form-control" style="width: 100%" readonly />
        </div>
        <div class="col-lg-6">
          <label for="txt_telefono" style="font-weight: bold">Teléfono :</label>
          <input type="number" id="txt_telefono" class="form-control" style="width: 100%" />
        </div>
      </div>

      <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-6">
          <label for="txt_correo" style="font-weight: bold">Correo Electrónico :</label>
          <input type="text" id="txt_correo" class="form-control" style="width: 100%" value="a@gmail.com" />
        </div>
        <div class="col-lg-3">
          <label for="select_sexo" style="font-weight: bold">Sexo :</label>
          <select id="select_sexo" class="form-control" style="width: 100%">
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
          </select>
        </div>
        <div class="col-lg-3">
          <label for="txt_edad" style="font-weight: bold">Edad :</label>
          <input type="number" id="txt_edad" class="form-control" style="width: 100%" />
        </div>
      </div>

      <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-12">
          <label for="txt_nota" style="font-weight: bold">Nota :</label>
          <textarea id="txt_nota" placeholder="Si considera necesario puede proporcionar detalles sobre su condición relevantes para su cita" rows="4" style="width: 100%"></textarea>
        </div>
      </div>


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
              },
              error: function() {
                alert('Error al realizar la consulta.');
              }
            });
          }
        });
      </script>
    </div>
    <!-- ---------------------paso 4---------- -->
    <div id="paso_4" class="contenedor_paso">
      <h3 style="width: 100%; color: gray; text-align: center">
        Confirmar cita
      </h3>
      <br /><br />

      <div class="row">
        <div class="col-lg-6" style="margin-bottom: 40px">
          <h4 style="font-weight: bold; width: 100%; text-align: center">
            Datos de la cita:
          </h4><br />
          <p style="font-size: 18px">
            <span style="font-weight: bold">Servicio: </span><span id="confirma_servicio"></span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Proveedor: </span><span id="confirma_proveedor"></span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Fecha: </span><span id="confirma_fecha"></span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Hora: </span><span id="confirma_hora"></span>
          </p>
          <br />
          <p style="font-size: 18px">
            <span style="font-weight: bold">Duración: </span><span id="confirma_duracion"></span>
          </p>
          <!-- <p style="font-size: 18px;"><span style="font-weight:bold;">Precio: </span><span id="confirma_precio"></span></p> -->
        </div>

        <div class="col-lg-6" style="margin-bottom: 40px">
          <h4 style="font-weight: bold; width: 100%; text-align: center">
            Datos del cliente:
          </h4>
          <br />

          <p style="font-size: 18px">
            <span style="font-weight: bold">Cliente: </span><span id="confirma_nombre">N/A</span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Correo: </span><span id="confirma_correo">N/A</span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Teléfono: </span><span id="confirma_telefono">N/A</span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Depto: </span><span id="confirma_domicilio">N/A</span>
          </p>
          <p style="font-size: 18px">
            <span style="font-weight: bold">Nota: </span><span id="confirma_nota">N/A</span>
          </p>
        </div>
      </div>
    </div>
    <div class="contenedor_inferior">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
          <button class="botones" id="btn_anterior">Atras</button>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 text-center">
          <button class="botones" id="btn_siguiente">Siguiente</button>
        </div>
      </div>
    </div>
  </div>
  <div class="loader"></div>
</body>

</html>