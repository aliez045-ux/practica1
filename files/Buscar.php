<?php
require_once 'conexion.php';

$registro_encontrado = null;
$busqueda_realizada  = false;
$id_buscado = "";

if (isset($_GET['id_buscar'])) {
    $busqueda_realizada = true;
    $id_buscado = trim($_GET['id_buscar']);

    if ($id_buscado !== "") {
        $stmt = mysqli_prepare($conexion, "SELECT Id_persona, Nombre, Direccion, Email, Telefono, Sexo FROM agenda WHERE Id_persona = ?");
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
    <title>Consultar Usuario</title>
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
    <h2>Consultar Registro por ID de Persona</h2>
    <a href="Listar.php">⬅ Volver a la lista completa</a> | <a href="Base.php">➕ Registrar Nuevo</a>
    <br><br>

    <div class="formulario-busqueda">
        <form action="Buscar.php" method="GET">
            <label for="id_buscar">Ingresa el ID de la persona:</label><br><br>
            <input type="text" id="id_buscar" name="id_buscar" maxlength="8" value="<?php echo htmlspecialchars($id_buscado); ?>" required>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <?php if ($busqueda_realizada): ?>
        <?php if ($registro_encontrado): ?>
            <div class="resultado-tarjeta">
                <h3>¡Registro Encontrado!</h3>
                <p><strong>ID Persona:</strong> <?php echo htmlspecialchars($registro_encontrado['Id_persona']); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($registro_encontrado['Nombre']); ?></p>
                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($registro_encontrado['Direccion']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($registro_encontrado['Email']); ?></p>
                <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($registro_encontrado['Telefono']); ?></p>
                <p><strong>Sexo:</strong> <?php echo htmlspecialchars($registro_encontrado['Sexo']); ?></p>
            </div>
        <?php else: ?>
            <p class="error-alerta">No se encontró ningún registro con el ID "<?php echo htmlspecialchars($id_buscado); ?>".</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conexion); ?>
