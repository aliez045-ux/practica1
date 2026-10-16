<?php
require_once 'conexion.php';
$usuario = null;
$mensaje = "";

if (isset($_GET['id_usuario'])) {
    $id_busqueda = trim($_GET['id_usuario']);
    $stmt = $conexion->prepare("SELECT * FROM test WHERE id_usuario = ?");
    $stmt->execute([$id_busqueda]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $mensaje = "No se encontró ningún usuario con ese ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Usuario</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Buscar Usuario</h1>
        <form method="GET" action="">
            <label>Ingrese ID de Usuario a buscar:</label>
            <input type="text" name="id_usuario" maxlength="8" required value="<?php echo isset($_GET['id_usuario']) ? htmlspecialchars($_GET['id_usuario']) : ''; ?>">
            <button type="submit">Buscar</button>
        </form>

        <?php if (!empty($mensaje)): ?>
            <p class="error"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <div class="user-info" style="margin-top:20px;">
                <h3>Resultado Encontrado:</h3>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($usuario['id_usuario']); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
                <p><strong>Edad:</strong> <?php echo htmlspecialchars($usuario['edad']); ?></p>
                <p><strong>Sexo:</strong> <?php echo htmlspecialchars($usuario['sexo']); ?></p>
                <p><strong>Profesión:</strong> <?php echo htmlspecialchars($usuario['profesion']); ?></p>
                <p><strong>Puntaje:</strong> <?php echo htmlspecialchars($usuario['puntaje'] ?? 'Pendiente'); ?></p>
                <p><strong>Situación:</strong> <?php echo htmlspecialchars($usuario['situacion'] ?? 'Pendiente'); ?></p>
            </div>
        <?php endif; ?>
        <p><br><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>