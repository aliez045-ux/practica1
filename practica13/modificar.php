<?php
require_once 'conexion.php';

$registro_encontrado = null;
$id_buscado = "";
$mensaje = "";

if (isset($_POST['accion_actualizar'])) {
    $id_modificar = trim($_POST['id_modificar']);
    $nombre  = trim($_POST['nombre']);
    $carrera = trim($_POST['carrera']);
    $grupo   = trim($_POST['grupo']);
    $p1 = $_POST['parcial_1'];
    $p2 = $_POST['parcial_2'];
    $p3 = $_POST['parcial_3'];

    if ($id_modificar === "" || $nombre === "" || !in_array($carrera, $carreras) || !in_array($grupo, $grupos)) {
        $mensaje = "<p style='color: red;'>Por favor, rellena todos los campos correctamente.</p>";
    } elseif (!parcial_valido($p1) || !parcial_valido($p2) || !parcial_valido($p3)) {
        $mensaje = "<p style='color: red;'>Los parciales deben ser números entre 0 y 10.</p>";
    } else {
        $p1 = (float)$p1; $p2 = (float)$p2; $p3 = (float)$p3;
        list($promedio, $situacion) = calcular($p1, $p2, $p3);

        $stmt = mysqli_prepare($conexion, "UPDATE Alumnos SET Nombre = ?, Carrera = ?, Grupo = ?, Parcial_1 = ?, Parcial_2 = ?, Parcial_3 = ?, Promedio = ?, Situacion = ? WHERE Id_control = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssddddss", $nombre, $carrera, $grupo, $p1, $p2, $p3, $promedio, $situacion, $id_modificar);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<p style='color: green; font-weight: bold;'>¡Alumno actualizado! Promedio: " . number_format($promedio, 2) . " - $situacion</p>";
            } else {
                $mensaje = "<p style='color: red;'>Error al actualizar: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
            }
            mysqli_stmt_close($stmt);
        }
    }
    $_GET['id_buscar'] = $id_modificar;
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
    <title>Modificar Alumno</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .bloque { background: #f4f4f4; padding: 20px; border-radius: 5px; width: 420px; margin-bottom: 20px; }
        .tarjeta-editar { border: 1px solid #007BFF; background: #e9f2fe; padding: 20px; border-radius: 5px; width: 420px; }
        input[type="text"], input[type="number"], select { padding: 8px; width: 90%; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-buscar { padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; width: auto; }
        .btn-guardar { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; }
        .deshabilitado { background-color: #e9ecef; color: #495057; cursor: not-allowed; }
    </style>
</head>
<body>
    <h2>Modificar Alumno</h2>
    <a href="Listar.php">⬅ Ver todos los alumnos</a> | <a href="Base.php">+ Agregar alumno</a>
    <br><br>

    <?php echo $mensaje; ?>

    <div class="bloque">
        <form action="modificar.php" method="GET">
            <label for="id_buscar">Introduce el Id Control del alumno a modificar:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="10" value="<?php echo htmlspecialchars($id_buscado); ?>" style="width: 60%; margin-bottom: 0;" required>
            <button type="submit" class="btn-buscar">Buscar</button>
        </form>
    </div>

    <?php if ($registro_encontrado): ?>
        <div class="tarjeta-editar">
            <h3 style="color: #0056b3; margin-top: 0;">Editar Datos del Alumno</h3>

            <form action="modificar.php" method="POST">
                <label>Id Control (No modificable):</label>
                <input type="text" class="deshabilitado" value="<?php echo htmlspecialchars($registro_encontrado['Id_control']); ?>" readonly>
                <input type="hidden" name="id_modificar" value="<?php echo htmlspecialchars($registro_encontrado['Id_control']); ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="40" value="<?php echo htmlspecialchars($registro_encontrado['Nombre']); ?>" required>

                <label for="carrera">Carrera:</label>
                <select id="carrera" name="carrera" required>
                    <?php echo opciones($carreras, $registro_encontrado['Carrera']); ?>
                </select>

                <label for="grupo">Grupo:</label>
                <select id="grupo" name="grupo" required>
                    <?php echo opciones($grupos, $registro_encontrado['Grupo']); ?>
                </select>

                <label for="parcial_1">Parcial 1:</label>
                <input type="number" id="parcial_1" name="parcial_1" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($registro_encontrado['Parcial_1']); ?>" required>

                <label for="parcial_2">Parcial 2:</label>
                <input type="number" id="parcial_2" name="parcial_2" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($registro_encontrado['Parcial_2']); ?>" required>

                <label for="parcial_3">Parcial 3:</label>
                <input type="number" id="parcial_3" name="parcial_3" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($registro_encontrado['Parcial_3']); ?>" required>

                <p><small>Promedio actual: <?php echo htmlspecialchars($registro_encontrado['Promedio']); ?> - <?php echo htmlspecialchars($registro_encontrado['Situacion']); ?> (se recalcula al guardar)</small></p>

                <button type="submit" name="accion_actualizar" class="btn-guardar"> Guardar Cambios</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
