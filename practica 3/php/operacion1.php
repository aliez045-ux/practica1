<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>1. Operaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>1. Operaciones Básicas</h2>
        <form method="POST">
            <label>Número 1:</label>
            <input type="number" step="any" name="num1" required>
            <label>Número 2:</label>
            <input type="number" step="any" name="num2" required>
            <button type="submit" name="calcular">Calcular</button>
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $n1 = $_POST['num1'];
            $n2 = $_POST['num2'];
            echo "<div class='resultado'>";
            echo "<p><strong>Suma:</strong> " . ($n1 + $n2) . "</p>";
            echo "<p><strong>Resta:</strong> " . ($n1 - $n2) . "</p>";
            echo "<p><strong>Multiplicación:</strong> " . ($n1 * $n2) . "</p>";
            echo "<p><strong>División:</strong> " . ($n2 != 0 ? ($n1 / $n2) : "No divisible entre 0") . "</p>";
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>