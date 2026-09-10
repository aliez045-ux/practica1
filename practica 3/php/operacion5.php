<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>5. Cuadrados y Cubos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>5. Cuadrados y Cubos</h2>
        <form method="POST">
            <label>Límite?</label>
            <input type="number" name="limite" min="1" value="10" required>
            <button type="submit" name="generar">Generar Tabla</button>
        </form>

        <?php
        if (isset($_POST['generar'])) {
            $lim = $_POST['limite'];
            echo "<div class='resultado'><table>";
            echo "<tr><th>Número</th><th>x²</th><th>x³</th></tr>";
            for ($i = 1; $i <= $lim; $i++) {
                echo "<tr><td>{$i}</td><td>" . ($i ** 2) . "</td><td>" . ($i ** 3) . "</td></tr>";
            }
            echo "</table></div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>