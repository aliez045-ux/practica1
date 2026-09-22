<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenar y Documentación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="vintage-frame">
        <h2>★ 2. ORDENAR Y DOCUMENTACIÓN ★</h2>
        
        <form method="POST" action="">
            <div class="input-group">
                <label for="n1">NÚMERO 1:</label>
                <input type="number" step="any" name="n1" id="n1" required>
            </div>
            
            <div class="input-group">
                <label for="n2">NÚMERO 2:</label>
                <input type="number" step="any" name="n2" id="n2" required>
            </div>
            
            <div class="input-group">
                <label for="n3">NÚMERO 3:</label>
                <input type="number" step="any" name="n3" id="n3" required>
            </div>
            
            <input type="submit" name="ordenar" value="⚡ EJECUTAR ORDENAMIENTO">
        </form>

        <?php
        if (isset($_POST['ordenar'])) {
            $n1 = $_POST['n1'];
            $n2 = $_POST['n2'];
            $n3 = $_POST['n3'];

            $numeros = array($n1, $n2, $n3);
            sort($numeros);

            echo "<div class='resultado'>";
            echo "<h3>✦ RESULTADOS DE EJECUCIÓN ✦</h3>";
            echo "<p class='highlight'>Secuencia Ordenada (- a +): " . implode(" , ", $numeros) . "</p>";
            echo "</div>";
        }
        ?>

        <div class="doc-section">
            <h3>📖 MANUAL TÉCNICO</h3>
            <p><strong>Propósito:</strong> Ordenar tres valores numéricos en secuencia ascendente de menor a mayor[span_16](start_span)[span_16](end_span)[span_17](start_span)[span_17](end_span).</p>
            <ul>
                <li><code>array($n1, $n2, $n3)</code>: Empaqueta los tres valores ingresados en un arreglo unidimensional.</li>
                <li><code>sort($numeros)</code>: Función propia de PHP que ordena el arreglo internamente de menor/negativo a mayor/positivo[span_18](start_span)[span_18](end_span)[span_19](start_span)[span_19](end_span).</li>
                <li><code>implode(" , ", $numeros)</code>: Junta los datos del arreglo ordenado separados por comas para mostrarlos en pantalla.</li>
            </ul>
        </div>

        <a href="../index.php" class="btn-volver">◀ VOLVER AL MENÚ PRINCIPAL</a>
    </div>
</body>
</html>