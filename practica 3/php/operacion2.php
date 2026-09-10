<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>2. Fórmula General</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>2. Fórmula General</h2>
        <form method="POST">
            <label>a:</label>
            <input type="number" step="any" name="a" required>
            <label>b:</label>
            <input type="number" step="any" name="b" required>
            <label>c:</label>
            <input type="number" step="any" name="c" required>
            <button type="submit" name="calcular">Calcular X1 y X2</button>
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $a = $_POST['a'];
            $b = $_POST['b'];
            $c = $_POST['c'];

            echo "<div class='resultado'>";
            if ($a == 0) {
                echo "<p>El valor de 'a' no puede ser 0.</p>";
            } else {
                $disc = ($b * $b) - (4 * $a * $c);
                if ($disc < 0) {
                    echo "<p>Sin soluciones reales (imaginarias).</p>";
                } else {
                    $x1 = (-$b + sqrt($disc)) / (2 * $a);
                    $x2 = (-$b - sqrt($disc)) / (2 * $a);
                    echo "<p><strong>X1 =</strong> " . round($x1, 2) . "</p>";
                    echo "<p><strong>X2 =</strong> " . round($x2, 2) . "</p>";
                }
            }
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>