<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>6. Número Primo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>6. Evaluar Número Primo</h2>
        <form method="POST">
            <label>Número?</label>
            <input type="number" name="numero" required>
            <button type="submit" name="evaluar">Evaluar</button>
        </form>

        <?php
        if (isset($_POST['evaluar'])) {
            $num = $_POST['numero'];
            $primo = $num > 1;
            for ($i = 2; $i <= sqrt($num); $i++) {
                if ($num % $i == 0) { $primo = false; break; }
            }
            echo "<div class='resultado'>";
            echo "<p>El número <strong>{$num}</strong> " . ($primo ? "SÍ" : "NO") . " es primo.</p>";
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>