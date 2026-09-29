<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>5. Productos - P8</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="operaciones.php">1. Operaciones</a>
            <a href="series.php">2. Series</a>
            <a href="alumnos.php">3. Alumnos</a>
            <a href="primos.php">4. Primos</a>
            <a href="productos.php" class="activo">5. Productos</a>
        </nav>

        <h2>5. Registro de Productos</h2>

        <?php if (!isset($_POST['paso2']) && !isset($_POST['paso3'])): ?>
            <form action="productos.php" method="POST">
                <label>¿Cantidad de productos?:</label>
                <input type="number" name="num_productos" min="1" required placeholder="Ej. 2">
                <button type="submit" name="paso2">Continuar</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['paso2'])): 
            $num = (int)$_POST['num_productos'];
        ?>
            <form action="productos.php" method="POST">
                <input type="hidden" name="num_productos" value="<?php echo $num; ?>">
                <?php for ($i = 1; $i <= $num; $i++): ?>
                    <div class="bloque-item">
                        <h3>Producto <?php echo $i; ?></h3>
                        <label>Producto:</label>
                        <input type="text" name="producto[]" required placeholder="Ej. USB">
                        <label>Costo ($):</label>
                        <input type="number" name="costo[]" step="0.01" min="0" required placeholder="Ej. 200">
                        <label>Cantidad:</label>
                        <input type="number" name="cantidad[]" min="1" required placeholder="Ej. 2">
                    </div>
                <?php endfor; ?>
                <button type="submit" name="paso3">Calcular Total</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['paso3'])): 
            $productos = $_POST['producto'];
            $costos = $_POST['costo'];
            $cantidades = $_POST['cantidad'];
            $importe_total = 0;
            $total_items = count($productos);
        ?>
            <h3>Detalle de Compras</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < $total_items; $i++): 
                        $costo = (float)$costos[$i];
                        $cantidad = (int)$cantidades[$i];
                        $imp = $costo * $cantidad;
                        $importe_total += $imp;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($productos[$i]); ?></td>
                            <td>$<?php echo number_format($costo, 2); ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td>$<?php echo number_format($imp, 2); ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <?php 
                $iva = $importe_total * 0.16;
                $subtotal = $importe_total + $iva;
                
                // Regla del pizarrón: Importe/Subtotal > 500 -> 20% descuento
                if ($subtotal > 500) {
                    $descuento = $subtotal * 0.20;
                } else {
                    $descuento = 0;
                }

                $total_neto = $subtotal - $descuento;
            ?>

            <div style="margin-top: 20px;">
                <table>
                    <tr>
                        <th>Importe Total:</th>
                        <td>$<?php echo number_format($importe_total, 2); ?></td>
                    </tr>
                    <tr>
                        <th>IVA (16%):</th>
                        <td>$<?php echo number_format($iva, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Subtotal:</th>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Descuento (<?php echo ($subtotal > 500) ? '20%' : '0%'; ?>):</th>
                        <td>-$<?php echo number_format($descuento, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Total Neto:</th>
                        <td><strong>$<?php echo number_format($total_neto, 2); ?></strong></td>
                    </tr>
                </table>
            </div>
            <br>
            <a href="productos.php"><button type="button">Nuevo Registro</button></a>
        <?php endif; ?>
    </div>
</body>
</html>