<?php

/*IMPORTANTE, PARA QUE FUNCIONE EL ENVIO DE CORREO
  - SE DEBE ACTIVAR LA OPCION "ACCESO A APLICACIONES MENOS SEGURAS DE GOOGLE"
  - SE DEBE DESACTIVAR EL CAPTCHA DE ACCESO: https://accounts.google.com/DisplayUnlockCaptcha
*/




//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../plugins/vendor/autoload.php';


$correo_origen = $_POST['correo_origen'];
$clave = $_POST['clave'];
$correo_destino = $_POST['correo_destino'];
$asunto = $_POST['asunto'];
$mensaje_html = $_POST['mensaje_html'];
$imagen = $_POST['imagen'];



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $correo_origen;                     //SMTP username
    $mail->Password   = $clave;                               //SMTP password
    //$mail->SMTPSecure = 'TLS';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($correo_origen, 'Sistema getión de citas');
    $mail->addAddress($correo_destino);//Add a recipient        

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments    

    if($imagen!=""){    
        $mail ->AddEmbeddedImage($imagen,"logo_nn");
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $mensaje_html;    

    $mail->send();


    echo "{\"mensaje\":\"correcto\"}";

} catch (Exception $e) {

    echo "{\"mensaje\":\"error: ".$mail->ErrorInfo."\"}";    
}

?>