<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }

function numeroALetras($numero) {
    $enteros = floor($numero);
    $centavos = round(($numero - $enteros) * 100);
    if (class_exists('NumberFormatter')) {
        $fmt = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        $texto_enteros = $fmt->format($enteros);
    } else {
        $texto_enteros = (string)$enteros;
    }
    return strtoupper($texto_enteros) . " PESOS " . sprintf('%02d', $centavos) . "/100 M.N.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>3. Refaccionaria</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="container">
    <h2>3. Facturación de Refaccionaria</h2>

    <?php if (!isset($_POST['cant_ref']) && !isset($_POST['calcular'])): ?>
        <form method="POST">
            <label>¿Cuántas refacciones son?</label>
            <input type="number" name="cant_ref" min="1" required>
            <input type="submit" value="Continuar">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['cant_ref'])): 
        $cant = $_POST['cant_ref'];
    ?>
        <form method="POST">
            <?php for ($i = 1; $i <= $cant; $i++): ?>
                <h3>Refacción <?php echo $i; ?></h3>
                <label>Refacción:</label> <input type="text" name="refaccion[]" required>
                <label>Costo:</label> <input type="number" step="0.01" name="costo[]" required>
                <label>Cantidad:</label> <input type="number" name="cantidad[]" required>
                <hr style="border: 0; border-top: 1px dashed #732228; margin: 15px 0;">
            <?php endfor; ?>
            <input type="submit" name="calcular" value="Generar Factura">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['calcular'])): 
        $refacciones = $_POST['refaccion'];
        $costos = $_POST['costo'];
        $cantidades = $_POST['cantidad'];
        $importe_total = 0;
    ?>
        <h3>Factura</h3>
        <table>
            <tr>
                <th>Refacción</th>
                <th>Costo Unid.</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
            <?php for ($i = 0; $i < count($refacciones); $i++): 
                $importe = $costos[$i] * $cantidades[$i];
                $importe_total += $importe;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($refacciones[$i]); ?></td>
                <td>$<?php echo number_format($costos[$i], 2); ?></td>
                <td><?php echo $cantidades[$i]; ?></td>
                <td>$<?php echo number_format($importe, 2); ?></td>
            </tr>
            <?php endfor; ?>
        </table>

        <?php 
            $iva = $importe_total * 0.16;
            $total_general = $importe_total + $iva;
            $total_letras = numeroALetras($total_general);
        ?>

        <p><strong>Subtotal (Importe Total):</strong> $<?php echo number_format($importe_total, 2); ?></p>
        <p><strong>IVA (16%):</strong> $<?php echo number_format($iva, 2); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($total_general, 2); ?></p>
        <p><strong>Total en Letra:</strong> <?php echo $total_letras; ?></p>
        
        <br>
        <a href="refaccionaria.php">Nueva Factura</a>
    <?php endif; ?>

    <br><br>
    <a href="menu.php">← Volver al Menú</a>
</div>

</body>
</html>