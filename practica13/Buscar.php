<?php
require_once 'conexion.php';

$registro_encontrado = null;
$busqueda_realizada  = false;
$id_buscado = "";

if (isset($_GET['id_buscar'])) {
    $busqueda_realizada = true;
    $id_buscado = trim($_GET['id_buscar']);

    if ($id_buscado !== "") {
        $stmt = mysqli_prepare($conexion, "SELECT Id_control, Nombre, Carrera, Grupo, Parcial_1, Parcial_2, Parcial_3, Promedio, Situacion FROM Alumnos WHERE Id_control = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id_buscado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            if ($resultado && ($fila = mysqli_fetch_assoc($resultado))) {
                $registro_encontrado = $fila;
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
    <title>Buscar Alumno</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .formulario-busqueda { background: #f4f4f4; padding: 20px; border-radius: 5px; width: 400px; margin-bottom: 20px; }
        .resultado-tarjeta { border: 1px solid #17a2b8; background: #e2f0d9; padding: 20px; border-radius: 5px; width: 400px; }
        .error-alerta { color: red; font-weight: bold; }
        input[type="text"] { padding: 8px; width: 200px; }
        button { padding: 8px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Buscar Alumno por Id Control</h2>
    <a href="Listar.php">⬅ Volver a la lista completa</a> | <a href="Base.php">➕ Agregar alumno</a>
    <br><br>

    <div class="formulario-busqueda">
        <form action="Buscar.php" method="GET">
            <label for="id_buscar">Ingresa el Id Control:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="10" value="<?php echo htmlspecialchars($id_buscado); ?>" required>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <?php if ($busqueda_realizada): ?>
        <?php if ($registro_encontrado): ?>
            <div class="resultado-tarjeta">
                <h3>¡Alumno Encontrado!</h3>
                <p><strong>Id Control:</strong> <?php echo htmlspecialchars($registro_encontrado['Id_control']); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro_encontrado['Nombre']); ?></p>
                <p><strong>Carrera:</strong> <?php echo htmlspecialchars($registro_encontrado['Carrera']); ?></p>
                <p><strong>Grupo:</strong> <?php echo htmlspecialchars($registro_encontrado['Grupo']); ?></p>
                <p><strong>Parcial 1:</strong> <?php echo htmlspecialchars($registro_encontrado['Parcial_1']); ?></p>
                <p><strong>Parcial 2:</strong> <?php echo htmlspecialchars($registro_encontrado['Parcial_2']); ?></p>
                <p><strong>Parcial 3:</strong> <?php echo htmlspecialchars($registro_encontrado['Parcial_3']); ?></p>
                <p><strong>Promedio:</strong> <?php echo htmlspecialchars($registro_encontrado['Promedio']); ?></p>
                <p><strong>Situación:</strong> <?php echo htmlspecialchars($registro_encontrado['Situacion']); ?></p>
            </div>
        <?php else: ?>
            <p class="error-alerta">No se encontró ningún alumno con el Id Control "<?php echo htmlspecialchars($id_buscado); ?>".</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
