<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <section>
            <table class="table">
                <form action="procesoConsulta.php" method="post">
                    <input type="hidden" name="id" value="">
                    <div>
                        <tr>
                            <th colspan="1" class="clave">Clave</th>
                            <th><input type="text" class="sinborde" name="clave" value=""></th>
                            <th colspan="1" class="nombre">Nombre</th>
                            <th colspan="6"><input type="text" class="sinborde" name="nombre" value="" style="width: 500px;"></th>
                            <th class="fecha">Fecha</th>
                            <th><input type="date" class="fecha" name="fecha" value=""></th>
                        </tr> 
                        <tr>
                            <td class="edad">Edad</td>
                            <td><input type="text" class="edad" name="edad" value=""></td>
                            <td class="sexo">Sexo</td>
                                <td><select name="sexo" id="sexo">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    </select>
                                </td>
                            <td class="tensArt">Tens.Art.</td>
                            <td><input type="text" class="tensArt" name="tensArt" value=""></td>
                            <td class="frCard">Fr.Card</td>
                            <td><input type="text" class="frCard" name="frCard" value=""></td>
                            <td class="imc">I.M.C</td>
                            <td><input type="text" class="imc" name="imc" value=""></td>
                            <td class="hora">Hora</td>
                        </tr>
                        <tr>
                            <td class="peso">Peso</td>
                            <td><input type="text" class="peso" name="peso" value=""></td>
                            <td class="talla">Talla</td>
                            <td><input type="text" class="talla" name="talla" value=""></td>
                            <td class="edoCivil">Edo.Civil</td>
                            <td><input type="text" class="edoCivil" name="edoCivil" value=""></td>
                            <td class="frResp">FrResp</td>
                            <td><input type="text" class="frResp" name="frResp" value=""></td>
                            <td class="temp">Temp.</td>
                            <td><input type="text" class="temp" name="temp" value=""></td>
                            <!-- imput para la hora -->
                            <td><input type="time" class="hora" name="hora" value=""></td>
                        </tr>
                    </div>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            
                        </td>
                    </div>
                    <div>
                        <tr>
                            <td colspan="1" class="ahf">A.H.F.</td>
                            <td colspan="10"><input type="text" class="ahf" name="ahf" value=""></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="apnp">A.P.N.P</td>
                            <td colspan="10"><input type="text" class="apnp" name="apnp" value=""></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="app">A.P.P</td>
                            <td colspan="10"><input type="text" class="app" name="app" value=""></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="pActual">P.Actual</td>
                            <td colspan="10"><input type="text" class="pActual" name="pActual" value=""></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="eFisica">eFisica</td>
                            <td colspan="10"><input type="text" class="eFisica" name="eFisica" value=""></td>
                        </tr>
                    </div>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            <!--  -->
                        </td>
                    </div>
                    <tr>
                        <td colspan="2" class="fechaN">Fecha de Nacimiento</td>
                        <td colspan="5"><input type="date" class="fechaN" name="fechaN" value=""></td>
                        <td colspan="2" class="escolaridad">Escolaridad</td>
                        <td colspan="5"><input type="text" class="escolaridad" name="escolaridad" value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="puestoS">Puesto Solicitado</td>
                        <td colspan="5"><input type="text" class="puestoS"name="puestoS" value=""></td>
                        <td colspan="2" class="lugarOrigen">Lugar de Origen</td>
                        <td colspan="5"><input type="text" class="lugarOrigen" name="lugarOrigen" value=""></td>
                    </tr>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            
                        </td>
                    </div>
                    <tr>
                        <td colspan="2" class="analisisCovid">Analisis Covid</td>
                        <td colspan="9"><input type="text" class="analisisCovid" name="analisisCovid" value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="indicaciones">Indicaciones</td>
                        <td colspan="9"><input type="text" class="indicaciones" name="indicaciones" value=""></td>
                    </tr>
                    <tr>
                        <td class="visitarUFM">Visitar UFM</td>
                        <td><input type="text" class="visitarUFM" name="visitarUFM" value=""></td>
                        <td colspan="1" class="observaciones">Observaciones</td>
                        <td colspan="8"><input type="text" class="observaciones" name="observaciones" value=""></td>
                    </tr>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            <!--  -->
                        </td>
                    </div>
                    <tr>
                        <td class="cirugias">Cirugias</td>
                        <td colspan="10"><input type="text" class="cirugias" name="cirugias" value=""></td>
                    </tr>
                    <tr>
                        <td class="traumatismos">Traumatismos</td>
                        <td colspan="10"><input type="text" class="traumatismos" name="traumatismos" value=""></td>
                    </tr>
                    <tr>
                        <td class="fracturas">Fracturas</td>
                        <td colspan="10"><input type="text" class="fracturas"name="fracturas" value=""></td>
                    </tr>
                    <tr>
                        <td class="luxaciones">Luxaciones</td>
                        <td colspan="10"><input type="text" class="luxaciones" name="luxaciones" value=""></td>
                    </tr>
                    <tr>
                        <td class="alergias">Alergias</td>
                        <td colspan="10"><input type="text" class="alergias" name="alergias" value=""></td>
                    </tr>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            <!--  -->
                        </td>
                    </div>
                    <tr>
                        <td colspan="2" class="agudezaVisual">Agudeza Visual</td>
                        <td colspan="2"><input type="text" class="agudezaVisual" name="agudezaVisual" value=""></td>
                        <td colspan="2" class="envioOpto">¿Envio al Optometrista?</td>
                        <td colspan="2"><input type="text" class="envioOpto" name="envioOpto" value=""></td>
                        <td colspan="2" class="examLab">Examenes de Laboratorio</td>
                        <td colspan="2"><input type="text" class="examLab" name="examLab" value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="licenciaLentes">Licencia Indica Uso de Lentes</td>
                        <td colspan="2"><input type="text" class="licenciaLentes" name="licenciaLentes" value=""></td>
                        <td colspan="2" class="lentGraduadios">¿Usa Lentes Graduadios?</td>
                        <td colspan="2"><input type="text" class="lentGraduadios" name="lentGraduadios" value=""></td>
                        <td colspan="2" class="lentGraduadios">Tipo de Sangre</td>
                        <td colspan="2"><input type="text" class="lentGraduadios" name="tipoSangre" value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="riesgoSalub">Riesgo para la Salub</td>
                        <td colspan="2"><input type="text" class="riesgoSalub" name="riesgoSalub" value=""></td>
                        <td colspan="2" class="perAbdominal">Perimetro Abdominal</td>
                        <td colspan="2"><input type="text" class="perAbdominal" name="perAbdominal" value=""></td>
                        <td colspan="2" class="glucosaCapilar">Glucosa Capilar</td>
                        <td colspan="2"><input type="text" class="glucosaCapilar" name="glucosaCapilar" value=""></td>
                    </tr>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            <!--  -->
                        </td>
                    </div>
                    <tr>
                        <td colspan="2" class="iras">I.R.A.S</td>
                        <td colspan="9"><input type="text" class="iras" name="iras" value=""></td>
                    </tr>
                    <div>
                        <td colspan="11" style="height:5px" class="separador"> 
                            <!--  -->
                        </td>
                    </div>
                    <tr>
                        <td colspan="2" class="porcentajeOxigeno">Porcentaje de Oxigeno</td>
                        <td colspan="9"><input type="text" class="porcentajeOxigeno" name="porcentajeOxigeno" value=""></td>
                    </tr>
                    <tr>
                        <td class="pruevaAplicada">Prueva Aplicada</td>
                        <td><input type="text" class="pruevaAplicada" name="pruevaAplicada" value=""></td>
                        <td class="FechaAplicacion">Fecha Aplicacion</td>
                        <td><input type="date" class="FechaAplicacion" name="FechaAplicacion" value=""></td>
                        <td class="horaAplicacion">Hora Aplicacion</td>
                        <td><input type="time" class="horaAplicacion" name="horaAplicacion" value=""></td>
                        <td class="resultado">Resultado</td>
                        <td><input type="text" class="resultado" name="resultado" value=""></td>
                    </tr>
                    <tr>
                        <td class="diagnostico">Diagnostico</td>
                        <td><input type="text" class="diagnostico" name="diagnostico" value=""></td>
                    </tr>
                    <tr>
                        <td class="indicacionesFinales">Indicaciones Finales</td>
                        <td><input type="text" name="indicacionesFinales" value=""></td>
                    </tr>
                    <button type="submit" name="procesoConsulta" class="btn">Crear Consulta</button>
                </form>
            </table>
        </section>
    </body>
</html>
<!-- La tesis no va llevar diagranabdb UML -->
<!--  -->