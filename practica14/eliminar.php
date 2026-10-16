<?php
require_once 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($_POST['id_usuario']);

    try {
        $stmt = $conexion->prepare("DELETE FROM test WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        
        if ($stmt->rowCount() > 0) {
            $mensaje = "Usuario eliminado correctamente.";
        } else {
            $mensaje = "No se encontró un usuario con ese ID.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error al eliminar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Eliminar Usuario</h1>
        <?php if (!empty($mensaje)): ?>
            <div class="success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" action="" onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
            <label>Ingrese ID de Usuario a eliminar:</label>
            <input type="text" name="id_usuario" maxlength="8" required>
            <button type="submit" style="background-color: #e74c3c;">Eliminar Usuario</button>
        </form>
        <p><br><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>