<?php
     define('BD_SERVER', 'localhost');
     define('DB_USER','root');
     define('DB_PASS','');
     define('DB_NAME','AutocarV4');
     
     $conn = mysqli_connect(BD_SERVER, DB_USER, DB_PASS, DB_NAME);
     
     if(!$conn) {
          echo 'Conexión fallida';
     }
     else {
          echo '';
     }
?>