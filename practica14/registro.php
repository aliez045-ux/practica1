<?php
require_once 'conexion.php';
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = trim($_POST['id_usuario']);
    $usuario = trim($_POST['usuario']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nombre = trim($_POST['nombre']);
    $edad = intval($_POST['edad']);
    $sexo = trim($_POST['sexo']);
    $profesion = trim($_POST['profesion']);

    try {
        $stmt = $conexion->prepare("INSERT INTO test (id_usuario, usuario, password, nombre, edad, sexo, profesion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $usuario, $password, $nombre, $edad, $sexo, $profesion]);
        $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
    } catch (PDOException $e) {
        $mensaje = "Error al registrarse (Es posible que el ID o el usuario ya existan): " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Crear Cuenta / Registro</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="<?php echo strpos($mensaje, 'exitoso') !== false ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label>ID Usuario (Máx 8 car.):</label>
            <input type="text" name="id_usuario" maxlength="8" required>

            <label>Nombre de Usuario (para iniciar sesión):</label>
            <input type="text" name="usuario" maxlength="30" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <label>Nombre Completo (Máx 30 car.):</label>
            <input type="text" name="nombre" maxlength="30" required>

            <label>Edad (2 dígitos):</label>
            <input type="number" name="edad" max="99" required>

            <label>Sexo (1 car., Ej: M/F):</label>
            <input type="text" name="sexo" maxlength="1" required>

            <label>Profesión (Máx 10 car.):</label>
            <input type="text" name="profesion" maxlength="10" required>

            <button type="submit">Registrarse</button>
        </form>
        <p style="text-align: center; margin-top: 15px;"><a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a></p>
    </div>
</body>
</html>