<?php
include("../../configDBsqlserver.php");
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

       // Resto de las variables...
        $aptos = $_POST["aptos"] ;
       $query3 = "INSERT INTO gestion_citas.pacientes (clave, hora, nombre, fecha, edad, peso, sexo, talla, tensArt, edoCivil, frCard, frResp, imc, temp, ahf, apnp, app, pActual, eFisica, fechaN, puestoS, escolaridad, lugarOrigen, analisisCovid, indicaciones, visitarUFM, observaciones, cirugias, traumatismos, fracturas, luxaciones, alergias, agudezaVisual, licenciaLentes, riesgoSalub, envioOpto, lentGraduadios, perAbdominal, examLab, tipoSangre, glucosaCapilar, iras, porcentajeOxigeno, pruevaAplicada, FechaAplicacion, horaAplicacion, resultado, diagnostico, indicacionesFinales, aptos) 
       VALUES (:clave, :hora, :nombre, :fecha, :edad, :peso, :sexo, :talla, :tensArt, :edoCivil, :frCard, :frResp, :imc, :temp, :ahf, :apnp, :app, :pActual, :eFisica, :fechaN, :puestoS, :escolaridad, :lugarOrigen, :analisisCovid, :indicaciones, :visitarUFM, :observaciones, :cirugias, :traumatismos, :fracturas, :luxaciones, :alergias, :agudezaVisual, :licenciaLentes, :riesgoSalub, :envioOpto, :lentGraduadios, :perAbdominal, :examLab, :tipoSangre, :glucosaCapilar, :iras, :porcentajeOxigeno, :pruevaAplicada, :FechaAplicacion, :horaAplicacion, :resultado, :diagnostico, :indicacionesFinales, :aptos )";

$stmt = $conn2->prepare($query3);
$stmt->bindParam(':clave', $clave);
$stmt->bindParam(':hora', $hora);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':edad', $edad);
$stmt->bindParam(':peso', $peso);
$stmt->bindParam(':sexo', $sexo);
$stmt->bindParam(':talla', $talla);
$stmt->bindParam(':tensArt', $tensArt);
$stmt->bindParam(':edoCivil', $edoCivil);
$stmt->bindParam(':frCard', $frCard);
$stmt->bindParam(':frResp', $frResp);
$stmt->bindParam(':imc', $imc);
$stmt->bindParam(':temp', $temp);
$stmt->bindParam(':ahf', $ahf);
$stmt->bindParam(':apnp', $apnp);
$stmt->bindParam(':app', $app);
$stmt->bindParam(':pActual', $pActual);
$stmt->bindParam(':eFisica', $eFisica);
$stmt->bindParam(':fechaN', $fechaN);
$stmt->bindParam(':puestoS', $puestoS);
$stmt->bindParam(':escolaridad', $escolaridad);
$stmt->bindParam(':lugarOrigen', $lugarOrigen);
$stmt->bindParam(':analisisCovid', $analisisCovid);
$stmt->bindParam(':indicaciones', $indicaciones);
$stmt->bindParam(':visitarUFM', $visitarUFM);
$stmt->bindParam(':observaciones', $observaciones);
$stmt->bindParam(':cirugias', $cirugias);
$stmt->bindParam(':traumatismos', $traumatismos);
$stmt->bindParam(':fracturas', $fracturas);
$stmt->bindParam(':luxaciones', $luxaciones);
$stmt->bindParam(':alergias', $alergias);
$stmt->bindParam(':agudezaVisual', $agudezaVisual);
$stmt->bindParam(':licenciaLentes', $licenciaLentes);
$stmt->bindParam(':riesgoSalub', $riesgoSalub);
$stmt->bindParam(':envioOpto', $envioOpto);
$stmt->bindParam(':lentGraduadios', $lentGraduadios);
$stmt->bindParam(':perAbdominal', $perAbdominal);
$stmt->bindParam(':examLab', $examLab);
$stmt->bindParam(':tipoSangre', $tipoSangre);
$stmt->bindParam(':glucosaCapilar', $glucosaCapilar);
$stmt->bindParam(':iras', $iras);
$stmt->bindParam(':porcentajeOxigeno', $porcentajeOxigeno);
$stmt->bindParam(':pruevaAplicada', $pruevaAplicada);
$stmt->bindParam(':FechaAplicacion', $FechaAplicacion);
$stmt->bindParam(':horaAplicacion', $horaAplicacion);
$stmt->bindParam(':resultado', $resultado);
$stmt->bindParam(':diagnostico', $diagnostico);
$stmt->bindParam(':indicacionesFinales', $indicacionesFinales);
//varios datos 
$stmt->bindParam(':aptos', $aptos);
if ($stmt->execute()) {
   header('location:consultas.php?respuesta=La consulta fue AGREGADA correctamente');
}
}
} catch (Exception $e) {
header('location:consultas.php?respuesta=Error'. $e->getMessage());
}
