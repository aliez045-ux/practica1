<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>2. Productos - P7</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="alumnos.php">1. Alumnos</a>
            <a href="productos.php" class="activo">2. Productos</a>
            <a href="series.php">3. Series</a>
        </nav>

        <h2>Cálculo de Productos</h2>

        <form action="productos.php" method="POST">
            <label>Producto:</label>
            <input type="text" name="producto" placeholder="Ej. USB" required value="<?php echo isset($_POST['producto']) ? htmlspecialchars($_POST['producto']) : ''; ?>">
            
            <label>Costo ($):</label>
            <input type="number" name="costo" step="0.01" placeholder="Ej. 200" required value="<?php echo isset($_POST['costo']) ? $_POST['costo'] : ''; ?>">
            
            <label>Cantidad:</label>
            <input type="number" name="cantidad" min="1" placeholder="Ej. 2" required value="<?php echo isset($_POST['cantidad']) ? $_POST['cantidad'] : ''; ?>">
            
            <button type="submit" name="calcular">Calcular Total</button>
        </form>

        <?php if (isset($_POST['calcular'])): 
            $producto = $_POST['producto'];
            $costo = (float)$_POST['costo'];
            $cantidad = (int)$_POST['cantidad'];

            $importe = $costo * $cantidad;
            $iva = $importe * 0.16;
            $subtotal = $importe + $iva;

            $descuento = 0;
            if ($importe > 500) {
                $descuento = $subtotal * 0.20;
            }

            $total_neto = $subtotal - $descuento;
        ?>
            <h3>Resumen de Compra</h3>
            <table>
                <tr>
                    <th>Producto</th>
                    <td><?php echo htmlspecialchars($producto); ?></td>
                </tr>
                <tr>
                    <th>Importe</th>
                    <td>$<?php echo number_format($importe, 2); ?></td>
                </tr>
                <tr>
                    <th>IVA (16%)</th>
                    <td>$<?php echo number_format($iva, 2); ?></td>
                </tr>
                <tr>
                    <th>Subtotal</th>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <tr>
                    <th>Descuento</th>
                    <td>$<?php echo number_format($descuento, 2); ?></td>
                </tr>
                <tr>
                    <th>Total Neto</th>
                    <td><strong>$<?php echo number_format($total_neto, 2); ?></strong></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>