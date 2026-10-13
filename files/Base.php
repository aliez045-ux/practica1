<?php
require_once 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['b1'])) {
    $id        = trim($_POST['id_persona']);
    $nombre    = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $email     = trim($_POST['email']);
    $telefono  = trim($_POST['telefono']);
    $sexo      = trim($_POST['sexo']);

    $sql  = "INSERT INTO agenda (Id_persona, Nombre, Direccion, Email, Telefono, Sexo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    if (!$stmt) {
        $mensaje = "<p style='color:red;'>Error en la consulta: " . htmlspecialchars(mysqli_error($conexion)) . "</p>";
    } else {
        mysqli_stmt_bind_param($stmt, "ssssss", $id, $nombre, $direccion, $email, $telefono, $sexo);
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "<p style='color:green;font-weight:bold;'>¡Datos guardados correctamente!</p>";
        } else {
            $mensaje = "<p style='color:red;'>Error al guardar: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Registro de Usuarios</h2>
    <?php echo $mensaje; ?>
    <form action="Base.php" method="POST">
        <label for="id_persona">ID Persona:</label>
        <input type="text" id="id_persona" name="id_persona" maxlength="8" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="30" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" maxlength="40" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" maxlength="40" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" maxlength="12" required><br><br>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="">-- Selecciona --</option>
            <option value="M">M</option>
            <option value="F">F</option>
        </select><br><br>

        <button type="submit" name="b1" value="1">Guardar Datos</button>
        <button type="button" onclick="window.location.href='Listar.php'">Listar</button>
        <button type="button" onclick="window.location.href='Buscar.php'">Consultar</button>
        <button type="button" onclick="window.location.href='modificar.php'">Modificar</button>
        <button type="button" onclick="window.location.href='eliminar.php'">Eliminar</button>
    </form>
</body>
</html>
