<?php
session_start();
require_once 'conexion.php';

// Si no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("SELECT * FROM test WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$usuario_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

$ha_realizado_test = false;
if ($usuario_encontrado) {
    if (!empty($usuario_encontrado['puntaje']) || !empty($usuario_encontrado['situacion'])) {
        $ha_realizado_test = true;
    }
}

// Controlar si se activó la sección de mantenimiento en la misma página mediante la URL (?mantenimiento=1)
$mostrar_mantenimiento = isset($_GET['mantenimiento']) && $_GET['mantenimiento'] == '1';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal - Test Psicológico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Test Psicológico</h1>
        
        <div class="user-info">
            <p>Bienvenido, <strong><?php echo htmlspecialchars($usuario_encontrado['nombre']); ?></strong></p>
            <p>Estado del test: <strong><?php echo $ha_realizado_test ? 'Realizado' : 'Pendiente'; ?></strong></p>
            <p><a href="login.php" style="color: #81a1c1; text-decoration: none; font-size: 18px;">Cerrar Sesión</a></p>
        </div>

        <!-- Menú de Opciones Principal -->
        <ul class="menu">
            <?php if ($ha_realizado_test): ?>
                <!-- Al hacer clic aquí, recarga la misma página mostrando el panel de mantenimiento abajo -->
                <li><a href="index.php?mantenimiento=1">1. Mantenimiento (Opciones de BD)</a></li>
                <li><a href="test_psicologico.php?id=<?php echo $usuario_encontrado['id_usuario']; ?>">2 / 4. Test Psicológico (Volver a realizar)</a></li>
                <li><a href="Listar.php">3. Reporte / Listar Registros</a></li>
            <?php else: ?>
                <li class="disabled">1. Mantenimiento (Bloqueado: Debe realizar el test primero)</li>
                <li><a href="test_psicologico.php?id=<?php echo $usuario_encontrado['id_usuario']; ?>">2 / 4. Realizar Test Psicológico</a></li>
                <li class="disabled">3. Reporte (Bloqueado)</li>
            <?php endif; ?>
        </ul>
        
        <!-- Panel de Mantenimiento integrado directamente aquí mismo -->
        <?php if ($ha_realizado_test && $mostrar_mantenimiento): ?>
            <div style="margin-top: 25px; border-top: 2px dashed #4a6572; padding-top: 15px;">
                <p style="font-weight: bold; font-size: 22px; margin-bottom: 12px;">Panel de Mantenimiento:</p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="agregar.php" style="background-color: #2ecc71; color: #000000; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Agregar</a>
                    <a href="Buscar.php" style="background-color: #f1c40f; color: #000000; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Buscar</a>
                    <a href="Listar.php" style="background-color: #3498db; color: #000000; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Listar</a>
                    <a href="modificar.php" style="background-color: #e67e22; color: #000000; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Modificar</a>
                    <a href="eliminar.php" style="background-color: #e74c3c; color: #000000; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">Eliminar</a>
                </div>
                <p style="margin-top: 15px;"><a href="index.php">Ocultar Panel de Mantenimiento</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
