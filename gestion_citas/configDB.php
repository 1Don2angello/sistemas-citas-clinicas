<?php
$serverName = 'LAPTOP-GOI9E2B5\SQLEXPRESS';
$connectionOptions = array(
    "Database" => 'gestion_citas',
    "Uid" => 'LAPTOP-GOI9E2B5\MISS',
    "PWD" => ''
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
