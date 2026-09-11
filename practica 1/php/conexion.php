<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "practica1_db";

$conexion = @new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("<div style='background:#f4ece1; border:3px solid #1a1a1a; color:#2b2621; padding:20px; text-align:center; font-family:serif; margin:20px;'>
            <h2 style='color:#8b0000;'>[ Error de Conexión ]</h2>
            <p>No se pudo conectar a la base de datos <strong>practica1_db</strong>.</p>
            <p><small>" . $conexion->connect_error . "</small></p>
         </div>");
}

$conexion->set_charset("utf8mb4");
?>