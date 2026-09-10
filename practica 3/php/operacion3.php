<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>3. Ordenar Números</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>3. Ordenar 3 números (- a +)</h2>
        <form method="POST">
            <label>Número 1:</label>
            <input type="number" step="any" name="n1" required>
            <label>Número 2:</label>
            <input type="number" step="any" name="n2" required>
            <label>Número 3:</label>
            <input type="number" step="any" name="n3" required>
            <button type="submit" name="ordenar">Ordenar</button>
        </form>

        <?php
        if (isset($_POST['ordenar'])) {
            $nums = [$_POST['n1'], $_POST['n2'], $_POST['n3']];
            sort($nums);
            echo "<div class='resultado'>";
            echo "<p><strong>Resultado:</strong> " . implode(" < ", $nums) . "</p>";
            echo "</div>";
        }
        ?>
        <a href="../index.php" class="btn-volver">← Volver al Menú</a>
    </div>
</body>
</html>