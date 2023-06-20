
<?php
    include('../../configDBsqlserver.php');
    try {
        if (isset($_POST['editar'])) {
            /* inicio de la tabla */
                $id = $_POST['id'];
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
                $aptos = $_POST["aptos"] ;
                $editarConsulta = "UPDATE gestion_citas.pacientes SET clave=?, hora=?, nombre=?, fecha=?, edad=?, peso=?, sexo=?, talla=?, tensArt=?, edoCivil=?, frCard=?, frResp=?, imc=?, temp=?, ahf=?, apnp=?, app=?, pActual=?, eFisica=?, fechaN=?, puestoS=?, escolaridad=?, lugarOrigen=?, analisisCovid=?, indicaciones=?, visitarUFM=?, observaciones=?, cirugias=?, traumatismos=?, fracturas=?, luxaciones=?, alergias=?, agudezaVisual=?, licenciaLentes=?, riesgoSalub=?, envioOpto=?, lentGraduadios=?, perAbdominal=?, examLab=?, tipoSangre=?, glucosaCapilar=?, iras=?, porcentajeOxigeno=?, pruevaAplicada=?, FechaAplicacion=?, horaAplicacion=?, resultado=?, diagnostico=?, indicacionesFinales=?, aptos=? WHERE id=?";

                $stmt = $conn2->prepare($editarConsulta);
                $stmt->bindParam(1, $clave);
                $stmt->bindParam(2, $hora);
                $stmt->bindParam(3, $nombre);
                $stmt->bindParam(4, $fecha);
                $stmt->bindParam(5, $edad);
                $stmt->bindParam(6, $peso);
                $stmt->bindParam(7, $sexo);
                $stmt->bindParam(8, $talla);
                $stmt->bindParam(9, $tensArt);
                $stmt->bindParam(10, $edoCivil);
                $stmt->bindParam(11, $frCard);
                $stmt->bindParam(12, $frResp);
                $stmt->bindParam(13, $imc);
                $stmt->bindParam(14, $temp);
                $stmt->bindParam(15, $ahf);
                $stmt->bindParam(16, $apnp);
                $stmt->bindParam(17, $app);
                $stmt->bindParam(18, $pActual);
                $stmt->bindParam(19, $eFisica);
                $stmt->bindParam(20, $fechaN);
                $stmt->bindParam(21, $puestoS);
                $stmt->bindParam(22, $escolaridad);
                $stmt->bindParam(23, $lugarOrigen);
                $stmt->bindParam(24, $analisisCovid);
                $stmt->bindParam(25, $indicaciones);
                $stmt->bindParam(26, $visitarUFM);
                $stmt->bindParam(27, $observaciones);
                $stmt->bindParam(28, $cirugias);
                $stmt->bindParam(29, $traumatismos);
                $stmt->bindParam(30, $fracturas);
                $stmt->bindParam(31, $luxaciones);
                $stmt->bindParam(32, $alergias);
                $stmt->bindParam(33, $agudezaVisual);
                $stmt->bindParam(34, $licenciaLentes);
                $stmt->bindParam(35, $riesgoSalub);
                $stmt->bindParam(36, $envioOpto);
                $stmt->bindParam(37, $lentGraduadios);
                $stmt->bindParam(38, $perAbdominal);
                $stmt->bindParam(39, $examLab);
                $stmt->bindParam(40, $tipoSangre);
                $stmt->bindParam(41, $glucosaCapilar);
                $stmt->bindParam(42, $iras);
                $stmt->bindParam(43, $porcentajeOxigeno);
                $stmt->bindParam(44, $pruevaAplicada);
                $stmt->bindParam(45, $FechaAplicacion);
                $stmt->bindParam(46, $horaAplicacion);
                $stmt->bindParam(47, $resultado);
                $stmt->bindParam(48, $diagnostico);
                $stmt->bindParam(49, $indicacionesFinales);
                $stmt->bindParam(50, $aptos);
                $stmt->bindParam(51, $id);
                if ($stmt->execute()) {
                    header('location:consultas.php?respuesta=EDICION CORRECTA');
                }
                
        }
    } catch (Exception $e){
        header('location:consultas.php?respuesta=Error Editar '. $e->getMessage());
    }
?>

