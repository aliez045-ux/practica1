<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>4. Serie Fibonacci</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>4. Serie Fibonacci</h2>
        <form method="POST">
            <label>Límite?</label>
            <input type="number" name="limite" min="1" value="10" required>
            <button type="submit" name="generar">Generar</button>
        </form>

        <?php
        if (isset($_POST['generar'])) {
            $lim = $_POST['limite'];
            $a = 0; $b = 1; $serie = [];
            for ($i = 0; $i < $lim; $i++) {
                $serie[] = $a;
                $sig = $a + $b; $a = $b; $b = $sig;
            }
            echo "<div class='resultado'>";
            echo "<p>" . implode(", ", $serie) . "</p>";
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>