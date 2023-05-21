<?php

	class BaseDatos
	{		
		public $conexion;
		public $db;

		public $host = "localhost";
		public $user = "root";
		public $password = "";
		public $database = "gestion_citas";
		public $charset = "utf8";

		/*public $host = "127.0.0.1:3306";
		public $user = "u594135835_admin";
		public $password = "Live550e60.";
		public $database = "u594135835_gestion_citas";
		public $charset = "utf8";*/
		

		function __construct(){

			$this->conexion = mysqli_connect($this->host, $this->user, $this->password,$this->database) or die("No se ha podido establecer conexion");
		}

	    public function desconectar($con)
	    {
	        @mysqli_close($con);
	    }
	}
?>
