<?php

class BaseDatos
{
    public $conexion;
    public $db;

    public $serverName = "LAPTOP-GOI9E2B5\\SQLEXPRESS";
    public $connectionOptions = array(
        "Database" => "gestion_citas",
        "Uid" => "admin",
        "PWD" => "admin123456789"
    );

    function __construct()
    {
        $this->conexion = sqlsrv_connect($this->serverName, $this->connectionOptions);

        if ($this->conexion === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Conexión exitosa a la base de datos.";
        }
    }

    public function desconectar($con)
    {
        sqlsrv_close($con);
    }
}

// Crear una instancia de la clase BaseDatos
$db_context = new BaseDatos();

