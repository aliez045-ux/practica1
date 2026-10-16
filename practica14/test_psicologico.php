<?php
require_once 'conexion.php';

$id_usuario = $_GET['id'] ?? '';

if (empty($id_usuario)) {
    header("Location: index.php");
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM test WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

$resultado_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar respuestas del test
    $p1 = intval($_POST['p1'] ?? 0);
    $p2 = intval($_POST['p2'] ?? 0);
    $p3 = intval($_POST['p3'] ?? 0);
    
    $puntaje_total = $p1 + $p2 + $p3;
    $situacion = ($puntaje_total > 6) ? "Alto" : "Normal";

    // Actualizar base de datos
    $update = $conexion->prepare("UPDATE test SET puntaje = ?, situacion = ? WHERE id_usuario = ?");
    $update->execute([$puntaje_total, $situacion, $id_usuario]);

    $resultado_mensaje = "¡Test completado con éxito! Tu puntaje fue: $puntaje_total. Situación: $situacion.";
    // Actualizar variable local
    $usuario['puntaje'] = $puntaje_total;
    $usuario['situacion'] = $situacion;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Psicológico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Test Psicológico de Autoevaluación</h1>
        <p><strong>Información:</strong> Este test evalúa tu nivel de bienestar general basado en tus respuestas cotidianas.</p>

        <?php if (!empty($resultado_mensaje)): ?>
            <div class="success"><?php echo $resultado_mensaje; ?></div>
            <p><a href="index.php">Regresar al Menú Principal</a></p>
        <?php else: ?>
            <form method="POST" action="">
                <fieldset>
                    <legend>1. ¿Cómo te sientes al iniciar tu jornada laboral o de estudio?</legend>
                    <label><input type="radio" name="p1" value="1" required> Con energía y motivación</label><br>
                    <label><input type="radio" name="p1" value="2"> Neutral / Normal</label><br>
                    <label><input type="radio" name="p1" value="3"> Cansado o sin ánimos</label>
                </fieldset>

                <fieldset>
                    <legend>2. ¿Cómo manejas situaciones de presión imprevistas?</legend>
                    <label><input type="radio" name="p2" value="1" required> Mantengo la calma y busco soluciones</label><br>
                    <label><input type="radio" name="p2" value="2"> Me estreso un poco pero continúo</label><br>
                    <label><input type="radio" name="p2" value="3"> Me abrumo fácilmente</label>
                </fieldset>

                <fieldset>
                    <legend>3. ¿Cómo evalúa su descanso nocturno habitualmente?</legend>
                    <label><input type="radio" name="p3" value="1" required> Duermo plácidamente</label><br>
                    <label><input type="radio" name="p3" value="2"> A veces despierto cansado</label><br>
                    <label><input type="radio" name="p3" value="3"> Sufro de constantes interrupciones / insomnio</label>
                </fieldset>

                <button type="submit">Enviar Respuestas del Test</button>
            </form>
            <p><br><a href="index.php">← Volver al Menú Principal</a></p>
        <?php endif; ?>
    </div>
</body>
</html>