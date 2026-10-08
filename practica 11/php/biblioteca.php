<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>3. Biblioteca - Cotización de Libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<?php
// Función para convertir números a texto
function numeroALetras($numero) {
    /** @var string[] */ $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    /** @var string[] */ $decenas  = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    /** @var string[] */ $dieces   = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    /** @var string[] */ $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    $entero = (int)floor($numero);
    if ($entero === 0) {
        return 'Cero';
    }

    $texto = '';

    if ($entero >= 100) {
        if ($entero === 100) {
            $texto .= 'cien ';
        } else {
            $indice = (int)floor($entero / 100);
            $texto .= $centenas[$indice] . ' ';
        }
        $entero %= 100;
    }

    if ($entero >= 10 && $entero <= 19) {
        $texto .= $dieces[$entero - 10] . ' ';
        $entero = 0;
    } elseif ($entero >= 20 && $entero <= 29) {
        if ($entero === 20) {
            $texto .= 'veinte ';
        } else {
            $texto .= 'veinti' . $unidades[$entero % 10] . ' ';
        }
        $entero = 0;
    } elseif ($entero >= 30) {
        $indice = (int)floor($entero / 10);
        $texto .= $decenas[$indice];
        if ($entero % 10 > 0) {
            $texto .= ' y ' . $unidades[$entero % 10] . ' ';
        } else {
            $texto .= ' ';
        }
        $entero = 0;
    }

    if ($entero > 0) {
        $texto .= $unidades[$entero] . ' ';
    }

    return ucfirst(trim($texto));
}

// Paso 2: Formulario para ingresar Título, Costo y Cantidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cuantos_libros'])) {
    $cantidad_libros = intval($_POST['cuantos_libros']);
    echo "<a href='../index.php'>← Regresar al Menú</a><br><br>";
    echo "<h2>3. Cotización de Libros</h2>";
    echo "<form method='POST' action='biblioteca.php'>";
    echo "<input type='hidden' name='procesar_libros' value='1'>";
    echo "<input type='hidden' name='total_libros' value='$cantidad_libros'>";

    for ($i = 1; $i <= $cantidad_libros; $i++) {
        echo "<h4>Libro $i:</h4>";
        echo "Título: <input type='text' name='titulo_$i' required> ";
        echo "Costo ($): <input type='number' step='0.01' name='costo_$i' required> ";
        echo "Cantidad: <input type='number' name='cant_$i' min='1' value='1' required><br><br>";
    }
    echo "<button type='submit'>Generar Cotización</button>";
    echo "</form>";

// Paso 3: Calcular subtotales, IVA, descuento y mostrar reporte
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['procesar_libros'])) {
    $total_libros = intval($_POST['total_libros']);
    $subtotal = 0;

    echo "<a href='../index.php'>← Regresar al Menú</a><br><br>";
    echo "<h2>3. Cotización de Libros</h2>";
    echo "<h3>Reporte de Libros</h3>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>Libro</th><th>Importe</th></tr>";

    for ($i = 1; $i <= $total_libros; $i++) {
        // Validar que existan las llaves en el POST para evitar warnings
        $titulo = isset($_POST["titulo_$i"]) ? htmlspecialchars($_POST["titulo_$i"]) : '';
        $costo = isset($_POST["costo_$i"]) ? floatval($_POST["costo_$i"]) : 0;
        $cant = isset($_POST["cant_$i"]) ? intval($_POST["cant_$i"]) : 1;

        $importe = $costo * $cant;
        $subtotal += $importe;

        echo "<tr>";
        echo "<td>$titulo (x$cant)</td>";
        echo "<td>$" . number_format($importe, 2) . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";

    $iva = $subtotal * 0.16;
    $descuento = ($subtotal > 500) ? ($subtotal * 0.20) : 0;
    $total = ($subtotal + $iva) - $descuento;

    echo "<p><strong>Subtotal (Suma de importes):</strong> $" . number_format($subtotal, 2) . "</p>";
    echo "<p><strong>IVA (16%):</strong> $" . number_format($iva, 2) . "</p>";
    echo "<p><strong>Descuento:</strong> $" . number_format($descuento, 2) . " " . ($descuento > 0 ? "(20% aplicado por compra mayor a $500)" : "(Sin descuento)") . "</p>";
    echo "<h3>Total: $" . number_format($total, 2) . "</h3>";

    $enteros = floor($total);
    $centavos = round(($total - $enteros) * 100);
    $total_en_letras = numeroALetras($enteros) . " pesos " . sprintf("%02d", $centavos) . "/100 M.N.";
    echo "<p><strong>Total en letra:</strong> " . $total_en_letras . "</p>";

    echo "<hr><a href='biblioteca.php'>Nueva Cotización</a>";

// Paso 1: Preguntar la cantidad de libros
} else {
?>
    <a href="../index.php">← Regresar al Menú</a><br><br>
    <h2>3. Cotización de Libros</h2>
    <form method="POST" action="biblioteca.php">
        <label>¿Cuántos libros deseas cotizar?</label><br>
        <input type="number" name="cuantos_libros" min="1" max="20" required><br><br>
        <button type="submit">Ingresar Libros</button>
    </form>
<?php 
}
?>

</body>
</html>