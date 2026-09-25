<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>3. Series - P7</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="alumnos.php">1. Alumnos</a>
            <a href="productos.php">2. Productos</a>
            <a href="series.php" class="activo">3. Series</a>
        </nav>

        <h2>Generador de Series Numéricas</h2>

        <form action="series.php" method="POST">
            <label>Límite:</label>
            <input type="number" name="limite" min="1" max="100" placeholder="Ej. 10" required value="<?php echo isset($_POST['limite']) ? $_POST['limite'] : ''; ?>">
            <button type="submit" name="generar">Generar Series</button>
        </form>

        <?php if (isset($_POST['generar'])): 
            $limite = (int)$_POST['limite'];

            $pares = [];
            for ($i = 1; count($pares) < $limite; $i++) {
                if ($i % 2 == 0) {
                    $pares[] = $i;
                }
            }

            $impares = [];
            for ($i = 1; count($impares) < $limite; $i++) {
                if ($i % 2 != 0) {
                    $impares[] = $i;
                }
            }

            $fibonacci = [];
            $a = 0;
            $b = 1;
            for ($i = 0; $i < $limite; $i++) {
                $fibonacci[] = $a;
                $temp = $a + $b;
                $a = $b;
                $b = $temp;
            }
        ?>
            <h3>Resultados (Límite: <?php echo $limite; ?>)</h3>
            <div class="grid-series">
                <div class="columna-serie">
                    <h4>Pares</h4>
                    <hr>
                    <?php foreach ($pares as $num): ?>
                        <div><?php echo $num; ?></div>
                    <?php endforeach; ?>
                </div>

                <div class="columna-serie">
                    <h4>Impares</h4>
                    <hr>
                    <?php foreach ($impares as $num): ?>
                        <div><?php echo $num; ?></div>
                    <?php endforeach; ?>
                </div>

                <div class="columna-serie">
                    <h4>Fibonacci</h4>
                    <hr>
                    <?php foreach ($fibonacci as $num): ?>
                        <div><?php echo $num; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>