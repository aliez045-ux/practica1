<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórmula General y Documentación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="vintage-frame">
        <h2>★ 3. FÓRMULA GENERAL Y DOCUMENTACIÓN ★</h2>
        
        <form method="POST" action="">
            <div class="input-group">
                <label for="a">COEFICIENTE A:</label>
                <input type="number" step="any" name="a" id="a" required>
            </div>
            
            <div class="input-group">
                <label for="b">COEFICIENTE B:</label>
                <input type="number" step="any" name="b" id="b" required>
            </div>
            
            <div class="input-group">
                <label for="c">COEFICIENTE C:</label>
                <input type="number" step="any" name="c" id="c" required>
            </div>
            
            <input type="submit" name="calcular" value="⚡ RESOLVER ECUACIÓN">
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $a = $_POST['a'];
            $b = $_POST['b'];
            $c = $_POST['c'];

            echo "<div class='resultado'>";
            echo "<h3>✦ RESULTADOS DE EJECUCIÓN ✦</h3>";
            if ($a == 0) {
                echo "<p class='error'><strong>Error:</strong> El coeficiente 'a' no puede ser cero.</p>";
            } else {
                $r = ($b * $b) - (4 * $a * $c);
                echo "<p><strong>Discriminante (r):</strong> $r</p>";

                if ($r >= 0) {
                    $r2 = sqrt($r);
                    $x1 = (-$b + $r2) / (2 * $a);
                    $x2 = (-$b - $r2) / (2 * $a);

                    echo "<p><strong>X1 =</strong> " . round($x1, 4) . "</p>";
                    echo "<p><strong>X2 =</strong> " . round($x2, 4) . "</p>";
                } else {
                    echo "<p class='error'><strong>Sin solución real:</strong> Dado que r es negativo (r < 0), la raíz no tiene solución en el conjunto de los reales.</p>";
                }
            }
            echo "</div>";
        }
        ?>

        <div class="doc-section">
            <h3>📖 MANUAL TÉCNICO</h3>
            <p><strong>Propósito:</strong> Resolver ecuaciones cuadráticas $ax^2 + bx + c = 0$ validando el discriminante[span_20](start_span)[span_20](end_span)[span_21](start_span)[span_21](end_span).</p>
            <ul>
                <li><code>$r = ($b * $b) - (4 * $a * $c);</code>: Calcula el discriminante $r$ para evaluar si la raíz es computable[span_22](start_span)[span_22](end_span)[span_23](start_span)[span_23](end_span).</li>
                <li><code>if ($r >= 0)</code>: Valida que el discriminante sea positivo o cero para obtener resultados reales[span_24](start_span)[span_24](end_span)[span_25](start_span)[span_25](end_span).</li>
                <li><code>$r2 = sqrt($r);</code>: Extrae la raíz cuadrada del discriminante[span_26](start_span)[span_26](end_span)[span_27](start_span)[span_27](end_span).</li>
                <li><code>$x1 = (-$b + $r2) / (2 * $a);</code> y <code>$x2 = (-$b - $r2) / (2 * $a);</code>: Evalúan los dos signos ($\pm$) de la fórmula cuadrática[span_28](start_span)[span_28](end_span)[span_29](start_span)[span_29](end_span).</li>
                <li><code>else</code>: Advierte si el discriminante es negativo impidiendo raíces imaginarias[span_30](start_span)[span_30](end_span).</li>
            </ul>
        </div>

        <a href="../index.php" class="btn-volver">◀ VOLVER AL MENÚ PRINCIPAL</a>
    </div>
</body>
</html>