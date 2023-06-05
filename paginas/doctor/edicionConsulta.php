<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Consulta</title>
    </head>
    <body>
        <?php
            include('conexion.php'); //Conexión a la db
            $id = $_GET['id']; //Variable enviada desde la apagina consultas.php
            // Asegúrate de que $id sea un número
            //$id = intval($id);

            //query
            $consulta5 = "SELECT * FROM pacientes WHERE id = '$id' "; 

            //consulta a la db e inserción de query
            //$resultado = mysqli_query($conexion, $consulta); 
            $resultado5 = mysqli_query($conn, $consulta5);
            
            if(!$resultado5) {/* ($resultado5 === false) */
                die( print_r( mysqli_connect_errno(), true));
            }
            //Recorrido de registros
            $fila5 = mysqli_fetch_array($resultado5);/* Gracias  */
        ?>
        <form action="editarConsulta.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $fila5["id"] ?>"/>
            
            <label for="">Clave</label>
            <input type="text" name="clave" value="<?php echo $fila5["clave"] ?>">

            <label for="">Hora</label>
            <input type="time" name="hora" value="<?php echo $fila5["hora"] ?>" >

            <label for="">Nombre</label>
            <input type="text" name="nombre" value="<?php echo $fila5["nombre"] ?>">

            <label for="">Fecha</label>
            <input type="date" name="fecha" value="<?php echo $fila5["fecha"] ?>">

            <label for="">Edad</label>
            <input type="text" name="edad" value="<?php echo $fila5["edad"] ?>">

            <label for="">Peso</label>
            <input type="text" name="peso" value="<?php echo $fila5["peso"] ?>">

            <label for="">Sexo</label>
            <input type="text" name="sexo" value="<?php echo $fila5["sexo"] ?>">

            <label for="">Talla</label>
            <input type="text" name="talla" value="<?php echo $fila5["talla"] ?>">

            <label for="">Tension Artereal</label>
            <input type="text" name="tensArt" value="<?php echo $fila5["tensArt"] ?>">

            <label for="">Estado Civil</label>
            <input type="text" name="edoCivil" value="<?php echo $fila5["edoCivil"] ?>">

            <label for="">Frecuencia Cardiaca</label>
            <input type="text" name="frCard" value="<?php echo $fila5["frCard"] ?>">
            
            <label for="">Frecuencia Respiratoria</label>
            <input type="text" name="frResp" value="<?php echo $fila5["frResp"] ?>">

            <label for="">IMC</label>
            <input type="text" name="imc" value="<?php echo $fila5["imc"] ?>">

            <label for="">Temperatura</label>
            <input type="text" name="temp" value="<?php echo $fila5["temp"] ?>">

            <label for="">AHF</label>
            <input type="text" name="ahf" value="<?php echo $fila5["ahf"] ?>">

            <label for="">apnp</label>
            <input type="text" name="apnp" value="<?php echo $fila5["apnp"] ?>">

            <label for="">app</label>
            <input type="text" name="app" value="<?php echo $fila5["app"] ?>">

            <label for="">P. Actual</label>
            <input type="text" name="pActual" value="<?php echo $fila5["pActual"] ?>">

            <label for="">E. Fisica</label>
            <input type="text" name="eFisica" value="<?php echo $fila5["eFisica"] ?>">

            <label for="">Fecha de Nacimiento</label>
            <input type="date" name="fechaN" value="<?php echo $fila5["fechaN"] ?>">

            <label for="">Puesto Solicitado</label>
            <input type="text" name="puestoS" value="<?php echo $fila5["puestoS"] ?>">

            <label for="">Escolaridad</label>
            <input type="text" name="escolaridad" value="<?php echo $fila5["escolaridad"] ?>">

            <label for="">Lugar de Origen</label>
            <input type="text" name="lugarOrigen" value="<?php echo $fila5["lugarOrigen"] ?>">

            <label for="">Analisis Covid</label>
            <input type="text" name="analisisCovid" value="<?php echo $fila5["analisisCovid"] ?>">

            <label for="">Indicaciones</label>
            <input type="text" name="indicaciones" value="<?php echo $fila5["indicaciones"] ?>">

            <label for="">Visitar UFM</label>
            <input type="text" name="visitarUFM" value="<?php echo $fila5["visitarUFM"] ?>">

            <label for="">Observaciones</label>
            <input type="text" name="observaciones" value="<?php echo $fila5["observaciones"] ?>">

            <label for="">Cirugias</label>
            <input type="text" name="cirugias" value="<?php echo $fila5["cirugias"] ?>">

            <label for="">Traumatismos</label>
            <input type="text" name="traumatismos" value="<?php echo $fila5["traumatismos"] ?>">

            <label for="">Fracturas</label>
            <input type="text" name="fracturas" value="<?php echo $fila5["fracturas"] ?>">

            <label for="">Luxaciones</label>
            <input type="text" name="luxaciones" value="<?php echo $fila5["luxaciones"] ?>">

            <label for="">Alergias</label>
            <input type="text" name="alergias" value="<?php echo $fila5["alergias"] ?>">

            <label for="">Agudeza Visual</label>
            <input type="text" name="agudezaVisual" value="<?php echo $fila5["agudezaVisual"] ?>">

            <label for="">Licencia Indica Uso de Lentes</label>
            <input type="text" name="licenciaLentes" value="<?php echo $fila5["licenciaLentes"] ?>">

            <label for="">Riesgo para la Salub</label>
            <input type="text" name="riesgoSalub" value="<?php echo $fila5["riesgoSalub"] ?>">

            <label for="">¿Envio al Optometrista?</label>
            <input type="text" name="envioOpto" value="<?php echo $fila5["envioOpto"] ?>">

            <label for="">¿Usa Lentes Graduadios?</label>
            <input type="text" name="lentGraduadios" value="<?php echo $fila5["lentGraduadios"] ?>">

            <label for="">Perimetro Abdominal</label>
            <input type="text" name="perAbdominal" value="<?php echo $fila5["perAbdominal"] ?>">

            <label for="">Examenes de Laboratorio</label>
            <input type="text" name="examLab" value="<?php echo $fila5["examLab"] ?>">

            <label for="">Tipo de Sangre</label>
            <input type="text" name="tipoSangre" value="<?php echo $fila5["tipoSangre"] ?>">

            <label for="">Glucosa Capilar</label>
            <input type="text" name="glucosaCapilar" value="<?php echo $fila5["glucosaCapilar"] ?>">

            <label for="">I.R.A.S</label>
            <input type="text" name="iras" value="<?php echo $fila5["iras"] ?>">

            <label for="">Porcentaje de Oxigeno</label>
            <input type="text" name="porcentajeOxigeno" value="<?php echo $fila5["porcentajeOxigeno"] ?>">

            <label for="">Prueva Aplicada</label>
            <input type="text" name="pruevaAplicada" value="<?php echo $fila5["pruevaAplicada"] ?>">

            <label for="">Fecha Aplicacion</label>
            <input type="date" name="FechaAplicacion" value="<?php echo $fila5["FechaAplicacion"] ?>">
            
            <label for="">Hora Aplicacion</label>
            <input type="time" name="horaAplicacion" value="<?php echo $fila5["horaAplicacion"] ?>">

            <label for="">Resultado</label>
            <input type="text" name="resultado" value="<?php echo $fila5["resultado"] ?>">

            <label for="">Diagnostico</label>
            <input type="text" name="diagnostico" value="<?php echo $fila5["diagnostico"] ?>">
            
            <label for="">Indicaciones Finales</label>
            <input type="text" name="indicacionesFinales" value="<?php echo $fila5["indicacionesFinales"] ?>">
            
            <!-- <input type="submit" name="enviar" value="editarConsulta" class="btn btn-primary" /> -->
            <button type="submit" name="editar" class="btn">Guardar cambios</button>
        </form>
    </body>
</html>