<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1. Círculo</title>
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
            <h2>Cálculo del Círculo</h2>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="radio">Ingrese el radio:</label>
                    <input type="number" step="any" id="radio" name="radio" required>
                </div>
                <button type="submit" class="btn-submit">Calcular e Imprimir</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['radio'])) {
                $radio = floatval($_POST['radio']);
                
                $area = pi() * pow($radio, 2);
                $perimetro = 2 * pi() * $radio;

                echo "<div class='resultado'>";
                echo "<h3>Resultados Impresos:</h3>";
                echo "<p><strong>El radio ingresado es:</strong> " . $radio . "</p>";
                echo "<p><strong>El área del círculo es:</strong> " . round($area, 2) . "</p>";
                echo "<p><strong>El perímetro del círculo es:</strong> " . round($perimetro, 2) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

</body>
</html>