<?php
$host = "localhost";
$usuario = "root";
$password = "";
$database = "practica3_db";

// Evita que PHP lance una excepción no controlada en PHP 8+
mysqli_report(MYSQLI_REPORT_OFF);

$conexion = @new mysqli($host, $usuario, $password, $database);

if ($conexion->connect_error) {
    die("<div style='font-family:sans-serif; padding:20px; background:#f8d7da; color:#721c24; border:2px solid #f5c6cb;'>
            <strong>Error de conexión:</strong> " . $conexion->connect_error . "<br><br>
            <em>Revisa que el servicio MySQL esté encendido en XAMPP y que la base de datos 'practica3_db' esté creada en phpMyAdmin.</em>
         </div>");
}

$conexion->set_charset("utf8");
?>