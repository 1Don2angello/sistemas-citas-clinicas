<?php
include('../../configDBsqlserver.php'); //Conexión a la base de datos

$id = $_GET['id']; //Variable enviada desde la página consultas.php
// Asegúrate de que $id sea un número
//$id = intval($id);

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
?>

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
    <link rel="stylesheet" href="../../estilos/panel_control.css" />
    <script src="../../javascript/panel_dashboard_doctor.js"></script>
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
                <h1></h1>

                <table class="table">
                    <form action="editarConsulta.php" method="POST"><button type="submit" name="editar" class="btn btn-primary">Guardar</button>
                        <input type="hidden" name="id" value="<?php echo $fila5["id"] ?>" />
                        <div>
                            <tr>
                                <th colspan="1" for="" class="clave">Clave</th>
                                <th><input class="sinborde" type="text" name="clave" value="<?php echo $fila5["clave"] ?>"></th>
                                <th colspan="1" class="nombre">Nombre</th>
                                <th colspan="1"><input type="text" class="sinborde" name="nombre" value="<?php echo $fila5["nombre"] ?>" style="width: 500px;"></th>
                            </tr>
                            <!-- separador -->
                            <tr>
                                <td class="edad">Edad</td>
                                <td><input type="text" class="edad" name="edad" value="<?php echo $fila5["edad"] ?>"></td>
                                <td class="sexo">Sexo</td>
                                <td>
                                    <select name="sexo" id="sexo" value="<?php echo $fila5["sexo"] ?>">
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="tensArt">Tens.Art.</td>
                                <td><input type="text" class="tensArt" name="tensArt" value="<?php echo $fila5["tensArt"] ?>"></td>
                                <td class="frCard">Fr.Card</td>
                                <td><input type="text" class="frCard" name="frCard" value="<?php echo $fila5["frCard"] ?>"></td>
                            </tr>
                            <!-- separador -->
                            <tr>
                                <td class="imc">I.M.C</td>
                                <td><input type="text" class="imc" name="imc" value="<?php echo $fila5["imc"] ?>"></td>
                                <td class="hora">HORA <input class="sinborde" type="time" name="hora" value="<?php echo $fila5["hora"] ?>"></td>
                                <th class="fecha">Fecha <input type="date" class="fecha" name="fecha" value="<?php echo $fila5["fecha"] ?>"></th>
                            </tr>
                            <!-- /div -->
                            <!-- separador -->

                            <!-- <div> <td colspan="11" style="height:5px" class="separador"> </td> </div> -->
                            <!-- se agraga div y div -->
                            <tr>
                                <td class="peso">Peso</td>
                                <td><input type="text" class="peso" name="peso" value="<?php echo $fila5["peso"] ?>"></td>
                                <td class="talla">Talla</td>
                                <td><input type="text" class="talla" name="talla" value="<?php echo $fila5["talla"] ?>"></td>

                            </tr>
                            <tr>
                                <td class="edoCivil">Edo.Civil</td>
                                <td><input type="text" class="edoCivil" name="edoCivil" value="<?php echo $fila5["edoCivil"] ?>"></td>
                                <td class="frResp">Frecuencia Respiratoria</td>
                                <td><input type="text" class="frResp" name="frResp" value="" <?php echo $fila5["frResp"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="temp">Temp.</td>
                                <td><input type="text" class="temp" name="temp" value="<?php echo $fila5["temp"] ?>"></td>

                                <td colspan="1" class="ahf">A.H.F.</td>
                                <td colspan="10"><input type="text" class="ahf" name="ahf" value="<?php echo $fila5["ahf"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="apnp">A.P.N.P</td>
                                <td colspan="1"><input type="text" class="apnp" name="apnp" value="<?php echo $fila5["apnp"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="app">A.P.P</td>
                                <td colspan="1"><input type="text" class="app" name="app" value="<?php echo $fila5["app"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="pActual">P.Actual</td>
                                <td colspan="1"><input type="text" class="pActual" name="pActual" value="<?php echo $fila5["pActual"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="eFisica">eFisica</td>
                                <td colspan="1"><input type="text" class="eFisica" name="eFisica" value="<?php echo $fila5["eFisica"] ?>"></td>
                            </tr>
                            <!-- div -->
                            <!-- <div>
                                <td colspan="11" style="height:5px" class="separador">
                                    //separador
                                </td>
                            </div> -->
                            <tr>
                                <td colspan="1" class="fechaN">Fecha de Nacimiento</td>
                                <td colspan="1"><input type="date" class="fechaN" name="fechaN" value="<?php echo $fila5["fechaN"] ?>"></td>
                                <td colspan="1" class="escolaridad">Escolaridad</td>
                                <td colspan="1"><input type="text" class="escolaridad" name="escolaridad" value="<?php echo $fila5["escolaridad"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="puestoS">Puesto Solicitado</td>
                                <td colspan="1"><input type="text" class="puestoS" name="puestoS" value="<?php echo $fila5["puestoS"] ?>"></td>
                                <td colspan="1" class="lugarOrigen">Lugar de Origen</td>
                                <td colspan="1"><input type="text" class="lugarOrigen" name="lugarOrigen" value="<?php echo $fila5["lugarOrigen"] ?>"></td>
                            </tr>
                            <!-- <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            separador
                        </td>
                    </div> -->
                            <tr>
                                <td colspan="1" class="analisisCovid">Analisis Covid</td>
                                <td colspan="1"><input type="text" class="analisisCovid" name="analisisCovid" value="<?php echo $fila5["analisisCovid"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="indicaciones">Indicaciones</td>
                                <td colspan="1"><input type="text" class="indicaciones" name="indicaciones" value="<?php echo $fila5["indicaciones"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="visitarUFM">Visitar UFM</td>
                                <td><input type="text" class="visitarUFM" name="visitarUFM" value="<?php echo $fila5["visitarUFM"] ?>"></td>
                                <td colspan="1" class="observaciones">Observaciones</td>
                                <td colspan="1"><input type="text" class="observaciones" name="observaciones" value="<?php echo $fila5["observaciones"] ?>"></td>
                            </tr>
                            <!-- <div>
                                <td colspan="11" style="height:5px" class="separador">
                                  
                                </td>
                            </div> -->
                            <tr>
                                <td class="cirugias">Cirugias</td>
                                <td colspan="1"><input type="text" class="cirugias" name="cirugias" value="<?php echo $fila5["cirugias"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="traumatismos">Traumatismos</td>
                                <td colspan="1"><input type="text" class="traumatismos" name="traumatismos" value="<?php echo $fila5["traumatismos"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="fracturas">Fracturas</td>
                                <td colspan="1"><input type="text" class="fracturas" name="fracturas" value="<?php echo $fila5["fracturas"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="luxaciones">Luxaciones</td>
                                <td colspan="1"><input type="text" class="luxaciones" name="luxaciones" value="<?php echo $fila5["luxaciones"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="alergias">Alergias</td>
                                <td colspan="1"><input type="text" class="alergias" name="alergias" value="<?php echo $fila5["alergias"] ?>"></td>
                            </tr>
                            <!--  <div>
                                <td colspan="11" style="height:5px" class="separador">
                                   separador
                                </td>
                            </div> -->
                            <tr>
                                <td colspan="1" class="agudezaVisual">Agudeza Visual</td>
                                <td colspan="1"><input type="text" class="agudezaVisual" name="agudezaVisual" value="<?php echo $fila5["agudezaVisual"] ?>"></td>
                                <td colspan="1" class="envioOpto">¿Envio al Optometrista?</td>
                                <td colspan="1"><input type="text" class="envioOpto" name="envioOpto" value="<?php echo $fila5["envioOpto"] ?>"></td>

                            </tr>
                            <tr>
                                <td colspan="1" class="examLab">Examenes de Laboratorio</td>
                                <td colspan="1"><input type="text" class="examLab" name="examLab" value="<?php echo $fila5["examLab"] ?>"></td>
                                <td colspan="1" class="licenciaLentes">Licencia Indica Uso de Lentes</td>
                                <td colspan="1"><input type="text" class="licenciaLentes" name="licenciaLentes" value="<?php echo $fila5["licenciaLentes"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="lentGraduadios">¿Usa Lentes Graduadios?</td>
                                <td colspan="1"><input type="text" class="lentGraduadios" name="lentGraduadios" value="<?php echo $fila5["lentGraduadios"] ?>"></td>
                                <td colspan="1" class="lentGraduadios">Tipo de Sangre</td>
                                <td colspan="1"><input type="text" class="lentGraduadios" name="tipoSangre" value="<?php echo $fila5["tipoSangre"] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="1" class="riesgoSalub">Riesgo para la Salub</td>
                                <td colspan="1"><input type="text" class="riesgoSalub" name="riesgoSalub" value="<?php echo $fila5["riesgoSalub"] ?>"></td>
                                <td colspan="1" class="perAbdominal">Perimetro Abdominal</td>
                                <td colspan="1"><input type="text" class="perAbdominal" name="perAbdominal" value="<?php echo $fila5["perAbdominal"] ?>"></td>
                            </tr>
                            <!-- <div>
                                <td colspan="11" style="height:5px" class="separador">
                                  separador
                                </td>
                            </div> -->
                            <tr>
                                <td colspan="1" class="glucosaCapilar">Glucosa Capilar</td>
                                <td colspan="1"><input type="text" class="glucosaCapilar" name="glucosaCapilar" value="<?php echo $fila5["glucosaCapilar"] ?>"></td>
                                <td colspan="1" class="iras">I.R.A.S</td>
                                <td colspan="1"><input type="text" class="iras" name="iras" value="<?php echo $fila5["iras"] ?>"></td>
                            </tr>
                            <!-- <div>
                                <td colspan="11" style="height:5px" class="separador">
                                   separador
                                </td>
                            </div> -->
                            <tr>
                                <td colspan="1" class="porcentajeOxigeno">Porcentaje de Oxigeno</td>
                                <td colspan="1"><input type="text" class="porcentajeOxigeno" name="porcentajeOxigeno" value="<?php echo $fila5["porcentajeOxigeno"] ?>"></td>
                                <td class="pruevaAplicada">Prueva Aplicada</td>
                                <td><input type="text" class="pruevaAplicada" name="pruevaAplicada" value="<?php echo $fila5["pruevaAplicada"] ?>"></td>
                            </tr>
                            <tr>

                                <td class="FechaAplicacion">Fecha Aplicacion</td>
                                <td><input type="date" class="FechaAplicacion" name="FechaAplicacion" value="<?php echo $fila5["FechaAplicacion"] ?>"></td>
                                <td class="horaAplicacion">Hora Aplicacion</td>
                                <td><input type="time" class="horaAplicacion" name="horaAplicacion" value="<?php echo $fila5["horaAplicacion"] ?>"></td>
                                
                            </tr>
                            <tr>
                                <td class="resultado">Resultado</td>
                                <td><input type="text" class="resultado" name="resultado" value="<?php echo $fila5["resultado"] ?>"></td>
                                <td class="diagnostico">Diagnostico</td>
                                <td><input type="text" class="diagnostico" name="diagnostico" value="<?php echo $fila5["diagnostico"] ?>"></td>
                            </tr>
                            <tr>
                                <td class="indicacionesFinales">Indicaciones Finales</td>
                                <td><input type="text" name="indicacionesFinales" value="<?php echo $fila5["indicacionesFinales"] ?>"></td>
                            </tr>


                        </div>


                    </form>
                </table>
            </div>
        </div>


    </section>

</body>

</html>