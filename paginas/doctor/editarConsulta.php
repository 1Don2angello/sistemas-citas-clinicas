<?php
    include('conexion.php');
    try {
        if (isset($_POST['editar'])) {
            /* inicio de la tabla */
                $id = $_POST['id'];
                $clave = $_POST["clave"];
                $hora = $_POST["hora"];
                $nombre = $_POST["nombre"];
                /* $paterno = $_POST["paterno"];
                $materno = $_POST["materno"]; */
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
            
            $editarConsulta = 
            "UPDATE pacientes 
            SET clave='$clave', hora='$hora', nombre='$nombre',fecha='$fecha', edad='$edad', peso='$peso', sexo='$sexo', 
                talla='$talla', tensArt='$tensArt', edoCivil='$edoCivil', frCard='$frCard', frResp='$frResp', imc='$imc', 
                temp='$temp', ahf='$ahf', apnp='$apnp', app='$app', pActual='$pActual', eFisica='$eFisica', fechaN='$fechaN',
                puestoS='$puestoS', escolaridad='$escolaridad', lugarOrigen='$lugarOrigen', analisisCovid='$analisisCovid', 
                indicaciones='$indicaciones', visitarUFM='$visitarUFM', observaciones='$observaciones', cirugias='$cirugias', 
                traumatismos='$traumatismos', fracturas='$fracturas', luxaciones='$luxaciones', alergias='$alergias',
                agudezaVisual='$agudezaVisual', licenciaLentes='$licenciaLentes', riesgoSalub='$riesgoSalub',
                envioOpto='$envioOpto', lentGraduadios='$lentGraduadios', perAbdominal='$perAbdominal',
                examLab='$examLab', tipoSangre='$tipoSangre', glucosaCapilar='$glucosaCapilar', iras='$iras',
                porcentajeOxigeno='$porcentajeOxigeno', pruevaAplicada='$pruevaAplicada',
                FechaAplicacion='$FechaAplicacion', horaAplicacion='$horaAplicacion', resultado='$resultado',
                diagnostico='$diagnostico', indicacionesFinales='$indicacionesFinales'
            WHERE id='$id'";
            $resultado6 = mysqli_prepare($conn,$editarConsulta);
            
            if(mysqli_stmt_execute($resultado6)){
                header('location:consultas.php?respuesta=EDICION CORRECTA');//echo " Datos Insertados";
            }
        }
    } catch (Exception $e){
        header('location:consultas.php?respuesta=Error Editar '. $e->getMessage());
    }
?>