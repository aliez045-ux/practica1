<?php
require_once 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($_POST['id_usuario']);
    $nombre = trim($_POST['nombre']);
    $edad = intval($_POST['edad']);
    $sexo = trim($_POST['sexo']);
    $profesion = trim($_POST['profesion']);

    try {
        $stmt = $conexion->prepare("INSERT INTO test (id_usuario, nombre, edad, sexo, profesion) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $nombre, $edad, $sexo, $profesion]);
        $mensaje = "Usuario agregado exitosamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al agregar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Usuario</h1>
        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo strpos($mensaje, 'exitosamente') !== false ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label>ID Usuario (Máx 8 car.):</label>
            <input type="text" name="id_usuario" maxlength="8" required>

            <label>Nombre (Máx 30 car.):</label>
            <input type="text" name="nombre" maxlength="30" required>

            <label>Edad (2 dígitos):</label>
            <input type="number" name="edad" max="99" required>

            <label>Sexo (1 car., Ej: M/F):</label>
            <input type="text" name="sexo" maxlength="1" required>

            <label>Profesión (Máx 10 car.):</label>
            <input type="text" name="profesion" maxlength="10" required>

            <button type="submit">Guardar Usuario</button>
        </form>
        <p><br><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>