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
    // Capturar las 12 respuestas del test
    $p1 = intval($_POST['p1'] ?? 0);
    $p2 = intval($_POST['p2'] ?? 0);
    $p3 = intval($_POST['p3'] ?? 0);
    $p4 = intval($_POST['p4'] ?? 0);
    $p5 = intval($_POST['p5'] ?? 0);
    $p6 = intval($_POST['p6'] ?? 0);
    $p7 = intval($_POST['p7'] ?? 0);
    $p8 = intval($_POST['p8'] ?? 0);
    $p9 = intval($_POST['p9'] ?? 0);
    $p10 = intval($_POST['p10'] ?? 0);
    $p11 = intval($_POST['p11'] ?? 0);
    $p12 = intval($_POST['p12'] ?? 0);
    
    // Puntaje total (máximo 36 puntos)
    $puntaje_total = $p1 + $p2 + $p3 + $p4 + $p5 + $p6 + $p7 + $p8 + $p9 + $p10 + $p11 + $p12;
    
    // Determinar situación según el puntaje
    $situacion = ($puntaje_total > 24) ? "Alto" : "Normal";

    // Actualizar base de datos
    $update = $conexion->prepare("UPDATE test SET puntaje = ?, situacion = ? WHERE id_usuario = ?");
    $update->execute([$puntaje_total, $situacion, $id_usuario]);

    $resultado_mensaje = "¡Test completado con éxito! Tu puntaje fue: $puntaje_total. Situación: $situacion.";
    
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
    <div class="container" style="max-width: 750px;">
        <h1>Test Psicológico de Autoevaluación</h1>
        
        <!-- Información corta al principio -->
        <div style="background: rgba(20, 30, 45, 0.7); padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #3498db;">
            <p style="margin: 0; font-size: 20px; color: #ffffff;">
                <strong>¿Qué es este test?</strong> Es una herramienta de bienestar emocional diseñada para evaluar tu nivel de estrés, estabilidad emocional y adaptación frente a situaciones cotidianas. Responde con sinceridad según cómo te has sentido últimamente.
            </p>
        </div>

        <?php if (!empty($resultado_mensaje)): ?>
            <div class="success"><?php echo $resultado_mensaje; ?></div>
            <p style="text-align: center; margin-top: 20px;"><a href="index.php">← Regresar al Menú Principal</a></p>
        <?php else: ?>
            <form method="POST" action="">
                
                <!-- Pregunta 1 -->
                <fieldset>
                    <legend>1. ¿Cómo te sientes al iniciar tu jornada laboral o de estudio?</legend>
                    <label><input type="radio" name="p1" value="1" required> Con energía y motivación</label><br>
                    <label><input type="radio" name="p1" value="2"> Neutral / Normal</label><br>
                    <label><input type="radio" name="p1" value="3"> Cansado o sin ánimos</label>
                </fieldset>

                <!-- Pregunta 2 -->
                <fieldset>
                    <legend>2. ¿Cómo manejas situaciones de presión imprevistas?</legend>
                    <label><input type="radio" name="p2" value="1" required> Mantengo la calma y busco soluciones</label><br>
                    <label><input type="radio" name="p2" value="2"> Me estreso un poco pero continúo</label><br>
                    <label><input type="radio" name="p2" value="3"> Me abrumo fácilmente</label>
                </fieldset>

                <!-- Pregunta 3 -->
                <fieldset>
                    <legend>3. ¿Cómo evalúa su descanso nocturno habitualmente?</legend>
                    <label><input type="radio" name="p3" value="1" required> Duermo plácidamente</label><br>
                    <label><input type="radio" name="p3" value="2"> A veces despierto cansado</label><br>
                    <label><input type="radio" name="p3" value="3"> Sufro de constantes interrupciones / insomnio</label>
                </fieldset>

                <!-- Pregunta 4 (Nueva) -->
                <fieldset>
                    <legend>4. ¿Con qué frecuencia experimentas sensación de irritabilidad o enojo sin causa aparente?</legend>
                    <label><input type="radio" name="p4" value="1" required> Casi nunca</label><br>
                    <label><input type="radio" name="p4" value="2"> Ocasionalmente</label><br>
                    <label><input type="radio" name="p4" value="3"> Frecuentemente</label>
                </fieldset>

                <!-- Pregunta 5 (Nueva) -->
                <fieldset>
                    <legend>5. ¿Te resulta fácil concentrarte en tus actividades diarias?</legend>
                    <label><input type="radio" name="p5" value="1" required> Sí, me concentro sin problema</label><br>
                    <label><input type="radio" name="p5" value="2"> Me cuesta un poco a veces</label><br>
                    <label><input type="radio" name="p5" value="3"> Me distrae cualquier cosa constantemente</label>
                </fieldset>

                <!-- Pregunta 6 (Nueva) -->
                <fieldset>
                    <legend>6. ¿Cómo valoras tu nivel de confianza al tomar decisiones importantes?</legend>
                    <label><input type="radio" name="p6" value="1" required> Muy seguro de mí mismo</label><br>
                    <label><input type="radio" name="p6" value="2"> A veces dudo, pero decido</label><br>
                    <label><input type="radio" name="p6" value="3"> Me cuesta mucho decidir por temor a equivocarme</label>
                </fieldset>

                <!-- Pregunta 7 (Nueva) -->
                <fieldset>
                    <legend>7. ¿Sientes que disfrutas de tus tiempos libres y pasatiempos?</legend>
                    <label><input type="radio" name="p7" value="1" required> Sí, los disfruto plenamente</label><br>
                    <label><input type="radio" name="p7" value="2"> A veces por falta de tiempo</label><br>
                    <label><input type="radio" name="p7" value="3"> Ya nada me entusiasma como antes</label>
                </fieldset>

                <!-- Pregunta 8 (Nueva) -->
                <fieldset>
                    <legend>8. ¿Cómo percibes tu nivel de carga mental o agobio general?</legend>
                    <label><input type="radio" name="p8" value="1" required> Bajo control</label><br>
                    <label><input type="radio" name="p8" value="2"> Moderado, soportable</label><br>
                    <label><input type="radio" name="p8" value="3"> Excesivo, al límite</label>
                </fieldset>

                <!-- Pregunta 9 (Nueva) -->
                <fieldset>
                    <legend>9. ¿Tiendes a anticipar escenarios negativos o catastróficos ante los problemas?</legend>
                    <label><input type="radio" name="p9" value="1" required> No, prefiero enfocarme en soluciones</label><br>
                    <label><input type="radio" name="p9" value="2"> A veces me preocupo de más</label><br>
                    <label><input type="radio" name="p9" value="3"> Siempre espero lo peor</label>
                </fieldset>

                <!-- Pregunta 10 (Nueva) -->
                <fieldset>
                    <legend>10. ¿Cómo describirías tus relaciones interpersonales recientes?</legend>
                    <label><input type="radio" name="p10" value="1" required> Armoniosas y de apoyo</label><br>
                    <label><input type="radio" name="p10" value="2"> Con algunos roces normales</label><br>
                    <label><input type="radio" name="p10" value="3"> Distantes o conflictivas</label>
                </fieldset>

                <!-- Pregunta 11 (Nueva) -->
                <fieldset>
                    <legend>11. ¿Experimentas síntomas físicos de estrés (dolores de cabeza, tensión muscular, fatiga)?</legend>
                    <label><input type="radio" name="p11" value="1" required> Rara vez o nunca</label><br>
                    <label><input type="radio" name="p11" value="2"> Algunas veces por semana</label><br>
                    <label><input type="radio" name="p11" value="3"> Constantemente</label>
                </fieldset>

                <!-- Pregunta 12 (Nueva) -->
                <fieldset>
                    <legend>12. ¿Sientes que tienes el control sobre el rumbo de tu vida actualmente?</legend>
                    <label><input type="radio" name="p12" value="1" required> Sí, totalmente</label><br>
                    <label><input type="radio" name="p12" value="2"> Parcialmente</label><br>
                    <label><input type="radio" name="p12" value="3"> Siento que todo está fuera de mi control</label>
                </fieldset>

                <button type="submit">Enviar Respuestas del Test</button>
            </form>
            <p style="text-align: center; margin-top: 20px;"><br><a href="index.php">← Volver al Menú Principal</a></p>
        <?php endif; ?>
    </div>
</body>
</html>