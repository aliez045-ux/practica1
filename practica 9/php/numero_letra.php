<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Número a Letra</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="btn-back">← Volver al Menú</a>
        <h1>Conversor: Número a Letra</h1>

        <div class="card">
            <form method="POST">
                <label>Ingresa un número (1 al 999):</label>
                <input type="number" name="num" min="1" max="999" required>
                <button type="submit">Convertir</button>
            </form>
        </div>

        <?php
        function numeroALetras($num) {
            $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
            $especiales = [
                10 => 'diez', 11 => 'once', 12 => 'doce', 13 => 'trece', 14 => 'catorce', 
                15 => 'quince', 16 => 'dieciseis', 17 => 'diecisiete', 18 => 'dieciocho', 19 => 'diecinueve',
                20 => 'veinte', 21 => 'veintiuno', 22 => 'veintidos', 23 => 'veintitres', 24 => 'veinticuatro',
                25 => 'veinticinco', 26 => 'veintiseis', 27 => 'veintisiete', 28 => 'veintiocho', 29 => 'veintinueve'
            ];
            $decenas = ['', '', '', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
            $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

            if ($num == 100) return 'cien';

            $c = (int)floor($num / 100);
            $resto_c = $num % 100;
            $d = (int)floor($resto_c / 10);
            $u = $resto_c % 10;

            $texto = '';

            // Centenas
            if ($c > 0) {
                $texto .= $centenas[$c] . ' ';
            }

            // Decenas y Unidades
            if ($resto_c > 0) {
                if (isset($especiales[$resto_c])) {
                    $texto .= $especiales[$resto_c];
                } elseif ($d > 2) {
                    $texto .= $decenas[$d];
                    if ($u > 0) {
                        $texto .= ' y ' . $unidades[$u];
                    }
                } else {
                    $texto .= $unidades[$u];
                }
            }

            return trim($texto);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num'])) {
            $num = (int)$_POST['num'];
            $resultado = numeroALetras($num);

            echo "<div class='card'><h2>Resultado:</h2>";
            echo "<p style='font-family: var(--font-gothic); font-size: 1.8rem; color: var(--text-accent); text-transform: capitalize;'>" . htmlspecialchars($resultado) . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>