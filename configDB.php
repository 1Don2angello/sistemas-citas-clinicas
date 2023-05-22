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

		/*public $host = " ";
		public $user = " ";
		public $password = " ";
		public $database = " ";
		public $charset = " ";*/
		

		function __construct(){

			$this->conexion = mysqli_connect($this->host, $this->user, $this->password,$this->database) or die("No se ha podido establecer conexion");
		}

	    public function desconectar($con)
	    {
	        @mysqli_close($con);
	    }
	}
?>
