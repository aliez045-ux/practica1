<?php
require_once 'conexion.php';

$registro_encontrado = null;
$id_buscado = "";
$mensaje = "";

if (isset($_POST['accion_eliminar'])) {
    $id_eliminar = trim($_POST['id_eliminar']);

    if ($id_eliminar !== "") {
        $stmt = mysqli_prepare($conexion, "DELETE FROM agenda WHERE Id_persona = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id_eliminar);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<p style='color: green; font-weight: bold;'>¡Registro con ID '" . htmlspecialchars($id_eliminar) . "' eliminado con éxito!</p>";
            } else {
                $mensaje = "<p style='color: red;'>Error al intentar eliminar: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
            }
            mysqli_stmt_close($stmt);
        }
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
    <title>Buscar y Eliminar Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .bloque { background: #f4f4f4; padding: 20px; border-radius: 5px; width: 420px; margin-bottom: 20px; }
        .tarjeta-eliminar { border: 1px solid #dc3545; background: #f8d7da; padding: 20px; border-radius: 5px; width: 420px; }
        input[type="text"] { padding: 8px; width: 220px; }
        .btn-buscar { padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-eliminar { padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Buscar y Eliminar Registro</h2>
    <a href="Listar.php">⬅ Ver todos los registros</a> | <a href="Base.php">➕ Registrar Nuevo</a>
    <br><br>

    <?php echo $mensaje; ?>

    <div class="bloque">
        <form action="eliminar.php" method="GET">
            <label for="id_buscar">Introduce el ID de la persona a borrar:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="8" value="<?php echo htmlspecialchars($id_buscado); ?>" required>
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
    </div>

    <?php if ($registro_encontrado): ?>
        <div class="tarjeta-eliminar">
            <h3 style="color: #721c24; margin-top: 0;">¿Confirmas que deseas eliminar este registro?</h3>
            <p><strong>ID Persona:</strong> <?php echo htmlspecialchars($registro_encontrado['Id_persona']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro_encontrado['Nombre']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($registro_encontrado['Direccion']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($registro_encontrado['Email']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($registro_encontrado['Telefono']); ?></p>
            <p><strong>Sexo:</strong> <?php echo htmlspecialchars($registro_encontrado['Sexo']); ?></p>

            <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Estás seguro de borrar este registro? Esta acción no se puede deshacer.');">
                <input type="hidden" name="id_eliminar" value="<?php echo htmlspecialchars($registro_encontrado['Id_persona']); ?>">
                <button type="submit" name="accion_eliminar" class="btn-eliminar">⚠️ Eliminar Permanentemente</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
