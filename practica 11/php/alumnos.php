<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>2. Calificaciones de Alumnos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <a href="../index.php">← Regresar al Menú</a>
    <h2>2. Registro de Alumnos y Promedios</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cantidad'])) {
        $cantidad = intval($_POST['cantidad']);
        echo "<form method='POST' action='alumnos.php'>";
        echo "<input type='hidden' name='procesar_datos' value='1'>";
        echo "<input type='hidden' name='total_alumnos' value='$cantidad'>";
        
        for ($i = 1; $i <= $cantidad; $i++) {
            echo "<h4>Alumno $i:</h4>";
            echo "Nombre: <input type='text' name='nombre_$i' required> ";
            echo "Parcial 1: <input type='number' step='0.1' name='par1_$i' min='0' max='10' required> ";
            echo "Parcial 2: <input type='number' step='0.1' name='par2_$i' min='0' max='10' required><br><br>";
        }
        echo "<button type='submit'>Calcular Promedios</button>";
        echo "</form>";

    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['procesar_datos'])) {
        $total = intval($_POST['total_alumnos']);
        $suma_promedios = 0;

        echo "<h3>Reporte de Alumnos</h3>";
        echo "<table border='1' cellpadding='6' cellspacing='0'>";
        echo "<tr><th>Alumno</th><th>Promedio</th><th>Situación</th></tr>";

        for ($i = 1; $i <= $total; $i++) {
            $nom = htmlspecialchars($_POST["nombre_$i"]);
            $p1 = floatval($_POST["par1_$i"]);
            $p2 = floatval($_POST["par2_$i"]);
            
            $prom = ($p1 + $p2) / 2;
            $suma_promedios += $prom;
            $sit = ($prom >= 6.0) ? "Aprobado" : "Reprobado";

            echo "<tr>";
            echo "<td>$nom</td>";
            echo "<td>" . number_format($prom, 2) . "</td>";
            echo "<td>$sit</td>";
            echo "</tr>";
        }

        $prom_general = $suma_promedios / $total;
        echo "</table>";
        echo "<h4>Promedio General del Grupo: " . number_format($prom_general, 2) . "</h4>";
        echo "<hr><a href='alumnos.php'>Nuevos datos</a>";

    } else {
    ?>

    <form method="POST" action="alumnos.php">
        <label>¿Cuántos alumnos vas a ingresar?</label><br>
        <input type="number" name="cantidad" min="1" max="50" required><br><br>
        <button type="submit">Continuar</button>
    </form>

    <?php } ?>
</body>
</html>