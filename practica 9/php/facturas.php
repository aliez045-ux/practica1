<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="btn-back">← Volver al Menú</a>
        <h1>Módulo de Facturas</h1>

        <form method="POST" action="">
            <div class="card">
                <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
                    <div>
                        <label>NO. Factura:</label>
                        <input type="text" name="no_factura" required>
                    </div>
                    <div>
                        <label>Fecha:</label>
                        <input type="date" name="fecha" required>
                    </div>
                </div>
                <div>
                    <label>Cliente:</label>
                    <input type="text" name="cliente" style="width:60%;" required>
                </div>
            </div>

            <div class="card">
                <h2>Productos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Costo ($)</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=1; $i<=3; $i++): ?>
                        <tr>
                            <td><input type="text" name="prod[]"></td>
                            <td><input type="number" step="0.01" name="costo[]"></td>
                            <td><input type="number" name="cantidad[]"></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <br>
                <button type="submit" name="calcular">Calcular Factura</button>
            </div>
        </form>

        <?php
        if (isset($_POST['calcular'])) {
            $subtotal = 0;
            $costos = $_POST['costo'];
            $cantidades = $_POST['cantidad'];

            for ($i = 0; $i < count($costos); $i++) {
                if (!empty($costos[$i]) && !empty($cantidades[$i])) {
                    $subtotal += ($costos[$i] * $cantidades[$i]);
                }
            }

            $iva = $subtotal * 0.16;
            $venta = $subtotal + $iva;
            
            // Condición: Venta > 500 aplica 20% Descuento
            $descuento = 0;
            if ($venta > 500) {
                $descuento = $venta * 0.20;
            }

            $total_neto = $venta - $descuento;
            ?>
            <div class="card">
                <h2>Resumen de Factura</h2>
                <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                <p><strong>IVA (16%):</strong> $<?php echo number_format($iva, 2); ?></p>
                <p><strong>Venta:</strong> $<?php echo number_format($venta, 2); ?></p>
                <p><strong>Descuento (20% por venta > 500):</strong> -$<?php echo number_format($descuento, 2); ?></p>
                <hr style="border-color: var(--border-card);">
                <h3>Total Neto: $<?php echo number_format($total_neto, 2); ?></h3>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>