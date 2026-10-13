<?php
require_once 'conexion.php';

$registro_encontrado = null;
$id_buscado = "";
$mensaje = "";

if (isset($_POST['accion_actualizar'])) {
    $id_modificar    = trim($_POST['id_modificar']);
    $nuevo_nombre    = trim($_POST['nombre']);
    $nueva_direccion = trim($_POST['direccion']);
    $nuevo_email     = trim($_POST['email']);
    $nuevo_telefono  = trim($_POST['telefono']);
    $nuevo_sexo      = trim($_POST['sexo']);

    if ($id_modificar !== "" && $nuevo_nombre !== "" && $nueva_direccion !== "" && $nuevo_email !== "" && $nuevo_telefono !== "" && $nuevo_sexo !== "") {
        $stmt = mysqli_prepare($conexion, "UPDATE agenda SET Nombre = ?, Direccion = ?, Email = ?, Telefono = ?, Sexo = ? WHERE Id_persona = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $nuevo_nombre, $nueva_direccion, $nuevo_email, $nuevo_telefono, $nuevo_sexo, $id_modificar);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<p style='color: green; font-weight: bold;'>¡Registro actualizado con éxito!</p>";
            } else {
                $mensaje = "<p style='color: red;'>Error al actualizar: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
            }
            mysqli_stmt_close($stmt);
        }
        $_GET['id_buscar'] = $id_modificar;
    } else {
        $mensaje = "<p style='color: red;'>Por favor, rellena todos los campos.</p>";
    }
}

if (isset($_GET['id_buscar'])) {
    $id_buscado = trim($_GET['id_buscar']);

    if ($id_buscado !== "") {
        $stmt = mysqli_prepare($conexion, "SELECT Id_persona, Nombre, Direccion, Email, Telefono, Sexo FROM agenda WHERE Id_persona = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id_buscado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            if ($resultado && ($fila = mysqli_fetch_assoc($resultado))) {
                $registro_encontrado = $fila;
            } elseif ($mensaje === "") {
                $mensaje = "<p style='color: red;'>No se encontró ningún registro con el ID '" . htmlspecialchars($id_buscado) . "'.</p>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .bloque { background: #f4f4f4; padding: 20px; border-radius: 5px; width: 420px; margin-bottom: 20px; }
        .tarjeta-editar { border: 1px solid #007BFF; background: #e9f2fe; padding: 20px; border-radius: 5px; width: 420px; }
        input[type="text"], input[type="email"], select { padding: 8px; width: 90%; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-buscar { padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; width: auto; }
        .btn-guardar { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .deshabilitado { background-color: #e9ecef; color: #495057; cursor: not-allowed; }
    </style>
</head>
<body>
    <h2>Modificar Registro en la Agenda</h2>
    <a href="Listar.php">⬅ Ver todos los registros</a> | <a href="Base.php">➕ Registrar Nuevo</a>
    <br><br>

    <?php echo $mensaje; ?>

    <div class="bloque">
        <form action="modificar.php" method="GET">
            <label for="id_buscar">Introduce el ID de la persona a modificar:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="8" value="<?php echo htmlspecialchars($id_buscado); ?>" style="width: 60%; margin-bottom: 0;" required>
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
    </div>

    <?php if ($registro_encontrado): ?>
        <div class="tarjeta-editar">
            <h3 style="color: #0056b3; margin-top: 0;">Editar Datos del Registro</h3>

            <form action="modificar.php" method="POST">
                <label>ID Persona (No modificable):</label>
                <input type="text" class="deshabilitado" value="<?php echo htmlspecialchars($registro_encontrado['Id_persona']); ?>" readonly>
                <input type="hidden" name="id_modificar" value="<?php echo htmlspecialchars($registro_encontrado['Id_persona']); ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="30" value="<?php echo htmlspecialchars($registro_encontrado['Nombre']); ?>" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" maxlength="40" value="<?php echo htmlspecialchars($registro_encontrado['Direccion']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="40" value="<?php echo htmlspecialchars($registro_encontrado['Email']); ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" maxlength="12" value="<?php echo htmlspecialchars($registro_encontrado['Telefono']); ?>" required>

                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="M" <?php echo $registro_encontrado['Sexo'] == 'M' ? 'selected' : ''; ?>>M</option>
                    <option value="F" <?php echo $registro_encontrado['Sexo'] == 'F' ? 'selected' : ''; ?>>F</option>
                </select>

                <button type="submit" name="accion_actualizar" class="btn-guardar">💾 Guardar Cambios</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
