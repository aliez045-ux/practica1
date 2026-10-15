<?php
require_once 'conexion.php';

$registro_encontrado = null;
$id_buscado = "";
$mensaje = "";

if (isset($_POST['accion_eliminar'])) {
    $id_eliminar = trim($_POST['id_eliminar']);

    if ($id_eliminar !== "") {
        $stmt = mysqli_prepare($conexion, "DELETE FROM Alumnos WHERE Id_control = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id_eliminar);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<p style='color: green; font-weight: bold;'>¡Alumno con Id Control '" . htmlspecialchars($id_eliminar) . "' eliminado con éxito!</p>";
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
        $stmt = mysqli_prepare($conexion, "SELECT Id_control, Nombre, Carrera, Grupo, Parcial_1, Parcial_2, Parcial_3, Promedio, Situacion FROM Alumnos WHERE Id_control = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id_buscado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            if ($resultado && ($fila = mysqli_fetch_assoc($resultado))) {
                $registro_encontrado = $fila;
            } elseif ($mensaje === "") {
                $mensaje = "<p style='color: red;'>No se encontró ningún alumno con el Id Control '" . htmlspecialchars($id_buscado) . "'.</p>";
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
    <title>Eliminar Alumno</title>
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
    <h2>Buscar y Eliminar Alumno</h2>
    <a href="Listar.php">⬅ Ver todos los alumnos</a> | <a href="Base.php">➕ Agregar alumno</a>
    <br><br>

    <?php echo $mensaje; ?>

    <div class="bloque">
        <form action="eliminar.php" method="GET">
            <label for="id_buscar">Introduce el Id Control del alumno a borrar:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="10" value="<?php echo htmlspecialchars($id_buscado); ?>" required>
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
    </div>

    <?php if ($registro_encontrado): ?>
        <div class="tarjeta-eliminar">
            <h3 style="color: #721c24; margin-top: 0;">¿Confirmas que deseas eliminar este alumno?</h3>
            <p><strong>Id Control:</strong> <?php echo htmlspecialchars($registro_encontrado['Id_control']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro_encontrado['Nombre']); ?></p>
            <p><strong>Carrera:</strong> <?php echo htmlspecialchars($registro_encontrado['Carrera']); ?></p>
            <p><strong>Grupo:</strong> <?php echo htmlspecialchars($registro_encontrado['Grupo']); ?></p>
            <p><strong>Promedio:</strong> <?php echo htmlspecialchars($registro_encontrado['Promedio']); ?> - <?php echo htmlspecialchars($registro_encontrado['Situacion']); ?></p>

            <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Estás seguro de borrar este alumno? Esta acción no se puede deshacer.');">
                <input type="hidden" name="id_eliminar" value="<?php echo htmlspecialchars($registro_encontrado['Id_control']); ?>">
                <button type="submit" name="accion_eliminar" class="btn-eliminar"> Eliminar Permanentemente</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
