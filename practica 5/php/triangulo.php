<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2. Triángulo</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">1. Círculo</a></li>
            <li><a href="triangulo.php">2. Triángulo</a></li>
            <li><a href="comparar.php">3. Comparar Números</a></li>
        </ul>
    </nav>

    <div class="main-container">
        <div class="form-container">
            <h2>Cálculo del Triángulo</h2>
            <form action="triangulo.php" method="POST">
                <div class="form-group">
                    <label for="base">Ingrese la base:</label>
                    <input type="number" step="any" id="base" name="base" required>
                </div>
                <div class="form-group">
                    <label for="altura">Ingrese la altura:</label>
                    <input type="number" step="any" id="altura" name="altura" required>
                </div>
                <button type="submit" class="btn-submit">Calcular e Imprimir</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['base']) && isset($_POST['altura'])) {
                $base = floatval($_POST['base']);
                $altura = floatval($_POST['altura']);
                
                $area = ($base * $altura) / 2;
                $hipotenusa = sqrt(pow($base, 2) + pow($altura, 2));
                $perimetro = $base + $altura + $hipotenusa;

                echo "<div class='resultado'>";
                echo "<h3>Resultados Impresos:</h3>";
                echo "<p><strong>Base:</strong> " . $base . "</p>";
                echo "<p><strong>Altura:</strong> " . $altura . "</p>";
                echo "<p><strong>El área del triángulo es:</strong> " . round($area, 2) . "</p>";
                echo "<p><strong>El perímetro del triángulo es:</strong> " . round($perimetro, 2) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

</body>
</html>