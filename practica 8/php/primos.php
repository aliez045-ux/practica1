<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>4. Primos - P8</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="operaciones.php">1. Operaciones</a>
            <a href="series.php">2. Series</a>
            <a href="alumnos.php">3. Alumnos</a>
            <a href="primos.php" class="activo">4. Primos</a>
            <a href="productos.php">5. Productos</a>
        </nav>

        <h2>4. Números Primos</h2>

        <form action="primos.php" method="POST">
            <label>Límite:</label>
            <input type="number" name="limite" min="2" max="1000" required placeholder="Ej. 30" value="<?php echo isset($_POST['limite']) ? $_POST['limite'] : ''; ?>">
            <button type="submit" name="generar">Obtener Primos</button>
        </form>

        <?php 
        function esPrimo($num) {
            if ($num < 2) return false;
            for ($i = 2; $i <= sqrt($num); $i++) {
                if ($num % $i == 0) return false;
            }
            return true;
        }

        if (isset($_POST['generar'])): 
            $limite = (int)$_POST['limite'];
            $primos = [];

            for ($n = 2; $n <= $limite; $n++) {
                if (esPrimo($n)) {
                    $primos[] = $n;
                }
            }
        ?>
            <h3>Números primos hasta <?php echo $limite; ?></h3>
            <div class="lista-primos">
                <?php foreach ($primos as $p): ?>
                    <span class="chip-primo"><?php echo $p; ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>