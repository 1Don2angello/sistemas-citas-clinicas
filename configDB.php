<?php

class BaseDatos
{
    public $conexion;
    public $db;

    public $serverName = "DESKTOP-NQQ25CP";//LAPTOP-GOI9E2B5\SQLEXPRESS
    public $database = "gestion_citas";
    public $username = "sa";
    public $password = "12345678";

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

    public $serverName = "DESKTOP-NQQ25CP";
    public $database = "SisRH";
    public $username = "sa";
    public $password = "12345678";

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


