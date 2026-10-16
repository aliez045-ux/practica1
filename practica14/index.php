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
        
        <!-- Información del usuario, estado y cerrar sesión -->
        <div class="user-info">
            <p>Bienvenido, <strong><?php echo htmlspecialchars($usuario_encontrado['nombre']); ?></strong></p>
            <p>Estado del test: <strong><?php echo $ha_realizado_test ? 'Realizado' : 'Pendiente'; ?></strong></p>
            <p><a href="login.php" style="color: #81a1c1; text-decoration: none;">Cerrar Sesión</a></p>
        </div>

        <!-- Menú Principal con las opciones solicitadas -->
        <ul class="menu">
            <?php if ($ha_realizado_test): ?>
                <li><a href="mantenimiento.php">1. Mantenimiento</a></li>
                <li><a href="test_psicologico.php?id=<?php echo $usuario_encontrado['id_usuario']; ?>">2. Test Psicológico</a></li>
                <li><a href="Listar.php">3. Reporte</a></li>
            <?php else: ?>
                <li class="disabled">1. Mantenimiento (Bloqueado: Debe realizar el test primero)</li>
                <li><a href="test_psicologico.php?id=<?php echo $usuario_encontrado['id_usuario']; ?>">2. Test Psicológico (Realizar ahora)</a></li>
                <li class="disabled">3. Reporte (Bloqueado)</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>