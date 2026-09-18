<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3. Comparar Números</title>
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
            <h2>Comparar 2 Números</h2>
            <form action="comparar.php" method="POST">
                <div class="form-group">
                    <label for="num1">Primer Número:</label>
                    <input type="number" step="any" id="num1" name="num1" required>
                </div>
                <div class="form-group">
                    <label for="num2">Segundo Número:</label>
                    <input type="number" step="any" id="num2" name="num2" required>
                </div>
                <button type="submit" class="btn-submit">Comparar e Imprimir</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['num1']) && isset($_POST['num2'])) {
                $num1 = floatval($_POST['num1']);
                $num2 = floatval($_POST['num2']);

                if ($num1 > $num2) {
                    $mensaje = "El número $num1 es mayor que el número $num2.";
                } elseif ($num2 > $num1) {
                    $mensaje = "El número $num2 es mayor que el número $num1.";
                } else {
                    $mensaje = "Ambos números ($num1 y $num2) son iguales.";
                }

                echo "<div class='resultado'>";
                echo "<h3>Resultado Impreso:</h3>";
                echo "<p><strong>" . $mensaje . "</strong></p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

</body>
</html>