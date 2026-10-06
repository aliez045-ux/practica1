<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="menu">
    <h1>Menú Principal</h1>
    <ul>
        <li><a class="btn-menu" href="nomina.php">1. Nómina</a></li>
        <li><a class="btn-menu" href="alumnos.php">2. Alumnos</a></li>
        <li><a class="btn-menu" href="refaccionaria.php">3. Refaccionaria</a></li>
    </ul>
    <a class="logout" href="login.php">Cerrar Sesión</a>
</div>

</body>
</html>