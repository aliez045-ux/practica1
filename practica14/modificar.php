<?php
require_once 'conexion.php';
$usuario = null;
$mensaje = "";

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conexion->prepare("SELECT * FROM test WHERE id_usuario = ?");
    $stmt->execute([$_GET['id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nombre = trim($_POST['nombre']);
    $edad = intval($_POST['edad']);
    $sexo = trim($_POST['sexo']);
    $profesion = trim($_POST['profesion']);

    try {
        $stmt = $conexion->prepare("UPDATE test SET nombre = ?, edad = ?, sexo = ?, profesion = ? WHERE id_usuario = ?");
        $stmt->execute([$nombre, $edad, $sexo, $profesion, $id_usuario]);
        $mensaje = "Usuario modificado correctamente.";
        
        // Recargar datos actualizados
        $stmt = $conexion->prepare("SELECT * FROM test WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $mensaje = "Error al modificar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Usuario</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Modificar Usuario</h1>
        
        <!-- Formulario de selección por ID -->
        <?php if (!isset($_GET['id']) && !$usuario): ?>
            <form method="GET" action="">
                <label>Ingrese el ID del usuario a modificar:</label>
                <input type="text" name="id" maxlength="8" required>
                <button type="submit">Cargar Datos</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($mensaje)): ?>
            <div class="success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <?php if ($usuario): ?>
            <form method="POST" action="">
                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                <p><strong>ID Usuario:</strong> <?php echo htmlspecialchars($usuario['id_usuario']); ?></p>

                <label>Nombre:</label>
                <input type="text" name="nombre" maxlength="30" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                <label>Edad:</label>
                <input type="number" name="edad" max="99" value="<?php echo htmlspecialchars($usuario['edad']); ?>" required>

                <label>Sexo:</label>
                <input type="text" name="sexo" maxlength="1" value="<?php echo htmlspecialchars($usuario['sexo']); ?>" required>

                <label>Profesión:</label>
                <input type="text" name="profesion" maxlength="10" value="<?php echo htmlspecialchars($usuario['profesion']); ?>" required>

                <button type="submit">Actualizar Datos</button>
            </form>
        <?php endif; ?>
        <p><br><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>