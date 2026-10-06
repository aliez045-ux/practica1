<?php
session_start();
require_once '../modelo/conexion.php';

$mensaje = "";

// PROCESAR REGISTRO
if (isset($_POST['registro'])) {
    $nombre = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $password = $_POST['contrasena'];

    $sql_check = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
    $res_check = $conexion->query($sql_check);

    if ($res_check->num_rows > 0) {
        $mensaje = "<p class='msg-error'>El usuario o correo ya existe.</p>";
    } else {
        $sql_insert = "INSERT INTO usuarios (nombre_completo, email, usuario, contrasena) VALUES ('$nombre', '$email', '$usuario', '$password')";
        if ($conexion->query($sql_insert)) {
            $mensaje = "<p class='msg-exito'>¡Registro hecho exitosamente! Ahora puedes iniciar sesión.</p>";
        } else {
            $mensaje = "<p class='msg-error'>Error al registrar el usuario.</p>";
        }
    }
}

// PROCESAR LOGIN
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$password'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: menu.php");
        exit();
    } else {
        $mensaje = "<p class='msg-error'>Usuario o contraseña incorrectos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú 10 Práctica - Login</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="box">
    <h2>Inicio de Sesión</h2>
    <?php echo $mensaje; ?>
    <form method="POST" action="login.php">
        <label>Usuario</label>
        <input type="text" name="usuario" required>
        
        <label>Contraseña</label>
        <input type="password" name="contrasena" required>
        
        <input type="submit" name="login" value="Ingresar">
    </form>
</div>

<div class="box">
    <h3>¿No tienes cuenta? Regístrate</h3>
    <form method="POST" action="login.php">
        <label>Nombre Completo</label>
        <input type="text" name="nombre_completo" required>
        
        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Usuario</label>
        <input type="text" name="usuario" required>
        
        <label>Contraseña</label>
        <input type="password" name="contrasena" required>
        
        <input type="submit" name="registro" value="Crear Cuenta">
    </form>
</div>

</body>
</html>