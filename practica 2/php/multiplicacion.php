<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP: Multiplicación A x B = C</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Multiplicación Básica (a * b = c)</h2>
        <form method="POST">
            <input type="number" name="a" placeholder="Valor de A" required>
            <input type="number" name="b" placeholder="Valor de B" required>
            <input type="submit" value="Calcular">
        </form>

        <?php
        if ($_POST) {
            $a = $_POST['a'];
            $b = $_POST['b'];
            $c = $a * $b;
            echo "<div class='resultado'><h3>$a x $b = $c</h3></div>";
        }
        ?>
        <br>
        <a href="index.php" class="btn">← Volver al Menú Principal</a>
    </div>
</body>
</html>