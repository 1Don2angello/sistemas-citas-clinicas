<?php
    include("conexion.php");
    try {
        if (isset($_POST['procesoConsulta'])) {
            $clave = $_POST["clave"];
            $hora = $_POST["hora"];
            $nombre = $_POST["nombre"];
            $fecha = $_POST["fecha"];
            $edad = $_POST["edad"];
            $peso = $_POST["peso"];
            $sexo = $_POST["sexo"];
            $talla = $_POST["talla"];
            $tensArt = $_POST["tensArt"];
            $edoCivil = $_POST["edoCivil"];
            $frCard = $_POST["frCard"];
            $frResp = $_POST["frResp"];
            $imc = $_POST["imc"];
            $temp = $_POST["temp"];
            $ahf = $_POST["ahf"];
            $apnp = $_POST["apnp"];
            $app = $_POST["app"];
            $pActual = $_POST["pActual"];
            $eFisica = $_POST["eFisica"];
            $fechaN = $_POST["fechaN"];
            $puestoS = $_POST["puestoS"];
            $escolaridad = $_POST["escolaridad"];
            $lugarOrigen = $_POST["lugarOrigen"];
            $analisisCovid = $_POST["analisisCovid"];
            $indicaciones = $_POST["indicaciones"];
            $visitarUFM = $_POST["visitarUFM"];
            $observaciones = $_POST["observaciones"];
            $cirugias = $_POST["cirugias"];
            $traumatismos = $_POST["traumatismos"];
            $fracturas = $_POST["fracturas"];
            $luxaciones = $_POST["luxaciones"];
            $alergias = $_POST["alergias"];
            $agudezaVisual = $_POST["agudezaVisual"];
            $licenciaLentes = $_POST["licenciaLentes"];
            $riesgoSalub = $_POST["riesgoSalub"];
            $envioOpto = $_POST["envioOpto"];
            $lentGraduadios = $_POST["lentGraduadios"];
            $perAbdominal = $_POST["perAbdominal"];
            $examLab = $_POST["examLab"];
            $tipoSangre = $_POST["tipoSangre"];
            $glucosaCapilar = $_POST["glucosaCapilar"];
            $iras = $_POST["iras"];
            $porcentajeOxigeno = $_POST["porcentajeOxigeno"];
            $pruevaAplicada = $_POST["pruevaAplicada"];
            $FechaAplicacion = $_POST["FechaAplicacion"];
            $horaAplicacion = $_POST["horaAplicacion"];
            $resultado = $_POST["resultado"];
            $diagnostico = $_POST["diagnostico"];
            $indicacionesFinales = $_POST["indicacionesFinales"];
            
            $query3="INSERT INTO pacientes (clave, hora, nombre, fecha, edad, peso, sexo, talla, tensArt, edoCivil, frCard, frResp, imc, temp, ahf, apnp, app, pActual, eFisica, fechaN, puestoS, escolaridad, lugarOrigen, analisisCovid, indicaciones, visitarUFM, observaciones, cirugias, traumatismos, fracturas, luxaciones, alergias, agudezaVisual, licenciaLentes, riesgoSalub, envioOpto, lentGraduadios, perAbdominal, examLab, tipoSangre, glucosaCapilar, iras, porcentajeOxigeno, pruevaAplicada, FechaAplicacion, horaAplicacion, resultado, diagnostico, indicacionesFinales) 
                    VALUES ('$clave','$hora','$nombre','$fecha','$edad','$peso','$sexo','$talla','$tensArt','$edoCivil','$frCard','$frResp','$imc','$temp','$ahf','$apnp','$app','$pActual','$eFisica','$fechaN','$puestoS','$escolaridad','$lugarOrigen','$analisisCovid','$indicaciones','$visitarUFM','$observaciones','$cirugias','$traumatismos','$fracturas','$luxaciones','$alergias','$agudezaVisual','$licenciaLentes','$riesgoSalub','$envioOpto','$lentGraduadios','$perAbdominal','$examLab','$tipoSangre','$glucosaCapilar','$iras','$porcentajeOxigeno','$pruevaAplicada','$FechaAplicacion','$horaAplicacion','$resultado','$diagnostico','$indicacionesFinales')";
            $resultado3=mysqli_prepare($conn,$query3);
            
            if(mysqli_stmt_execute($resultado3)){
                header('location:consultas.php?respuesta=La consulta fue AGREGADA correctamente');//echo " Datos Insertados";
            }
        }
    } catch (Exception $e){
        header('location:consultas.php?respuesta=Error'. $e->getMessage());
    }
?>
<!-- phpMySql vercion Maria bd 8.2.4 -->
<!-- Auto car pruevas de encivod y formulario  -->