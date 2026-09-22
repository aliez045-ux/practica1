<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones y Documentación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="vintage-frame">
        <h2>★ 1. OPERACIONES Y DOCUMENTACIÓN ★</h2>
        
        <form method="POST" action="">
            <div class="input-group">
                <label for="num1">NÚMERO 1:</label>
                <input type="number" step="any" name="num1" id="num1" required>
            </div>
            
            <div class="input-group">
                <label for="num2">NÚMERO 2:</label>
                <input type="number" step="any" name="num2" id="num2" required>
            </div>
            
            <input type="submit" name="calcular" value="⚡ EJECUTAR OPERACIONES">
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];

            $suma = $num1 + $num2;
            $resta = $num1 - $num2;
            $multiplicacion = $num1 * $num2;

            echo "<div class='resultado'>";
            echo "<h3>✦ RESULTADOS DE EJECUCIÓN ✦</h3>";
            echo "<p><strong>Suma (+):</strong> $num1 + $num2 = $suma</p>";
            echo "<p><strong>Resta (-):</strong> $num1 - $num2 = $resta</p>";
            echo "<p><strong>Multiplicación (*):</strong> $num1 × $num2 = $multiplicacion</p>";

            if ($num2 != 0) {
                $division = $num1 / $num2;
                echo "<p><strong>División (/):</strong> $num1 ÷ $num2 = $division</p>";
            } else {
                echo "<p class='error'><strong>División (/):</strong> No se puede dividir entre cero.</p>";
            }
            echo "</div>";
        }
        ?>

        <div class="doc-section">
            <h3>📖 MANUAL TÉCNICO</h3>
            <p><strong>Propósito:</strong> Procesar dos variables numéricas mediante las cuatro operaciones fundamentales (+, -, *, /)[span_6](start_span)[span_6](end_span)[span_7](start_span)[span_7](end_span).</p>
            <ul>
                <li><code>$num1</code> y <code>$num2</code>: Almacenan las entradas del formulario enviadas con el método <code>POST</code>.</li>
                <li><code>$suma = $num1 + $num2;</code> — Suma de ambos valores[span_8](start_span)[span_8](end_span)[span_9](start_span)[span_9](end_span).</li>
                <li><code>$resta = $num1 - $num2;</code> — Resta del primer número menos el segundo[span_10](start_span)[span_10](end_span)[span_11](start_span)[span_11](end_span).</li>
                <li><code>$multiplicacion = $num1 * $num2;</code> — Producto de ambos números[span_12](start_span)[span_12](end_span)[span_13](start_span)[span_13](end_span).</li>
                <li><code>if ($num2 != 0)</code>: Verifica que el divisor no sea cero antes de ejecutar la división para evitar fallos de ejecución[span_14](start_span)[span_14](end_span)[span_15](start_span)[span_15](end_span).</li>
            </ul>
        </div>

        <a href="../index.php" class="btn-volver">◀ VOLVER AL MENÚ PRINCIPAL</a>
    </div>
</body>
</html>