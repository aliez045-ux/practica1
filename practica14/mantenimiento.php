<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimiento - Sistema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Mantenimiento</h1>
        <p>Selecciona la operación que deseas realizar en la base de datos:</p>
        
        <ul class="menu">
            <li><a href="agregar.php">Agregar Usuario</a></li>
            <li><a href="Buscar.php">Buscar Usuario</a></li>
            <li><a href="Listar.php">Listar Usuarios</a></li>
            <li><a href="modificar.php">Modificar Usuario</a></li>
            <li><a href="eliminar.php">Eliminar Usuario</a></li>
        </ul>

        <p><br><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>