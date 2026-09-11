<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP: Ordenar 3 Números</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Ordenar 3 Números (+ / -)</h2>
        <form method="POST">
            <input type="number" name="n1" placeholder="Número 1" required>
            <input type="number" name="n2" placeholder="Número 2" required>
            <input type="number" name="n3" placeholder="Número 3" required>
            <input type="submit" value="Ordenar">
        </form>

        <?php
        if ($_POST) {
            $num = array($_POST['n1'], $_POST['n2'], $_POST['n3']);
            
            $asc = $num; sort($asc);
            $desc = $num; rsort($desc);

            echo "<div class='resultado'>";
            echo "<p><strong>Ascendente (+):</strong> " . implode(", ", $asc) . "</p>";
            echo "<p><strong>Descendente (-):</strong> " . implode(", ", $desc) . "</p>";
            echo "</div>";
        }
        ?>
        <br>
        <a href="index.php" class="btn">← Volver al Menú Principal</a>
    </div>
</body>
</html>