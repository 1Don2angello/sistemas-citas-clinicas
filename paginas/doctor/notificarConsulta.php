<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link rel="stylesheet" href="../../plugins/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <script src="../../plugins/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/vendor/components/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.css" />
    <script src="../../plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../estilos/panel_control.css" />

</head>

<body>
    <div id="menu">
    </div>

    <section id="area_trabajo">
        <h2 style="font-weight: bold">Dashboard</h2>
        <hr />
        <br />
        <div class="panel">
            <div class="panel_titulo">
                <h5>Crear Consulta</h5>
            </div>
            <div class="panel_body">
                <section class="">
                    <table class="table">
                        <form action="procesoConsulta.php" method="POST">
                            <button type="submit" name="procesoConsulta" class="btn btn-primary">Guardar jhhhh</button>
                            <input type="hidden" name="id" value="" />
                            <div>
                                <tr>
                                    <th colspan="1" for="" class="clave">Clave</th>
                                    <th><input class="sinborde" type="text" name="clave" value=""></th>
                                    <th colspan="1" class="nombre">Nombre</th>
                                    <th colspan="1"><input type="text" class="sinborde" name="nombre" value="" style="width: 500px;"></th>
                                </tr>

                                <tr>
                                    <td class="edad">Edad</td>
                                    <td><input type="text" class="edad" name="edad" value=""></td>
                                    <td class="sexo">Sexo</td>
                                    <td>
                                        <select name="sexo" id="sexo" value="">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tensArt">Tens.Art.</td>
                                    <td><input type="text" class="tensArt" name="tensArt" value="" ></td>
                                    <td class="frCard">Fr.Card</td>
                                    <td><input type="text" class="frCard" name="frCard" value=""></td>
                                </tr>

                                <tr>
                                    <td class="imc">I.M.C</td>
                                    <td><input type="text" class="imc" name="imc" value=""></td>
                                    <td class="hora">HORA <input class="sinborde" type="time" name="hora" value=""></td>
                                    <th class="fecha">Fecha <input type="date" class="fecha" name="fecha" value=""></th>
                                </tr>
                                <!-- /div -->



                                <!-- se agraga div y div -->
                                <tr>
                                    <td class="peso">Peso</td>
                                    <td><input type="text" class="peso" name="peso" value=""></td>
                                    <td class="talla">Talla</td>
                                    <td><input type="text" class="talla" name="talla" value=""></td>

                                </tr>
                                <tr>
                                    <td class="edoCivil">Edo.Civil</td>
                                    <td><input type="text" class="edoCivil" name="edoCivil" value=""></td>
                                    <td class="frResp">Frecuencia Respiratoria</td>
                                    <td><input type="text" class="frResp" name="frResp" value=""></td>
                                </tr>
                                <tr>
                                    <td class="temp">Temp.</td>
                                    <td><input type="text" class="temp" name="temp" value=""></td>

                                    <td colspan="1" class="ahf">A.H.F.</td>
                                    <td colspan="10"><input type="text" class="ahf" name="ahf" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="apnp">A.P.N.P</td>
                                    <td colspan="1"><input type="text" class="apnp" name="apnp" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="app">A.P.P</td>
                                    <td colspan="1"><input type="text" class="app" name="app" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="pActual">P.Actual</td>
                                    <td colspan="1"><input type="text" class="pActual" name="pActual" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="eFisica">eFisica</td>
                                    <td colspan="1"><input type="text" class="eFisica" name="eFisica" value=""></td>
                                </tr>
                              
                                <tr>
                                    <td colspan="1" class="fechaN">Fecha de Nacimiento</td>
                                    <td colspan="1"><input type="date" class="fechaN" name="fechaN" value=""></td>
                                    <td colspan="1" class="escolaridad">Escolaridad</td>
                                    <td colspan="1"><input type="text" class="escolaridad" name="escolaridad" value="" ></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="puestoS">Puesto Solicitado</td>
                                    <td colspan="1"><input type="text" class="puestoS" name="puestoS" value="" ></td>
                                    <td colspan="1" class="lugarOrigen">Lugar de Origen</td>
                                    <td colspan="1"><input type="text" class="lugarOrigen" name="lugarOrigen" value="" ></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="1" class="analisisCovid">Analisis Covid</td>
                                    <td colspan="1"><input type="text" class="analisisCovid" name="analisisCovid" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="indicaciones">Indicaciones</td>
                                    <td colspan="1"><input type="text" class="indicaciones" name="indicaciones" value="" ></td>
                                </tr>
                                <tr>
                                    <td class="visitarUFM">Visitar UFM</td>
                                    <td><input type="text" class="visitarUFM" name="visitarUFM" value="" itar></td>
                                    <td colspan="1" class="observaciones">Observaciones</td>
                                    <td colspan="1"><input type="text" class="observaciones" name="observaciones" value="" ></td>
                                </tr>
                               
                                <tr>
                                    <td class="cirugias">Cirugias</td>
                                    <td colspan="1"><input type="text" class="cirugias" name="cirugias" value=""></td>
                                </tr>
                                <tr>
                                    <td class="traumatismos">Traumatismos</td>
                                    <td colspan="1"><input type="text" class="traumatismos" name="traumatismos" value="" ></td>
                                </tr>
                                <tr>
                                    <td class="fracturas">Fracturas</td>
                                    <td colspan="1"><input type="text" class="fracturas" name="fracturas" value="" ></td>
                                </tr>
                                <tr>
                                    <td class="luxaciones">Luxaciones</td>
                                    <td colspan="1"><input type="text" class="luxaciones" name="luxaciones" value="" ></td>
                                </tr>
                                <tr>
                                    <td class="alergias">Alergias</td>
                                    <td colspan="1"><input type="text" class="alergias" name="alergias" value="" ></td>
                                </tr>
                               
                                <tr>
                                    <td colspan="1" class="agudezaVisual">Agudeza Visual</td>
                                    <td colspan="1"><input type="text" class="agudezaVisual" name="agudezaVisual" value="" ></td>
                                    <td colspan="1" class="envioOpto">¿Envio al Optometrista?</td>
                                    <td colspan="1"><input type="text" class="envioOpto" name="envioOpto" value=""></td>

                                </tr>
                                <tr>
                                    <td colspan="1" class="examLab">Examenes de Laboratorio</td>
                                    <td colspan="1"><input type="text" class="examLab" name="examLab" value="" ></td>
                                    <td colspan="1" class="licenciaLentes">Licencia Indica Uso de Lentes</td>
                                    <td colspan="1"><input type="text" class="licenciaLentes" name="licenciaLentes" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="lentGraduadios">¿Usa Lentes Graduadios?</td>
                                    <td colspan="1"><input type="text" class="lentGraduadios" name="lentGraduadios" value="" ></td>
                                    <td colspan="1" class="lentGraduadios">Tipo de Sangre</td>
                                    <td colspan="1"><input type="text" class="lentGraduadios" name="tipoSangre" value="" ></td>
                                </tr>
                                <tr>
                                    <td colspan="1" class="riesgoSalub">Riesgo para la Salub</td>
                                    <td colspan="1"><input type="text" class="riesgoSalub" name="riesgoSalub" value=""></td>
                                    <td colspan="1" class="perAbdominal">Perimetro Abdominal</td>
                                    <td colspan="1"><input type="text" class="perAbdominal" name="perAbdominal" value="" ></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="1" class="glucosaCapilar">Glucosa Capilar</td>
                                    <td colspan="1"><input type="text" class="glucosaCapilar" name="glucosaCapilar" value="" ></td>
                                    <td colspan="1" class="iras">I.R.A.S</td>
                                    <td colspan="1"><input type="text" class="iras" name="iras" value=""></td>
                                </tr>
                              
                                <tr>
                                    <td colspan="1" class="porcentajeOxigeno">Porcentaje de Oxigeno</td>
                                    <td colspan="1"><input type="text" class="porcentajeOxigeno" name="porcentajeOxigeno" value="" ></td>
                                    <td class="pruevaAplicada">Prueva Aplicada</td>
                                    <td><input type="text" class="pruevaAplicada" name="pruevaAplicada" value="" ></td>
                                </tr>
                                <tr>

                                    <td class="FechaAplicacion">Fecha Aplicacion</td>
                                    <td><input type="date" class="FechaAplicacion" name="FechaAplicacion" value="" ></td>
                                    <td class="horaAplicacion">Hora Aplicacion</td>
                                    <td><input type="time" class="horaAplicacion" name="horaAplicacion" value=""></td>

                                </tr>
                                <tr>
                                    <td class="resultado">Resultado</td>
                                    <td><input type="text" class="resultado" name="resultado" value="" ></td>
                                    <td class="diagnostico">Diagnostico</td>
                                    <td><input type="text" class="diagnostico" name="diagnostico" value="" ></td>
                                </tr>
                                <tr>
                                    <td class="indicacionesFinales">Indicaciones Finales</td>
                                    <td><input type="text" name="indicacionesFinales" value="" ></td>
                                </tr>


                            </div>


                        </form>
                    </table>
                </section>
            </div>
        </div>

    </section>
    <div id="footer_nav"></div>



    <script src="../../javascript/panel_dashboard_dc.js"></script>
</body>

</html>
<!-- La tesis no va llevar diagranabdb UML -->
<!--  -->