<?php
$host = "localhost";
$user = "root";
$password = ""; 
$database = "bd_animales_marinos";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error en la conexión a la Base de Datos: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
?>