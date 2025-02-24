<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "db_clientes";

$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_errno){
    die("conexion fallida" . $conexion->connect_errno);
} else {
    echo "conectado";
}

?>