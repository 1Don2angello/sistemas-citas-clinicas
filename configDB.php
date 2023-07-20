<?php

class BaseDatos
{
    public $conexion;
    public $db;

    public $serverName = "LAPTOP-GOI9E2B5\SQLEXPRESS";
    public $database = "gestion_citas";
    public $username = "admin";
    public $password = "admin123456789";

    function __construct()
    {
        try {
            $this->conexion = new PDO("sqlsrv:Server=$this->serverName;Database=$this->database", $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a SQL Server: " . $e->getMessage());
        }
    }

    public function desconectar($con)
    {
        $con = null;
    }
}



class BaseDatos2
{
    public $conexion;
    public $db;

    public $serverName = "LAPTOP-GOI9E2B5\\SQLEXPRESS";
    public $database = "gestion_citas";
    public $username = "admin";
    public $password = "admin123456789";

    function __construct()
    {
        try {
            $this->conexion = new PDO("sqlsrv:Server=$this->serverName;Database=$this->database", $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a SQL Server: " . $e->getMessage());
        }
    }

    public function verificarConexion()
    {
        if ($this->conexion) {
            echo "Conexión exitosa a la base de datos.";
        } else {
            echo "Error al conectar a la base de datos.";
        }
    }

    public function desconectar($con)
    {
        $con = null;
    }
}