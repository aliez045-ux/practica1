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
    <title>Panel de Mantenimiento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Mantenimiento</h1>
        <p style="font-weight: bold; margin-bottom: 20px;">Selecciona la operación que deseas realizar:</p>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 25px;">
            <a href="agregar.php" style="background-color: #2ecc71; color: #000000; padding: 12px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: 'Dancing Script', cursive; font-size: 22px;">Agregar</a>
            <a href="Buscar.php" style="background-color: #f1c40f; color: #000000; padding: 12px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: 'Dancing Script', cursive; font-size: 22px;">Buscar</a>
            <a href="Listar.php" style="background-color: #3498db; color: #000000; padding: 12px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: 'Dancing Script', cursive; font-size: 22px;">Listar</a>
            <a href="modificar.php" style="background-color: #e67e22; color: #000000; padding: 12px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: 'Dancing Script', cursive; font-size: 22px;">Modificar</a>
            <a href="eliminar.php" style="background-color: #e74c3c; color: #000000; padding: 12px 18px; text-decoration: none; border-radius: 5px; font-weight: bold; font-family: 'Dancing Script', cursive; font-size: 22px;">Eliminar</a>
        </div>

        <p><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>