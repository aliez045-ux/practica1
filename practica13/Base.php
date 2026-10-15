<?php
require_once 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['b1'])) {
    $id      = trim($_POST['id_control']);
    $nombre  = trim($_POST['nombre']);
    $carrera = trim($_POST['carrera']);
    $grupo   = trim($_POST['grupo']);
    $p1 = $_POST['parcial_1'];
    $p2 = $_POST['parcial_2'];
    $p3 = $_POST['parcial_3'];

    if ($id === "" || $nombre === "" || !in_array($carrera, $carreras) || !in_array($grupo, $grupos)) {
        $mensaje = "<p style='color:red;'>Rellena todos los campos correctamente.</p>";
    } elseif (!parcial_valido($p1) || !parcial_valido($p2) || !parcial_valido($p3)) {
        $mensaje = "<p style='color:red;'>Los parciales deben ser números entre 0 y 10.</p>";
    } else {
        $p1 = (float)$p1; $p2 = (float)$p2; $p3 = (float)$p3;
        list($promedio, $situacion) = calcular($p1, $p2, $p3);

        $sql  = "INSERT INTO Alumnos (Id_control, Nombre, Carrera, Grupo, Parcial_1, Parcial_2, Parcial_3, Promedio, Situacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        if (!$stmt) {
            $mensaje = "<p style='color:red;'>Error en la consulta: " . htmlspecialchars(mysqli_error($conexion)) . "</p>";
        } else {
            mysqli_stmt_bind_param($stmt, "ssssdddds", $id, $nombre, $carrera, $grupo, $p1, $p2, $p3, $promedio, $situacion);
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "<p style='color:green;font-weight:bold;'>¡Alumno guardado! Promedio: " . number_format($promedio, 2) . " - $situacion</p>";
            } else {
                $mensaje = "<p style='color:red;'>Error al guardar: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</p>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
</head>
<body>
    <h2>Agregar Alumno</h2>
    <?php echo $mensaje; ?>
    <form action="Base.php" method="POST">
        <label for="id_control">Id Control:</label>
        <input type="text" id="id_control" name="id_control" maxlength="10" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="40" required><br><br>

        <label for="carrera">Carrera:</label>
        <select id="carrera" name="carrera" required>
            <option value="">-- Selecciona --</option>
            <?php echo opciones($carreras); ?>
        </select><br><br>

        <label for="grupo">Grupo:</label>
        <select id="grupo" name="grupo" required>
            <option value="">-- Selecciona --</option>
            <?php echo opciones($grupos); ?>
        </select><br><br>

        <label for="parcial_1">Parcial 1:</label>
        <input type="number" id="parcial_1" name="parcial_1" min="0" max="10" step="0.1" required><br><br>

        <label for="parcial_2">Parcial 2:</label>
        <input type="number" id="parcial_2" name="parcial_2" min="0" max="10" step="0.1" required><br><br>

        <label for="parcial_3">Parcial 3:</label>
        <input type="number" id="parcial_3" name="parcial_3" min="0" max="10" step="0.1" required><br><br>

        <small>El promedio y la situación se calculan automáticamente.</small><br><br>

        <button type="submit" name="b1" value="1">Guardar Alumno</button>
        <button type="button" onclick="window.location.href='Listar.php'">Listar</button>
        <button type="button" onclick="window.location.href='Buscar.php'">Buscar</button>
        <button type="button" onclick="window.location.href='modificar.php'">Modificar</button>
        <button type="button" onclick="window.location.href='eliminar.php'">Eliminar</button>
    </form>
</body>
</html>
