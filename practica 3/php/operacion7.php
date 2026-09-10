<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>7. Pares e Impares</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>7. Pares e Impares</h2>
        <form method="POST">
            <label>Número?</label>
            <input type="number" name="numero" required>
            <button type="submit" name="evaluar">Evaluar</button>
        </form>

        <?php
        if (isset($_POST['evaluar'])) {
            $num = $_POST['numero'];
            echo "<div class='resultado'>";
            echo "<p>El número <strong>{$num}</strong> es " . ($num % 2 == 0 ? "PAR" : "IMPAR") . ".</p>";
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>