<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Operaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="btn-back">← Volver al Menú</a>
        <h1>Operaciones Matemáticas</h1>

        <div class="card">
            <form method="POST">
                <div>
                    <label>Número 1 (A):</label>
                    <input type="number" step="any" name="num1" required>
                </div>
                <br>
                <div>
                    <label>Número 2 (B):</label>
                    <input type="number" step="any" name="num2">
                </div>
                <br>
                <label>Operación:</label>
                <select name="operacion">
                    <option value="+">Suma (+)</option>
                    <option value="-">Resta (-)</option>
                    <option value="*">Multiplicación (*)</option>
                    <option value="/">División (/)</option>
                    <option value="raiz">Raíz Cuadrada (√ A)</option>
                    <option value="cos">Coseno (cos A)</option>
                    <option value="hip">Hipotenusa (√(A² + B²))</option>
                </select>
                <br><br>
                <button type="submit">Calcular</button>
            </form>
        </div>

        <?php
        if ($_POST) {
            $a = $_POST['num1'];
            $b = isset($_POST['num2']) ? $_POST['num2'] : 0;
            $op = $_POST['operacion'];
            $res = 0;

            switch ($op) {
                case '+': $res = $a + $b; break;
                case '-': $res = $a - $b; break;
                case '*': $res = $a * $b; break;
                case '/': $res = ($b != 0) ? $a / $b : "Error (División por cero)"; break;
                case 'raiz': $res = sqrt($a); break;
                case 'cos': $res = cos(deg2rad($a)); break;
                case 'hip': $res = hypot($a, $b); break;
            }

            echo "<div class='card'><h2>Resultado:</h2>";
            echo "<p style='font-size: 1.6rem; color: var(--text-accent);'><strong>$res</strong></p></div>";
        }
        ?>
    </div>
</body>
</html>