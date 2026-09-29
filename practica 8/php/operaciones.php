<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>1. Operaciones - P8</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="operaciones.php" class="activo">1. Operaciones</a>
            <a href="series.php">2. Series</a>
            <a href="alumnos.php">3. Alumnos</a>
            <a href="primos.php">4. Primos</a>
            <a href="productos.php">5. Productos</a>
        </nav>

        <h2>1. Operaciones Básicas</h2>

        <form action="operaciones.php" method="POST">
            <label>Número 1:</label>
            <input type="number" name="num1" step="any" required placeholder="Ej. 10" value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : ''; ?>">
            
            <label>Número 2:</label>
            <input type="number" name="num2" step="any" required placeholder="Ej. 2" value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : ''; ?>">
            
            <button type="submit" name="calcular">Calcular Operaciones</button>
        </form>

        <?php if (isset($_POST['calcular'])): 
            $n1 = (float)$_POST['num1'];
            $n2 = (float)$_POST['num2'];

            $suma = $n1 + $n2;
            $resta = $n1 - $n2;
            $mult = $n1 * $n2;
            $div = ($n2 != 0) ? ($n1 / $n2) : "Error (División por 0)";
            $potencia = pow($n1, $n2);
        ?>
            <h3>Resultados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Operación</th>
                        <th>Expresión</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Suma (+)</td><td><?php echo "$n1 + $n2"; ?></td><td><?php echo $suma; ?></td></tr>
                    <tr><td>Resta (-)</td><td><?php echo "$n1 - $n2"; ?></td><td><?php echo $resta; ?></td></tr>
                    <tr><td>Multiplicación (*)</td><td><?php echo "$n1 * $n2"; ?></td><td><?php echo $mult; ?></td></tr>
                    <tr><td>División (/)</td><td><?php echo "$n1 / $n2"; ?></td><td><?php echo is_numeric($div) ? number_format($div, 2) : $div; ?></td></tr>
                    <tr><td>Potencia (^)</td><td><?php echo "$n1 ^ $n2"; ?></td><td><?php echo $potencia; ?></td></tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>